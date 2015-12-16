<?php

/**
 * Reservation form.
 *
 * @package    atc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: ReservationForm.class.php 64 2011-05-10 06:30:46Z jorgo $
 */
class ReservationForm extends BaseReservationForm
{
  public function configure()
  {
  	$round_trip_options = array(
	  	'OW' => 'one way',
	  	'RT' => 'round trip',
	  );

  	$paxs = range(0, 10);
  	$paxs[0] = '';
  	$no_pax_options = array_combine($paxs, $paxs);

  	$this->useFields(array('client_id', 'destination_id', 'round_trip', 'no_pax', 'hotel', 'arrival_date', 'arrival_flight_no', 'departure_date', 'departure_flight_no', 'comment'));

    $this->widgetSchema['client_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['destination_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Destination'), 'add_empty' => true));
    $this->widgetSchema['round_trip'] = new sfWidgetFormSelectRadio(array('choices'=>$round_trip_options, 'separator'=>'<br />'));
  	$this->widgetSchema['no_pax'] = new sfWidgetFormSelect(array('choices'=>$no_pax_options));
  	$this->widgetSchema['hotel'] = new sfWidgetFormInputText();
  	$this->widgetSchema['arrival_date'] = new esWidgetFormDateTimeJQuery(array(
   	  'time' => array(
	      'am_pm' => true,
	      'minute_prefix' => ':',
	      'format_without_seconds'=>'%hour%%minute%'
	    )
    ));
  	$this->widgetSchema['arrival_flight_no'] = new sfWidgetFormInputText();
    $this->widgetSchema['departure_date'] = new esWidgetFormDateTimeJQuery(array(
      'time' => array(
        'am_pm' => true,
        'minute_prefix' => ':',
        'format_without_seconds'=>'%hour%%minute%'
      )
    ));

  	$this->widgetSchema['departure_flight_no'] = new sfWidgetFormInputText();
    $this->widgetSchema['comment']             = new sfWidgetFormTextarea();

    $this->setDefault('round_trip', 'RT');

    $this->validatorSchema['arrival_date']   = new esValidatorDateTimeJQuery(array('with_time'=>true));
    $this->validatorSchema['departure_date'] = new esValidatorDateTimeJQuery(array('with_time'=>true,'required' => false));
    $this->validatorSchema['round_trip']     = new sfValidatorPass();

    // add a post validator
    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'checkDeparture')))
    );
  }

  public function checkDeparture($validator, $values)
  {
    // check for missing departure data
    if ($values['round_trip'] == 'RT')
    {
      if(empty($values['departure_date']) or empty($values['departure_flight_no']))
      {
        throw new sfValidatorError($validator, 'Departure information incomplete');
      }
    }

    return $values;
  }
}
