<?php

/**
 * engine form base class.
 *
 * @method engine getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseengineForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'id_category'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('category'), 'add_empty' => false)),
      'id_plateforme' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('plateforme'), 'add_empty' => false)),
      'id_devise'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('devise'), 'add_empty' => false)),
      'site_display'  => new sfWidgetFormInputText(),
      'site_url'      => new sfWidgetFormInputText(),
      'html'          => new sfWidgetFormTextarea(),
      'logo'          => new sfWidgetFormTextarea(),
      'description'   => new sfWidgetFormTextarea(),
      'remun_type'    => new sfWidgetFormChoice(array('choices' => array('number' => 'number', 'pourcent' => 'pourcent', 'price' => 'price'))),
      'remun_min'     => new sfWidgetFormInputText(),
      'remun_max'     => new sfWidgetFormInputText(),
      'is_active'     => new sfWidgetFormInputCheckbox(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'id_category'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('category'))),
      'id_plateforme' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('plateforme'))),
      'id_devise'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('devise'))),
      'site_display'  => new sfValidatorString(array('max_length' => 128)),
      'site_url'      => new sfValidatorString(array('max_length' => 128)),
      'html'          => new sfValidatorString(array('required' => false)),
      'logo'          => new sfValidatorString(array('required' => false)),
      'description'   => new sfValidatorString(array('required' => false)),
      'remun_type'    => new sfValidatorChoice(array('choices' => array(0 => 'number', 1 => 'pourcent', 2 => 'price'), 'required' => false)),
      'remun_min'     => new sfValidatorNumber(array('required' => false)),
      'remun_max'     => new sfValidatorNumber(),
      'is_active'     => new sfValidatorBoolean(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('engine[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'engine';
  }

}
