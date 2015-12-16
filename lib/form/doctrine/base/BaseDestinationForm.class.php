<?php

/**
 * Destination form base class.
 *
 * @method Destination getObject() Returns the current form's model object
 *
 * @package    atc
 * @subpackage form
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: BaseDestinationForm.class.php 80 2012-05-31 22:53:04Z jorgo $
 */
abstract class BaseDestinationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'seq_num'     => new sfWidgetFormInputText(),
      'active'      => new sfWidgetFormInputCheckbox(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'       => new sfValidatorString(array('max_length' => 255)),
      'description' => new sfValidatorPass(array('required' => false)),
      'seq_num'     => new sfValidatorInteger(),
      'active'      => new sfValidatorBoolean(),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('destination[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Destination';
  }

}
