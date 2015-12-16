<?php

/**
 * home actions.
 *
 * @package    atc
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
class homeActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }

 /**
  * Executes logout action
  *
  * @param sfRequest $request A request object
  */
  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->setAuthenticated(false);
    $this->getUser()->getAttributeHolder()->clear();
    $this->redirect('home/index');
  }
}
