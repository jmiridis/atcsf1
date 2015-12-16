<?php

require_once(sfConfig::get('sf_plugins_dir').'/esPaypalPlugin/modules/esPaypal/lib/BaseesPaypalActions.class.php');

/**
 * esPaypal actions.
 *
 * @package    esPaypalPlugin
 * @subpackage esPaypal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
class esPaypalActions extends BaseesPaypalActions
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
}

