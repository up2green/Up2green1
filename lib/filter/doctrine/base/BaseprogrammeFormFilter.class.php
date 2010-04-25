<?php

/**
 * programme filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseprogrammeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'organisme_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('organisme'), 'add_empty' => true)),
      'latitude'     => new sfWidgetFormFilterInput(),
      'longitude'    => new sfWidgetFormFilterInput(),
      'geoloc'       => new sfWidgetFormFilterInput(),
      'is_active'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'organisme_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('organisme'), 'column' => 'id')),
      'latitude'     => new sfValidatorPass(array('required' => false)),
      'longitude'    => new sfValidatorPass(array('required' => false)),
      'geoloc'       => new sfValidatorPass(array('required' => false)),
      'is_active'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('programme_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'programme';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'organisme_id' => 'ForeignKey',
      'latitude'     => 'Text',
      'longitude'    => 'Text',
      'geoloc'       => 'Text',
      'is_active'    => 'Boolean',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
    );
  }
}
