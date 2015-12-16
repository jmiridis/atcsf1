<?php

/**
 * Transaction filter form base class.
 *
 * @package    atc
 * @subpackage filter
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: BaseTransactionFormFilter.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
abstract class BaseTransactionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'tx_id'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tx_type'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'reservation_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Reservation'), 'add_empty' => true)),
      'tx_parameters'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'tx_id'          => new sfValidatorPass(array('required' => false)),
      'tx_type'        => new sfValidatorPass(array('required' => false)),
      'reservation_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Reservation'), 'column' => 'id')),
      'tx_parameters'  => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('transaction_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Transaction';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'tx_id'          => 'Text',
      'tx_type'        => 'Text',
      'reservation_id' => 'ForeignKey',
      'tx_parameters'  => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
