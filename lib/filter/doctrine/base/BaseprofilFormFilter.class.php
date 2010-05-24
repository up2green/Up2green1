<?php

/**
 * profil filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseprofilFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'add_empty' => true)),
      'mail'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'credit'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_newsletter' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'culture'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'user_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('sfGuardUser'), 'column' => 'id')),
      'mail'          => new sfValidatorPass(array('required' => false)),
      'credit'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
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
      'mail'          => 'Text',
      'credit'        => 'Number',
      'is_newsletter' => 'Number',
      'culture'       => 'Text',
    );
  }
}
