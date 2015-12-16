<?php

/**
 * PaypalTransaction form base class.
 *
 * @method PaypalTransaction getObject() Returns the current form's model object
 *
 * @package    atc
 * @subpackage form
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: BasePaypalTransactionForm.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
abstract class BasePaypalTransactionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'parent_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Reservation'), 'add_empty' => true)),
      'txn_id'     => new sfWidgetFormInputText(),
      'txn_type'   => new sfWidgetFormInputText(),
      'status'     => new sfWidgetFormInputText(),
      'ipn_data'   => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'parent_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Reservation'), 'required' => false)),
      'txn_id'     => new sfValidatorString(array('max_length' => 32)),
      'txn_type'   => new sfValidatorString(array('max_length' => 20)),
      'status'     => new sfValidatorString(array('max_length' => 20)),
      'ipn_data'   => new sfValidatorPass(),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('paypal_transaction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PaypalTransaction';
  }

}
