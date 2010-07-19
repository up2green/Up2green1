<?php

/**
 * content form base class.
 *
 * @method content getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasecontentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'layout_id'  => new sfWidgetFormInputHidden(),
      'zone_id'    => new sfWidgetFormInputHidden(),
      'module_id'  => new sfWidgetFormInputHidden(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'layout_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'layout_id', 'required' => false)),
      'zone_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'zone_id', 'required' => false)),
      'module_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'module_id', 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('content[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'content';
  }

}
