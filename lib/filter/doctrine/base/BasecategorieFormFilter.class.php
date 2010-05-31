<?php

/**
 * categorie filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasecategorieFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'unique_name' => new sfWidgetFormFilterInput(),
      'parent_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('parent'), 'add_empty' => true)),
      'is_active'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'unique_name' => new sfValidatorPass(array('required' => false)),
      'parent_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('parent'), 'column' => 'id')),
      'is_active'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('categorie_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'categorie';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'unique_name' => 'Text',
      'parent_id'   => 'ForeignKey',
      'is_active'   => 'Boolean',
    );
  }
}
