<?php

/**
 * Transaction form base class.
 *
 * @method Transaction getObject() Returns the current form's model object
 *
 * @package    atc
 * @subpackage form
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: BaseTransactionForm.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
abstract class BaseTransactionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'tx_id'          => new sfWidgetFormInputText(),
      'tx_type'        => new sfWidgetFormInputText(),
      'reservation_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Reservation'), 'add_empty' => true)),
      'tx_parameters'  => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'tx_id'          => new sfValidatorString(array('max_length' => 32)),
      'tx_type'        => new sfValidatorString(array('max_length' => 20)),
      'reservation_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Reservation'), 'required' => false)),
      'tx_parameters'  => new sfValidatorPass(),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('transaction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Transaction';
  }

}
