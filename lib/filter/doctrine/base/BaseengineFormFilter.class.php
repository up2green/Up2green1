<?php

/**
 * engine filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseengineFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'url'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'html'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description' => new sfWidgetFormFilterInput(),
      'remun_type'  => new sfWidgetFormChoice(array('choices' => array('' => '', 'number' => 'number', 'pourcent' => 'pourcent', 'price' => 'price'))),
      'remun_min'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'remun_max'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'rank'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'url'         => new sfValidatorPass(array('required' => false)),
      'html'        => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'remun_type'  => new sfValidatorChoice(array('required' => false, 'choices' => array('number' => 'number', 'pourcent' => 'pourcent', 'price' => 'price'))),
      'remun_min'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'remun_max'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rank'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
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
      'id'          => 'Number',
      'url'         => 'Text',
      'html'        => 'Text',
      'description' => 'Text',
      'remun_type'  => 'Enum',
      'remun_min'   => 'Number',
      'remun_max'   => 'Number',
      'rank'        => 'Number',
    );
  }
}
