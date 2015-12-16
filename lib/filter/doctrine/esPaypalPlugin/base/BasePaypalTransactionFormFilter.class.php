<?php

/**
 * PaypalTransaction filter form base class.
 *
 * @package    atc
 * @subpackage filter
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: BasePaypalTransactionFormFilter.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
abstract class BasePaypalTransactionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'parent_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Reservation'), 'add_empty' => true)),
      'txn_id'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'txn_type'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'status'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ipn_data'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'parent_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Reservation'), 'column' => 'id')),
      'txn_id'     => new sfValidatorPass(array('required' => false)),
      'txn_type'   => new sfValidatorPass(array('required' => false)),
      'status'     => new sfValidatorPass(array('required' => false)),
      'ipn_data'   => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('paypal_transaction_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PaypalTransaction';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'parent_id'  => 'ForeignKey',
      'txn_id'     => 'Text',
      'txn_type'   => 'Text',
      'status'     => 'Text',
      'ipn_data'   => 'Text',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
