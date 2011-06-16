<?php

/**
 * filleul form base class.
 *
 * @method filleul getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefilleulForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'user_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Parrain'), 'add_empty' => false)),
      'filleul_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Filleul'), 'add_empty' => true)),
      'email_address' => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Parrain'))),
      'filleul_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Filleul'), 'required' => false)),
      'email_address' => new sfValidatorString(array('max_length' => 255)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'filleul', 'column' => array('filleul_id'))),
        new sfValidatorDoctrineUnique(array('model' => 'filleul', 'column' => array('email_address'))),
      ))
    );

    $this->widgetSchema->setNameFormat('filleul[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'filleul';
  }

}
