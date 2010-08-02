<?php

/**
 * content form base class.
 *
 * @method content getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
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
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'layout_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('layout_id')), 'empty_value' => $this->getObject()->get('layout_id'), 'required' => false)),
      'zone_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('zone_id')), 'empty_value' => $this->getObject()->get('zone_id'), 'required' => false)),
      'module_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('module_id')), 'empty_value' => $this->getObject()->get('module_id'), 'required' => false)),
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
