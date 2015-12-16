<?php

/**
 * customer actions.
 *
 * @package    atc
 * @subpackage customer
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 25 2011-02-11 18:27:52Z jorgo $
 */
class customerActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeRegister(sfWebRequest $request)
  {
    $a = $this->getUser()->getAttributeHolder()->getAll();
    $b = $request->getParameterHolder()->getAll();
    $this->forward404Unless($client = Doctrine::getTable('Client')->find($request->getParameter('user_id')));

    if($client->email_confirmed)
    {
      $this->setTemplate('duplicate');
    }
    else
    {

      $client->email_confirmed = true;
      $client->save();

      $this->reservation = $client->Reservations[0];
    }
  }
}
