<?php
/**
 * Encryption class that concentrates all encryption/decryption related fuctionality
 *
 *
 *
 * @package esUriEncryptionPlugin
 * @author Jorgo Miridis
 * @copyright Copyright (c) 2011
 * @version $Id$
 * @access public
 */
class Encryption
{
  /**
   * Provides a secret key to be used for encryption/decryption
   *
   * The encryption key can be set in the app.yml file using the variable:
   *   es_uri_encryption_plugin/secret
   * If not provided, a default secret key will be used.
   *
   * @return string encryption key
   */
  static protected function getKey()
  {
    return sfConfig::get('app_esUriEncryptionPlugin_secret', '7%&js92k%@J+__4uew(*&');
  }

  static protected function safe_b64encode($string)
  {
    return str_replace(array('+','/','='), array('-','_',''), base64_encode($string));
  }

  static protected function safe_b64decode($string)
  {
    $string = str_pad($string, (int)ceil(strlen($string)/4)*4, '=', STR_PAD_RIGHT);

    return base64_decode(str_replace(array('-','_'), array('+','/'), $string));
  }

  static public function encode($value)
  {
    if(!$value)
    {
      return false;
    }

    $iv_size   = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv        = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::getKey(), $value, MCRYPT_MODE_ECB, $iv);

    return trim(self::safe_b64encode($crypttext));
  }

  static public function decode($value)
  {
    if(!$value)
    {
      return false;
    }

    $iv_size     = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv          = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::getKey(), self::safe_b64decode($value), MCRYPT_MODE_ECB, $iv);

    return trim($decrypttext);
  }

  /**
   * Converts a URI (string) into an associative array with the following keys:
   *  - module : a string containing the module name
   *  - action : a string containing the action name
   *  - parameters : an associative array with key/value pairs
   *
   * @param string $uri some URI as a string
   * @return array associative array containing module, action and parameters.
   */
  static protected function uriToArray($uri)
  {
    //--------------------------------------------------------------------------
    // extract information from the internal url $uri using the controller;
    // the result is an array that contains the route's name in $results[0]
    // and the url parameters in $results[1].
    // if the $uri is not based on a routing name but on a module/action string,
    // $result[0] is empty and $result[1] will contain the 2 additional
    // parameters 'module' and 'action'.
    //--------------------------------------------------------------------------
    $result = sfContext::getInstance()->getController()->convertUrlStringToParameters($uri);
    if(isset($result[0]) and !empty($result[0]))
    {
      //------------------------------------------------------------------------
      // the URI is based on a routing name
      // look for the routing name in all routes to determine module & action
      //------------------------------------------------------------------------
      $routing = sfContext::getInstance()->getRouting();
      foreach($routing->getRoutes() as $routeName => $routeObject)
      {
        if($routeName == $result[0])
        {
          $defaults = $routeObject->getDefaults();
          $result[1]['module'] = $defaults['module'];
          $result[1]['action'] = $defaults['action'];
        }
      }
    }

    return $result[1];
  }

  /**
   * Converts a URI into an encrypted string
   *
   * @param string $uri some internal URL
   * @param integer $sfGuardUserId id of an existing sfGuard user
   * @return string encrypted URI as a string
   */
  static public function encryptUri($uri, $sfGuardUserId=null)
  {
    //--------------------------------------------------------------------------
    // convert URI into an array containing module, action and parameters
    //--------------------------------------------------------------------------
    $uriArray = self::uriToArray($uri);
    //--------------------------------------------------------------------------
    // extract module and action from array, then remove them
    // the remaining key/value pairs are parameters
    //--------------------------------------------------------------------------
    $module = $uriArray['module'];
    $action = $uriArray['action'];
    unset($uriArray['module'], $uriArray['action']);
    //--------------------------------------------------------------------------
    // serialize module, action, parameters and sfGuardUserId and encrypt them
    //--------------------------------------------------------------------------
    $parameters       = http_build_query($uriArray);
    $string           = sprintf('%s::%s::%s::%s', $module, $action, $parameters, $sfGuardUserId);
    $encrypted_string = self::encode($string);
    //--------------------------------------------------------------------------
    // register request parameters in log file
    //--------------------------------------------------------------------------
    if(sfConfig::get('app_esUriEncryptionPlugin_debug'))
    {
      sfContext::getInstance()->getLogger()->debug('esUriEncryptionPlugin: encrypting URI');
      sfContext::getInstance()->getLogger()->debug('  unencrypted: '. $uri);
      sfContext::getInstance()->getLogger()->debug('  encrypted:   '. $encrypted_string);
    }

    return $encrypted_string;
  }

  /**
   * Converts a URI into an encrypted URL
   *
   * @param string $uri some internal URL
   * @param integer $sfGuardUserId id of an existing sfGuard user
   * @return string encrypted URI as a string
   */
  static public function getEncryptedUrlFromUri($uri, $sfGuardUserId=null, $frontController=true)
  {
    //--------------------------------------------------------------------------
    // build external URL based on the plugin provided rule '@encrypted_access'
    //--------------------------------------------------------------------------
    $external_url = sfContext::getInstance()->getController()->genUrl('@encrypted_access?encrypted_uri='.self::encryptUri($uri, $sfGuardUserId), true);
    //--------------------------------------------------------------------------
    // strip name of the script
    //--------------------------------------------------------------------------
    if(!$frontController)
    {
      $external_url = preg_replace('%/[a-z]+_[a-z]{3,4}\.php%', '', $external_url);
    }
    //--------------------------------------------------------------------------
    // log external URL if debugging is switched on
    //--------------------------------------------------------------------------
    if(sfConfig::get('app_esUriEncryptionPlugin_debug'))
    {
      sfContext::getInstance()->getLogger()->debug('esUriEncryptionPlugin: encrypted URL created');
      sfContext::getInstance()->getLogger()->debug("  URL: $external_url");
    }

    return $external_url;
  }

  /**
   * Decrypts an encrypted URI and returns module, action, parameters & sfGuardUserId
   *
   * @param mixed $string
   * @return array Array containing, 'module', 'action', 'parameters' and 'sfGuardUserId'
   */
  static public function decryptUri($encrypted_string)
  {
    //--------------------------------------------------------------------------
    // decrypt the encrypted URI
    // @todo -cEncryption add some kind of exception if decryption could not
    //                    be performed or returned invalid data
    //--------------------------------------------------------------------------
    $decrypted = self::decode($encrypted_string);
    //--------------------------------------------------------------------------
    // for legacy reasons, the decrypted string
    // old version must be tested against the following values:
    // encrypted_string: E_H4qGN1-6J7MZPXNVtbRG7nKoBwbL4WPGiZS6-jGyDmOJ_zyLtLViCeY31OcoXg-3kaI6g8e6kYuxN_BIkPuA
    // module: reservation
    // action: access
    // parameters: array('user_id' => 5, 'uniqid'  => '5CYT1')
    //--------------------------------------------------------------------------
    if(preg_match('%.+::.+%', $decrypted))
    {
      list($result['module'], $result['action'], $result['parameters'], $result['sfGuardUserId']) = preg_split('/::/', $decrypted);
      //------------------------------------------------------------------------
      // convert url-encoded parameters to array
      //------------------------------------------------------------------------
      parse_str($result['parameters'], $parameters);
      $result['parameters'] = $parameters;
    }
    else
    {
      parse_str($decrypted, $parameters);
      $result['module']        = $parameters['module'];
      $result['action']        = $parameters['action'];
      $result['sfGuardUserId'] = $parameters['user_id'];
      unset($parameters['module'], $parameters['action'], $parameters['user_id']);

      $result['parameters'] = $parameters;
    }
    //--------------------------------------------------------------------------
    // register decrypted parameters in log file
    //--------------------------------------------------------------------------
    if(sfConfig::get('app_esUriEncryptionPlugin_debug'))
    {
      sfContext::getInstance()->getLogger()->debug('esUriEncryptionPlugin: decrypting URI');
      foreach($result as $key => $value)
      {
        if(is_array($value))
        {
          sfContext::getInstance()->getLogger()->debug("  $key: ". join(',', $value));
        }
        else
        {
          sfContext::getInstance()->getLogger()->debug("  $key: $value");
        }
      }
    }

    return $result;
  }
}
