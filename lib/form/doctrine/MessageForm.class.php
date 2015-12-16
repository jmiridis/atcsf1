<?php

/**
 * Message form.
 *
 * @package    atc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: MessageForm.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
class MessageForm extends BaseMessageForm
{
  public function configure()
  {
    $this->useFields(array('client_id','email_address','message'));

    $this->widgetSchema['client_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['message']   = new sfWidgetFormTextarea();
  }
}
