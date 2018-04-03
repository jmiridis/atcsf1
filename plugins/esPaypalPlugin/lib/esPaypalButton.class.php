<?php
require_once sfConfig::get('sf_symfony_lib_dir')."/helper/UrlHelper.php";

class esPaypalButton implements  ArrayAccess, Iterator, Countable
{
  const BUTTON_TYPE_BUYNOW          = 1;
  const BUTTON_TYPE_CART            = 2;
  const BUTTON_TYPE_GIFTCERTIFICATE = 3;
  const BUTTON_TYPE_SUBSCRIBE       = 4;
  const BUTTON_TYPE_DONATE          = 5;
  const BUTTON_TYPE_PAYMENTPLAN     = 6;

  static
  $ppProductionUrl = 'https://www.paypal.com/cgi-bin/webscr',
  $ppSandboxUrl    = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

  protected
    $imageUrl,
    $count = 0,
    $fields = array(),
    $testMode = null,
    $error;

  protected
    $btn_type2cmd = array(
      1 => '_xclick',
      2 => '_cart',
      3 => '_oe-gift-certificate',
      4 => '_xclick-subscriptions',
      5 => '_donations',
      6 => '_xclick-payment-plan'
    );

  /**
   *
   *
   * BUTTONCODE
   *  - HOSTED    - A secure button stored on PayPal; default for all buttons except View Cart, Unsubscribe, and Pay Now
   *  - ENCRYPTED - An encrypted button, not stored on PayPal; default for View Cart button
   *  - CLEARTEXT - An unencrypted button, not stored on PayPal; default for Unsubscribe button
   *  - TOKEN     - A secure button, not stored on PayPal, used only to initiate the Hosted Solution checkout flow; default for Pay Now button. Since version 65.1
   *
   * BUTTONTYPE
   *  - BUYNOW | _xclick | Buy Now button
   *  - CART | _cart | Add to Cart button
   *  - GIFTCERTIFICATE | _oe-gift-certificate | Gift Certificate button
   *  - SUBSCRIBE | _xclick-subscriptions | Subscribe button
   *  - DONATE | _donations | Donate button
   *  - PAYMENTPLAN | _xclick-payment-plan | Installment Plan button; since version 63.0
   *  NOTE: Do not specify BUYNOW if BUTTONCODE=TOKEN; specify PAYMENT instead. Do not specify PAYMENT if BUTTONCODE=HOSTED.
   *
   * @param mixed $type
   * @param mixed $testmode
   * @return
   */
  function __construct($buttonType=BUTTON_TYPE_BUYNOW, $testMode=null)
  {
    $this->testMode   = ($testMode === null)? sfConfig::get('app_es_paypal_plugin_test_mode', true) : $testMode;
    $this->buttonType = $buttonType;

    $this['business'] = sfConfig::get('app_es_paypal_plugin_business');
    $this['cmd'] = $this->btn_type2cmd[$this->buttonType];

    $this['rm'] = sfConfig::get('app_es_paypal_plugin_return_method', 2);
//    $this['bn'] = 'American Transfers';

    $callback  = sfConfig::get('app_es_paypal_plugin_callback');

    $this['notify_url']    = (url_for($callback['notify']? $callback['notify'] : '@paypal_ipn',     true));
    $this['return']        = (url_for($callback['return']? $callback['return'] : '@paypal_return', true));
    $this['cancel_return'] = (url_for($callback['cancel']? $callback['cancel'] : '@paypal_cancel', true));

    foreach(sfConfig::get('app_es_paypal_plugin_checkout') as $key => $value)
    {
      $this[$key] = $value;
    }

  }

  public function setReturnUrlParameters($parameters)
  {
    array_walk($parameters, function(&$v, $k){ $v="$k=$v";} );

    $this['return'] = $this['return'] . '?' . join('&', $parameters);
  }

  /**
   * setParameters()
   *
   * @param mixed $parameters
   * @return
   */
  public function setParameters($parameters)
  {
    foreach($parameters as $name => $value)
    {
      $this[$name] = $value;
    }
    $this->count = $this->count();
  }

  /**
   * renderHosted()
   *
   * @param mixed $hostedButtonId
   * @return
   */
  public function renderHosted($hostedButtonId)
  {
    $parameters = $this->fields;

    $parameters['hosted_button_id'] = $hostedButtonId;

    return $this->render($parameters);
  }

  /**
   * renderEncrypted()
   *
   * @return
   */
  public function renderEncrypted()
  {
    //--------------------------------------------------------------------------
    // retrieve certificate from app.yml
    //--------------------------------------------------------------------------
    $certificate = sfConfig::get('app_es_paypal_plugin_certificate');

    if(!is_array($certificate))
    {
      throw new sfException('No Paypal certificate defined in app.yml. Please define: app_es_paypal_plugin_certificate');
    }
    //--------------------------------------------------------------------------
    // make sure alla certificate data is defined
    //--------------------------------------------------------------------------
    if($undefined = array_diff(array('ewp_cert_fname','ewp_prvkey_fname','pp_cert_fname'), array_keys($certificate)))
    {
      throw new sfException('Paypal button encryption detected missing certificate fields in app.yml. Please define: ', join(',', $undefined));
    }

    sfContext::getInstance()->getLogger()->alert('esPaypalButton: encrypting data ...');
    sfContext::getInstance()->getLogger()->warning('ewp_cert_fname: '.$certificate['ewp_cert_fname']);
    sfContext::getInstance()->getLogger()->warning('ewp_prvkey_fname: '.$certificate['ewp_prvkey_fname']);
    sfContext::getInstance()->getLogger()->warning('pp_cert_fname: '.$certificate['pp_cert_fname']);
    //--------------------------------------------------------------------------
    // setup certificates
    //--------------------------------------------------------------------------
    $pp_encryptor  = new esPaypalEncryptor();
    $pp_encryptor->setCertificate($certificate['ewp_cert_fname'], $certificate['ewp_prvkey_fname']);
    $pp_encryptor->setCertificateID($certificate['cert_id']);
    $pp_encryptor->setPayPalCertificate($certificate['pp_cert_fname']);
    //--------------------------------------------------------------------------
    // define button fields
    //--------------------------------------------------------------------------
    $parameters = array(
      'cmd'       => '_s-xclick',
      'encrypted' => $pp_encryptor->encryptData($this->fields)
    );

    return $this->render($parameters);
  }

  /**
   * renderUnEncrypted()
   *
   * @return
   */
  public function renderUnEncrypted()
  {
      return $this->render($this->fields);
  }

  /**
   * Creates the form element containing hidden input fields with post parameters.
   *
   * @return string HTML code of the complete form element
   */
  protected function render($parameters)
  {
    sfContext::getInstance()->getLogger()->warning('esPaypalButton: creating button ...');

    $html = array();
    foreach ($parameters as $name => $value)
    {
      sfContext::getInstance()->getLogger()->warning("$name = $value");
      $html[] = tag('input', array('type'=>'hidden', 'name'=>$name, 'value'=>$value));
    }
//    $html[] = tag('input', array('type'=>'hidden', 'name'=>'cert_id', 'value'=>'ERC56ZCBB6AVY'));

    return form_tag($this->getPaypalUrl(), array('method'=>'post')) .
       join("\n", $html) .
       tag('input', array('type'=>'image', 'src'=>$this->getImageUrl(), 'alt'=>$this->getAltText())) .
       '</form>';
  }

  /**
   * getPaypalUrl()
   *
   * @return
   */
  protected function getPaypalUrl()
  {
    return $this->testMode? self::$ppSandboxUrl : self::$ppProductionUrl;
  }

  /**
   * getImagerUrl()
   *
   * @return
   */
  protected function getImageUrl()
  {
    return $this->imageUrl? $this->imageUrl : $this->getDefaultImageUrl();
  }

  /**
   * getAltText()
   *
   * @return
   */
  protected function getAltText()
  {
    return 'PayPal - The safer, easier way to pay online!';
  }

  /**
   * getDefaultImageUrl()
   *
   * @return
   */
  protected function getDefaultImageUrl()
  {
    return sfConfig::get('app_es_paypal_plugin_image_url', 'https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif');
  }

  /**
   * Resets the field names array to the beginning (implements the Iterator interface).
   */
  public function rewind()
  {
    reset($this->fields);
    $this->count = $this->count();
  }

  /**
   * Gets the key associated with the current form field (implements the Iterator interface).
   *
   * @return string The key
   */
  public function key()
  {
    return key($this->fields);
  }

  /**
   * Returns the current form field (implements the Iterator interface).
   *
   * @return mixed The escaped value
   */
  public function current()
  {
    return current($this->fields);
  }

  /**
   * Moves to the next form field (implements the Iterator interface).
   */
  public function next()
  {
    next($this->fields);
    --$this->count;
  }

  /**
   * Returns true if the current form field is valid (implements the Iterator interface).
   *
   * @return boolean The validity of the current element; true if it is valid
   */
  public function valid()
  {
    return $this->count > 0;
  }

  /**
   * Returns the number of form fields (implements the Countable interface).
   *
   * @return integer The number of button parameters
   */
  public function count()
  {
    return count($this->fields);
  }

  /**
   * Returns true if the field exists (implements the ArrayAccess interface).
   *
   * @param  string $offset The offset of the  field
   *
   * @return Boolean true if the field exists, false otherwise
   */
  public function offsetExists($offset)
  {
    return isset($this->fields[$offset]);
  }
  /**
   * Returns the button field value associated with the offset (implements the ArrayAccess interface).
   *
   * @param  string $offset  The offset of the value to get
   *
   * @return string  The button field value
   */
  public function offsetGet($offset)
  {
    return isset($this->fields[$offset])? $this->fields[$offset] : null;
  }

  /**
   * Adds or updates the button field with the specified offset. (implements the ArrayAccess interface).
   *
   * @param string $offset The field offset
   * @param string $value The field value
   *
   */
  public function offsetSet($offset, $value)
  {
    $this->fields[$offset] = $value;
    $this->rewind();
  }

  /**
   * Removes a field from the button.
   *
   * It removes the field with the given offset.
   *
   * @param string $offset The field offset
   */
  public function offsetUnset($offset)
  {
    unset($this->fields[$offset]);
    $this->rewind();
  }
}