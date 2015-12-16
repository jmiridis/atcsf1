<?php

/**
 * Base actions for the esUriEncryptionPlugin esUriEncryptionAccess module.
 *
 * @package     esUriEncryptionPlugin
 * @subpackage  esUriEncryptionAccess
 * @author      Jorgo Miridis <jorgo@miridis.com>
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BaseesUriEncryptionAccessActions extends sfActions
{
  /**
   * executes an action defined by an ecrypted url parameter bypassing authentication
   * This action must be called with the request parameter 'encrypted_uri'
   * containing the target module/action and optional parameters encrypted
   * using the class 'Encryption'.
   *
   * Example:
   *  Encryption::encode('module=myModule&action=myAction&param1=value1, ...');
   *
   * @param sfWebRequest $request
   * @return
   */
  public function executeIndex(sfWebRequest $request)
  {
    //--------------------------------------------------------------------------
    // make sure required parameter 'encrypted_uri' is provided
    //--------------------------------------------------------------------------
    $this->forward404If(!$encrypted_uri = $request->getParameter('encrypted_uri'));
    //--------------------------------------------------------------------------
    // decrypt parameters
    //  v1: 'action', 'module', 'parameters' & 'sfGuardUserId'
    //  v2: 'uri' & 'sfGuardUserId'
    //--------------------------------------------------------------------------
    $data = Encryption::decryptUri($encrypted_uri);
    //--------------------------------------------------------------------------
    // make sure required 'uri' is provided
    //--------------------------------------------------------------------------
    $this->forward404If(!isset($data['module']) or !isset($data['action']));

    $request->setParameter('module', $data['module']);
    $request->setParameter('action', $data['action']);

    if(is_array($data['parameters']))
    {
      foreach($data['parameters'] as $key => $value)
      {
        $request->setParameter($key, $value);
      }
    }
    //--------------------------------------------------------------------------
    // handle automatic authentication if turned on, otherwise skip it
    //--------------------------------------------------------------------------
    if($data['sfGuardUserId'] > 0 and sfConfig::get('app_esUriEncryptionPlugin_authenticate'))
    {
      //------------------------------------------------------------------------
      // make sure sfGuardPlugin is installed and enabled
      //------------------------------------------------------------------------
      if(!class_exists('sfGuardUser'))
      {
        throw new sfException('esUriEncryptionPlugin: sfGuardPlugin not found - cannot authenticate.');
      }
      //------------------------------------------------------------------------
      // determine user identified by sfGuardUserId
      //------------------------------------------------------------------------
      if($user = Doctrine::getTable('sfGuardUser')->find($data['sfGuardUserId']))
      {
        $this->getUser()->signin($user);
      }

      if(sfConfig::get('app_esUriEncryptionPlugin_debug'))
      {
        sfContext::getInstance()->getLogger()->debug('esUriEncryptionPlugin: user logged in, id='.$data['sfGuardUserId']);
      }
    }
    //--------------------------------------------------------------------------
    // forward to destination action
    //--------------------------------------------------------------------------
    $this->forward($data['module'], $data['action']);
  }

  public function executeTest(sfWebRequest $request)
  {
    $this->url = Encryption::getEncryptedUrlFromUri('@encryption_test1?param1=12345');
  }
}

