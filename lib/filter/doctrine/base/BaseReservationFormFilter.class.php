<?php

/**
 * Reservation filter form base class.
 *
 * @package    atc
 * @subpackage filter
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: BaseReservationFormFilter.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
abstract class BaseReservationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'client_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Client'), 'add_empty' => true)),
      'destination_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Destination'), 'add_empty' => true)),
      'uniqid'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'round_trip'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'no_pax'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'hotel'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'arrival_date'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'arrival_flight_no'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'departure_date'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'departure_flight_no' => new sfWidgetFormFilterInput(),
      'price'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'comment'             => new sfWidgetFormFilterInput(),
      'deleted'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'status'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'payment_date'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'client_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Client'), 'column' => 'id')),
      'destination_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Destination'), 'column' => 'id')),
      'uniqid'              => new sfValidatorPass(array('required' => false)),
      'round_trip'          => new sfValidatorPass(array('required' => false)),
      'no_pax'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'hotel'               => new sfValidatorPass(array('required' => false)),
      'arrival_date'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'arrival_flight_no'   => new sfValidatorPass(array('required' => false)),
      'departure_date'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'departure_flight_no' => new sfValidatorPass(array('required' => false)),
      'price'               => new sfValidatorPass(array('required' => false)),
      'comment'             => new sfValidatorPass(array('required' => false)),
      'deleted'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'status'              => new sfValidatorPass(array('required' => false)),
      'payment_date'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('reservation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Reservation';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'client_id'           => 'ForeignKey',
      'destination_id'      => 'ForeignKey',
      'uniqid'              => 'Text',
      'round_trip'          => 'Text',
      'no_pax'              => 'Number',
      'hotel'               => 'Text',
      'arrival_date'        => 'Date',
      'arrival_flight_no'   => 'Text',
      'departure_date'      => 'Date',
      'departure_flight_no' => 'Text',
      'price'               => 'Text',
      'comment'             => 'Text',
      'deleted'             => 'Boolean',
      'status'              => 'Text',
      'payment_date'        => 'Date',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
    );
  }
}
