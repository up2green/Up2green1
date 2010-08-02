<?php

/**
 * module form base class.
 *
 * @method module getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemoduleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'content_id'   => new sfWidgetFormInputText(),
      'content_type' => new sfWidgetFormChoice(array('choices' => array('category' => 'category', 'lien' => 'lien', 'article' => 'article', 'newsletter' => 'newsletter', 'programme' => 'programme', 'organisme' => 'organisme', 'gmap' => 'gmap', 'recherche' => 'recherche', 'user' => 'user', 'sgGuardAuth' => 'sgGuardAuth'))),
      'is_active'    => new sfWidgetFormInputCheckbox(),
      'action'       => new sfWidgetFormInputText(),
      'user_access'  => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'content_id'   => new sfValidatorString(array('max_length' => 128)),
      'content_type' => new sfValidatorChoice(array('choices' => array(0 => 'category', 1 => 'lien', 2 => 'article', 3 => 'newsletter', 4 => 'programme', 5 => 'organisme', 6 => 'gmap', 7 => 'recherche', 8 => 'user', 9 => 'sgGuardAuth'), 'required' => false)),
      'is_active'    => new sfValidatorBoolean(array('required' => false)),
      'action'       => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'user_access'  => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('module[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'module';
  }

}
