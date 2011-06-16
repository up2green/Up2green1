<?php

/**
 * engine filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseengineFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_category'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('category'), 'add_empty' => true)),
      'id_plateforme'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('plateforme'), 'add_empty' => true)),
      'currency_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Currency'), 'add_empty' => true)),
      'site_display'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_url'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'html'             => new sfWidgetFormFilterInput(),
      'logo'             => new sfWidgetFormFilterInput(),
      'description'      => new sfWidgetFormFilterInput(),
      'remun_type'       => new sfWidgetFormChoice(array('choices' => array('' => '', 'number' => 'number', 'pourcent' => 'pourcent', 'price' => 'price'))),
      'remun_min'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'remun_max'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'safe_search_only' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_active'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'id_category'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('category'), 'column' => 'id')),
      'id_plateforme'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('plateforme'), 'column' => 'id')),
      'currency_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Currency'), 'column' => 'id')),
      'site_display'     => new sfValidatorPass(array('required' => false)),
      'site_url'         => new sfValidatorPass(array('required' => false)),
      'html'             => new sfValidatorPass(array('required' => false)),
      'logo'             => new sfValidatorPass(array('required' => false)),
      'description'      => new sfValidatorPass(array('required' => false)),
      'remun_type'       => new sfValidatorChoice(array('required' => false, 'choices' => array('number' => 'number', 'pourcent' => 'pourcent', 'price' => 'price'))),
      'remun_min'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'remun_max'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'safe_search_only' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_active'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('engine_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'engine';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'id_category'      => 'ForeignKey',
      'id_plateforme'    => 'ForeignKey',
      'currency_id'      => 'ForeignKey',
      'site_display'     => 'Text',
      'site_url'         => 'Text',
      'html'             => 'Text',
      'logo'             => 'Text',
      'description'      => 'Text',
      'remun_type'       => 'Enum',
      'remun_min'        => 'Number',
      'remun_max'        => 'Number',
      'safe_search_only' => 'Boolean',
      'is_active'        => 'Boolean',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
    );
  }
}
