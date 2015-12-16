<?php

/**
 * Client form.
 *
 * @package    atc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: ClientForm.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
class ClientForm extends BaseClientForm
{
  public function configure()
  {
  	$this->useFields(array('firstname', 'lastname', 'phone', 'email_address', 'origin'));
  }
}
