<?php

/**
 * Transfer form base class.
 *
 * @method Transfer getObject() Returns the current form's model object
 *
 * @package    atc
 * @subpackage form
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: BaseTransferForm.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
abstract class BaseTransferForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'destination_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Destination'), 'add_empty' => false)),
      'description'    => new sfWidgetFormInputText(),
      'min_pax'        => new sfWidgetFormInputText(),
      'max_pax'        => new sfWidgetFormInputText(),
      'round_trip'     => new sfWidgetFormInputText(),
      'price'          => new sfWidgetFormInputText(),
      'active'         => new sfWidgetFormInputCheckbox(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'destination_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Destination'))),
      'description'    => new sfValidatorPass(array('required' => false)),
      'min_pax'        => new sfValidatorInteger(),
      'max_pax'        => new sfValidatorInteger(),
      'round_trip'     => new sfValidatorString(array('max_length' => 2)),
      'price'          => new sfValidatorPass(),
      'active'         => new sfValidatorBoolean(),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('transfer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Transfer';
  }

}
