<?php

/**
 * Transfer filter form base class.
 *
 * @package    atc
 * @subpackage filter
 * @author     Jorgo Miridis <jorgo@miridis.com>
 * @version    SVN: $Id: BaseTransferFormFilter.class.php 33 2011-02-11 18:47:27Z jorgo $
 */
abstract class BaseTransferFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'destination_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Destination'), 'add_empty' => true)),
      'description'    => new sfWidgetFormFilterInput(),
      'min_pax'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'max_pax'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'round_trip'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'active'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'destination_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Destination'), 'column' => 'id')),
      'description'    => new sfValidatorPass(array('required' => false)),
      'min_pax'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'max_pax'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'round_trip'     => new sfValidatorPass(array('required' => false)),
      'price'          => new sfValidatorPass(array('required' => false)),
      'active'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('transfer_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Transfer';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'destination_id' => 'ForeignKey',
      'description'    => 'Text',
      'min_pax'        => 'Number',
      'max_pax'        => 'Number',
      'round_trip'     => 'Text',
      'price'          => 'Text',
      'active'         => 'Boolean',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
