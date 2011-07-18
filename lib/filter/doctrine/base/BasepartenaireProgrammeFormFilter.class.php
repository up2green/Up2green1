<?php

/**
 * partenaireProgramme filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepartenaireProgrammeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'partenaire_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('partenaire'), 'add_empty' => true)),
      'programme_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('programme'), 'add_empty' => true)),
      'number'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'hardcode'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'partenaire_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('partenaire'), 'column' => 'id')),
      'programme_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('programme'), 'column' => 'id')),
      'number'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'hardcode'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('partenaire_programme_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'partenaireProgramme';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'partenaire_id' => 'ForeignKey',
      'programme_id'  => 'ForeignKey',
      'number'        => 'Number',
      'hardcode'      => 'Number',
    );
  }
}
