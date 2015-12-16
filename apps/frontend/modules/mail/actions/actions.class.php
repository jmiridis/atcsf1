<?php

/**
 * mail actions.
 *
 * @package    atc
 * @subpackage mail
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 25 2011-02-11 18:27:52Z jorgo $
 */
class mailActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
}
