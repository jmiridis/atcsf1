<?php

/**
 * Client form base class.
 *
 * @method Client getObject() Returns the current form's model object
 *
 * @package    atc
 * @subpackage form
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: BaseClientForm.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
abstract class BaseClientForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'firstname'        => new sfWidgetFormInputText(),
      'lastname'         => new sfWidgetFormInputText(),
      'origin'           => new sfWidgetFormInputText(),
      'phone'            => new sfWidgetFormInputText(),
      'email_address'    => new sfWidgetFormInputText(),
      'email_confirmed'  => new sfWidgetFormInputCheckbox(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'firstname'        => new sfValidatorString(array('max_length' => 50)),
      'lastname'         => new sfValidatorString(array('max_length' => 50)),
      'origin'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'email_address'    => new sfValidatorString(array('max_length' => 50)),
      'email_confirmed'  => new sfValidatorBoolean(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('client[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Client';
  }

}
