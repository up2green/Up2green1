<?php

/**
 * profil filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseprofilFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'credit'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_newsletter' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'culture'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'user_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'credit'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_newsletter' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'culture'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('profil_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'profil';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'user_id'       => 'ForeignKey',
      'credit'        => 'Number',
      'is_newsletter' => 'Number',
      'culture'       => 'Text',
    );
  }
}
