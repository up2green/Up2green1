<?php

/**
 * partenaire form base class.
 *
 * @method partenaire getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepartenaireForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'title'       => new sfWidgetFormInputText(),
      'accroche'    => new sfWidgetFormTextarea(),
      'description' => new sfWidgetFormTextarea(),
      'url'         => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'title'       => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'accroche'    => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'description' => new sfValidatorString(array('required' => false)),
      'url'         => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'partenaire', 'column' => array('user_id')))
    );

    $this->widgetSchema->setNameFormat('partenaire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'partenaire';
  }

}
