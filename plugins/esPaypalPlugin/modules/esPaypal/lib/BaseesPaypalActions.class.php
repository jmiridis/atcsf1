<?php
/**
 * Base actions for the esPaypalPlugin esPaypal module.
 *
 * @package     esPaypalPlugin
 * @subpackage  esPaypal
 * @author      Your name here
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BaseesPaypalActions extends sfActions
{

  protected function handleReturn($parameters)
  {
  }

  protected function handleCancel()
  {
  }

  protected function handleFailure()
  {
  }

  public function executeSample(sfWebRequest $request)
  {
    $this->button = new esPaypalButton(esPaypalButton::BUTTON_TYPE_BUYNOW);
    $this->button->setParameters(array(
      'item_name' => 'Test Item ',
      'invoice'   => 'some invoice number',
      'amount'    => 999.99
    ));
  }

  public function executeReturn(sfWebRequest $request)
  {
    //--------------------------------------------------------------------------
    // if txn_id is posted, we can assume that PDT (Payment Data Transfer) is
    // inactive and return method has been set to 2
    // PDT is not tested yet and requires additional investigation
    //--------------------------------------------------------------------------
    if($request->getPostParameter('txn_id'))
    {
      //--------------------------------------------------------------------------
      // instanciate application specific Paypal Interface
      //--------------------------------------------------------------------------
      $pp_class = sfConfig::get('app_es_paypal_plugin_handler', 'esPaypalHandler');
      $pp = new $pp_class();
      //--------------------------------------------------------------------------
      // handle data posted by Paypal (store as transaction)
      //--------------------------------------------------------------------------
      $transaction = $pp->handleReturn($request->getPostParameters());

      $this->data          = $request->getPostParameters();
      $this->relatedEntity = $pp->getRelatedEntity();
      $this->transaction   = $transaction;

    }
    //--------------------------------------------------------------------------
    //  either PDT has been activated or return method is < 2
    // if any paramters are returned, they are passed as GET parameters
    //--------------------------------------------------------------------------
    else
    {
      $this->data = $request->getGetParameters();
    }

    $this->handleReturn($this->data);
  }

  /**
   * Action called by the Paypal server to confirm the client's transaction.
   *
   * @param sfWebRequest $request
   * @return void
   */
  public function executeIpn(sfWebRequest $request)
  {
    //--------------------------------------------------------------------------
    // instanciate application specific Paypal Interface
    //--------------------------------------------------------------------------
    $pp_class = sfConfig::get('app_es_paypal_plugin_handler', 'esPaypalHandler');
    $pp = new $pp_class();
    //--------------------------------------------------------------------------
    // handle data posted by Paypal (store as transaction)
    //--------------------------------------------------------------------------
    $pp->handleIpn($request->getPostParameters());

    return sfView::NONE;
  }

  /**
   * BaseesPaypalActions::executeCancel()
   *
   * @param sfWebRequest $request
   * @return
   */
  public function executeCancel(sfWebRequest $request)
  {
    $this->handleCancel();
  }
}