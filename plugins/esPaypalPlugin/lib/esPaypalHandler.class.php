<?php
require_once sfConfig::get('sf_symfony_lib_dir')."/helper/UrlHelper.php";

/**
 * This class implements an interface for Paypal's 'Web Payments Standard'
 *
 * The process of handling payments via Paypal requires the following main operation:
 *  - creation of Paypal buttons
 *  - handling of IPN requests
 *  - storing of transaction data
 *  -
 *
 * IPN validation ...
 * ------------------
 * ... can be implemented by calling the method validateIPN($parameters)as
 * shown in the following example code inside a Symfony action:
 * <code>
 * $pp = new sfPaypalPayment();
 * $pp->enableTestMode();  // optional
 * if($pp->validateIpn($request->getPostParameters()))
 * {
 *   $order = $pp->getItem();
 *   // handle order status, etc.
 * }
 * else
 * {
 *   // handle validation errors ()
 * }
 * </code>
 * the actions $request
 * After a call to validate
 */

class esPaypalHandler implements ArrayAccess, Iterator, Countable
{
  static
    $ppProductionUrl = 'https://www.paypal.com/cgi-bin/webscr',
    $ppSandboxUrl    = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

  protected
    $testMode,
    $debugMode,
    $lastError = '',
    $count = 0,
    $ipnData = array(),
    $config = array(),
    $relatedEntity,
    $entityError;


  function __construct()
  {
    $this->debugMode = sfConfig::get('app_es_paypal_plugin_debug_mode');
    $this->testMode  = sfConfig::get('app_es_paypal_plugin_test_mode');

    $this->setup();
  }

  /**
   * esPaypalHandler::handleIpn()
   *
   * @param array $parameters
   * @return
   */
  public function handleIpn($parameters)
  {
    $this->debug('IPN access from Paypal');

    return $this->handlePaypalData($parameters, true);
  }

  /**
   * esPaypalHandler::handleReturn()
   *
   * @param array $parameters
   * @return
   */
  public function handleReturn($parameters)
  {
    $this->debug('Return access from Paypal');

    return $this->handlePaypalData($parameters, false);
  }

  /**
   * Validate the IPN notification
   *
   * PayPal expects to receive a response to an IPN message within 30 seconds.
   * Your listener should not perform time-consuming operations, such as
   * creating a process, before responding to the IPN message.
   *
   * @param none
   * @return boolean
   */
  protected function handlePaypalData($parameters = array(), $is_ipn=false)
  {
    $this->debug('Parameters posted from Paypal ...');
    foreach($parameters as $key => $value)
    {
      $this->debug("$key=$value");
    }
    //--------------------------------------------------------------------------
    // store IPN data in object
    //--------------------------------------------------------------------------
    $this->ipnData = $parameters;
    $this->rewind();
    $this->relatedEntity = null;
    //--------------------------------------------------------------------------
    // post validation request; prepend cmd, leave order intact
    //--------------------------------------------------------------------------
    if($is_ipn)
    {
      $this->debug('Sending IPN validation response');
      $browser = new sfWebBrowser(array("Content-type: application/x-www-form-urlencoded\r\n","Connection: close\r\n\r\n"), null, array('ssl_verify'=>false));
      $url = $this->testMode? self::$ppSandboxUrl : self::$ppProductionUrl;
      $browser->post($url, array('cmd' => '_notify-validate') + $this->ipnData);
    }

    $dispatcher = sfContext::getInstance()->getEventDispatcher();
    //--------------------------------------------------------------------------
    // After PayPal verifies the message, there are additional checks that
    // your listener or back-end or administrative software must take
    //--------------------------------------------------------------------------
    try
    {
      //------------------------------------------------------------------------
      // make sure response == 'VERIFIED'
      //------------------------------------------------------------------------
      if($is_ipn)
      {
        $this->checkVerified ($browser->getResponseText());
      }
      //------------------------------------------------------------------------
      // make sure the IPN message is in relation to the business account
      //------------------------------------------------------------------------
      $this->checkReceiver();
      //------------------------------------------------------------------------
      // make sure this response has not been handled before
      //------------------------------------------------------------------------
      $this->checkDuplicateTxn();
      //------------------------------------------------------------------------
      // save the transaction
      //------------------------------------------------------------------------
      $transaction = $this->saveTransaction();
      //------------------------------------------------------------------------
      // make sure IPN data matches an existing entity
      //------------------------------------------------------------------------
      $this->checkEntity();
      //------------------------------------------------------------------------
      // call application specific method to handle payment status
      //------------------------------------------------------------------------
      $this->handlePaymentStatus($this['payment_status'], $this['pending_reason']);

      $dispatcher->notify(new sfEvent($transaction, 'paypal.ipn_success', array('ipn_data'=>$this->ipnData)));

      $this->debug('******* SUCCESS ********');
    }
    catch(sfException $e)
    {
      $this->lastError = $e->getMessage();

      $dispatcher->notify(new sfEvent($this->lastError, 'paypal.ipn_error', array('ipn_data'=>$this->ipnData)));

      $this->debug($this->lastError, 'alert');
      $this->debug('******* FAILED ********');
    }

    return isset($transaction)? $transaction : false;
  }

  /**
   * Called when Paypal has rejected the IPN validation response.
   *
   * The default action is to log the error
   * Overwrite to implement further logic
   *
   * @return void
   */
  protected function handleInvalid()
  {
  }

  protected function instanciateRelatedEntity()
  {
    return null;
  }

  /**
   * Called when Paypal has returned a status other than 'Completed'.
   *
   * There in no default action, so the method has to be overwritten to react to
   * this situation.
   *
   * The following status values are possible:
   *  - Completed: The payment has been completed, and the funds have been added successfully to your account balance.
   *  - Canceled_Reversal: A reversal has been canceled. For example, you won a dispute with the customer, and the funds for the transaction that was reversed have been returned to you.
   *  - Created: A German ELV payment is made using Express Checkout.
   *  - Denied: You denied the payment. This happens only if the payment was previously pending because of possible reasons described for the pending_reason variable or the Fraud_Management_Filters_x variable.
   *  - Expired: This authorization has expired and cannot be captured.
   *  - Failed: The payment has failed. This happens only if the payment was made from your customer’s bank account.
   *  - Pending: The payment is pending. See pending_reason for more information.
   *  - Refunded: You refunded the payment.
   *  - Reversed: A payment was reversed due to a chargeback or other type of reversal. The funds have been removed from your account balance and returned to the buyer. The reason for the reversal is specified in the ReasonCode element.
   *  - Processed: A payment has been accepted.
   *  - Voided: This authorization has been voided.
   *
   * @param string $status status value returned by Paypal ('payment_status')
   * @param string $reason reason code why payment is pending (applies only when $status == 'Pending')
   * @return void
   */
  protected function handlePaymentStatus($status, $reason=null)
  {
    // no default action; overwrite to implement
  }

  /**
   * Called by the IPN validation process to determine if the entity, related to
   * the transaction matches the data in the IPN record. If the transaction is
   * for example related to an order, this method should verify that the order
   * number and price match the IPN variables 'invoice' and 'mc_price'.
   *
   * This method will always return true, unless it is overwritten to implement
   * some application specific logic.
   *
   * @param mixed $entity
   * @return true if entity is valid
   */
  protected function isEntityValid()
  {
    return true;
  }

  /**
   * This method must be overwritten to automatically link payment transactions
   * to some other entity of the model e.g. 'Order' or 'Reservation'.
   *
   * The overwrting method can access the IPN data trough the ArrayAccess feature
   * to extract the identifying value (e.g. order #) and must instanciate and
   * return the identified entity. Currently only Doctrine objects are supported
   * as the code relies on the returned entity to have an 'id' property.
   *
   * example:
   * return Doctrine::getTable('Order)->findByOrderNo($this['invoice']);
   *
   * @return mixed entity identified related to the transaction; false if not found
   */
  final public function getRelatedEntity()
  {
    if(null === $this->relatedEntity)
    {
      $this->relatedEntity = $this->instanciateRelatedEntity();
    }

    return $this->relatedEntity;
  }

  protected function setup()
	{
	  //--------------------------------------------------------------------------
	  // populate fields with defaults
	  //--------------------------------------------------------------------------
	  // return method = POST
	  $this->config['rm']  = 2;
	  $this->config['cmd'] = '_xclick';

	  //--------------------------------------------------------------------------
	  // set callbacks (URLs Paypal will use to report back)
	  // the default values can be overwritten in app.yml
	  //--------------------------------------------------------------------------
	  $callback  = (array)sfConfig::get('app_es_paypal_plugin_callback');

 	  $this->config['notify_url']    = url_for(isset($callback['notify'])? $callback['notify'] : '@paypal_ipn',    true);
	  $this->config['return']        = url_for(isset($callback['return'])? $callback['return'] : '@paypal_return', true);
	  $this->config['cancel_return'] = url_for(isset($callback['cancel'])? $callback['cancel'] : '@paypal_cancel', true);
	  //--------------------------------------------------------------------------
	  // set Vendor identifier (MUST be defined in app.yml)
	  //--------------------------------------------------------------------------
		if(sfConfig::get('app_es_paypal_plugin_business'))
		{
		  $this->config['business'] = sfConfig::get('app_es_paypal_plugin_business');
		}
		else
		{
		  throw new sfException('Mandatory value undefined: sf_payment_paypal_plugin/business in app.yml.');
		}
	}

  /**
   * Enables/Disables test mode
   * By using this method, testmode can be switched on/off overwriting the setting in app.yml
   *
   * @param $test either true or false, default: true
   * @return none
   */
  public function enableTestMode($test=true)
  {
    $this->testMode = $test;
  }

  /**
   * Check for a verified response from Paypal.
   *
   * @param string theResponse
   * @return boolean
   */
  private function checkVerified($response)
  {
    $this->debug('IPN validation response answer: ' . $response);

    if($response == "VERIFIED")
    {
      return;
    }

    $this->handleInvalid();

    throw new sfException("IPN notification response rejected by Paypal server.\nResponse: " . $response);
  }


  /**
   * Check that the IPN message corresponds to the seller
   *
   * IPN_Guide.pdf:
   * Verify that you are the intended recipient of the IPN message by checking
   * the email address in the message; this handles a situation where another
   * merchant could accidentally or intentionally attempt to use your listener.
   *
   * @return boolean true if the IPN message
   */
  private function checkReceiver()
  {
    $this->debug(sprintf('Verifying receiver: is=%s, should=%s', $this['receiver_email'], $this->config['business']));

    if($this['receiver_email'] == $this->config['business'])
    {
      return;
    }

    throw new sfException('Paypal receiver_email does not match seller: '.$this['receiver_email']);
  }

  /**
   * Make sure transaction has not been processed before (consider Paypal
   * sending the same IPN twice)
   *
   * IPN_Guide.pdf:
   * Avoid duplicate IPN messages. Check that you have not already processed the
   * transaction identified by the transaction ID returned in the IPN message.
   * You may need to store transaction IDs returned by IPN messages in a file or
   * database so that you can check for duplicates. If the transaction ID sent
   * by PayPal is a duplicate, you should not process it again.
   *
   * @param string $txn_id the transaction id
   * @return boolean true if the transaction id is unique.
   */
  private function checkDuplicateTxn()
  {
    $this->debug(sprintf('Verifying if transaction has not been registered before: txn_id: %s, payment_status=%s', $this['txn_id'], $this['payment_status']));

    if(false == Doctrine::getTable('PaypalTransaction')->existsIdAndStatus($this['txn_id'], $this['payment_status']))
    {
      return;
    }

    throw new sfException(sprintf('Paypal transaction message has been processed before: txn_id=%s, status=%s', $this['txn_id'], $this['payment_status']));
  }

  /**
   * Check for a payment complete from Paypal.
   *
   * @param string $payment_status
   * @return boolean
   */
  private function checkComplete()
  {
    if($this['payment_status'] == 'Completed')
    {
      return;
    }

    $this->handlePaymentStatus($this['payment_status'], $this['pending_reason']);

    $message = sprintf('Transaction incomplete: status=%s', $this['payment_status']);
    if($this['payment_status'] == 'Pending')
    {
      $message .= sprintf(', reason: %s', $this['pending_reason']);
    }

    throw new sfException($message);
  }


  /**
   * Checks if there is some entity (entity) related to the transaction and if so, verifies if its valid.
   *
   * @return
   */
  private function checkEntity()
  {
    $this->debug('Looking for related entity');

    if(null !== $entity = $this->getRelatedEntity())
    {
      if(false !== $entity)
      {
        if($this->isEntityValid())
        {
          return;
        }
        else
        {
          throw new sfException("Entity verification error: \n" . $this->entityError);
        }
      }
      else
      {
        throw new sfException("Entity could not be matched");
      }
    }
  }

  protected function setEntityError($error)
  {
    $this->entityError = $error;
  }
  /**
   * Save the transaction data in the database
   *
   * @return void
   */
  private function saveTransaction()
  {
    $this->debug('Saving IPN as transaction');

    $transaction = new PaypalTransaction();

    $transaction->parent_id = ($this->getRelatedEntity()? $this->getRelatedEntity()->id : null);
    $transaction->txn_id    = $this['txn_id'];
    $transaction->txn_type  = $this['txn_type'];
    $transaction->status    = $this['payment_status'];
    $transaction->ipn_data  = serialize($this->ipnData);

    $transaction->save();

    return $transaction;
  }

  protected function debug($message, $level='log')
  {
    if($this->debugMode)
    {
      sfContext::getInstance()->getLogger()->$level('==PP== ' . $message);
    }
  }
  /**
   * Resets the field names array to the beginning (implements the Iterator interface).
   */
  public function rewind()
  {
    reset($this->ipnData);
    $this->count = $this->count();
  }

  /**
   * Gets the key associated with the current form field (implements the Iterator interface).
   *
   * @return string The key
   */
  public function key()
  {
    return key($this->ipnData);
  }

  /**
   * Returns the current form field (implements the Iterator interface).
   *
   * @return mixed The escaped value
   */
  public function current()
  {
    return current($this->ipnData);
  }

  /**
   * Moves to the next form field (implements the Iterator interface).
   */
  public function next()
  {
    next($this->ipnData);
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
   * @return integer The number of embedded form fields
   */
  public function count()
  {
    return count($this->ipnData);
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
    return isset($this->ipnData[$offset]);
  }

  /**
   * Returns the form field associated with the name (implements the ArrayAccess interface).
   *
   * @param  string $name  The offset of the value to get
   *
   * @return sfFormField   A form field instance
   */
  public function offsetGet($offset)
  {
    return isset($this->ipnData[$offset])? $this->ipnData[$offset] : null;
  }

  /**
   * Throws an exception saying that values cannot be set (implements the ArrayAccess interface).
   *
   * @param string $offset (ignored)
   * @param string $value (ignored)
   *
   */
  public function offsetSet($offset, $value)
  {
    $this->ipnData[$offset] = $value;
    $this->rewind();
  }

  /**
   * Removes a field from the form.
   *
   * It removes the widget and the validator for the given field.
   *
   * @param string $offset The field name
   */
  public function offsetUnset($offset)
  {
    unset($this->ipnData[$offset]);
    $this->rewind();
  }
}