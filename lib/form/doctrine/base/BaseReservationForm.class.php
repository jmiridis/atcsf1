<?php

/**
 * Reservation form base class.
 *
 * @method Reservation getObject() Returns the current form's model object
 *
 * @package    atc
 * @subpackage form
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: BaseReservationForm.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
abstract class BaseReservationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'client_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Client'), 'add_empty' => false)),
      'destination_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Destination'), 'add_empty' => false)),
      'uniqid'              => new sfWidgetFormInputText(),
      'round_trip'          => new sfWidgetFormInputText(),
      'no_pax'              => new sfWidgetFormInputText(),
      'hotel'               => new sfWidgetFormInputText(),
      'arrival_date'        => new sfWidgetFormDateTime(),
      'arrival_flight_no'   => new sfWidgetFormInputText(),
      'departure_date'      => new sfWidgetFormDateTime(),
      'departure_flight_no' => new sfWidgetFormInputText(),
      'price'               => new sfWidgetFormInputText(),
      'comment'             => new sfWidgetFormInputText(),
      'deleted'             => new sfWidgetFormInputCheckbox(),
      'status'              => new sfWidgetFormInputText(),
      'payment_date'        => new sfWidgetFormDateTime(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'client_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Client'))),
      'destination_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Destination'))),
      'uniqid'              => new sfValidatorString(array('max_length' => 32)),
      'round_trip'          => new sfValidatorString(array('max_length' => 2)),
      'no_pax'              => new sfValidatorInteger(),
      'hotel'               => new sfValidatorString(array('max_length' => 255)),
      'arrival_date'        => new sfValidatorDateTime(),
      'arrival_flight_no'   => new sfValidatorString(array('max_length' => 20)),
      'departure_date'      => new sfValidatorDateTime(array('required' => false)),
      'departure_flight_no' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price'               => new sfValidatorPass(),
      'comment'             => new sfValidatorPass(array('required' => false)),
      'deleted'             => new sfValidatorBoolean(array('required' => false)),
      'status'              => new sfValidatorPass(array('required' => false)),
      'payment_date'        => new sfValidatorDateTime(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('reservation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Reservation';
  }

}
