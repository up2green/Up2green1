<?php

/**
 * engine form base class.
 *
 * @method engine getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseengineForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'url'         => new sfWidgetFormInputText(),
      'html'        => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'remun_type'  => new sfWidgetFormChoice(array('choices' => array('number' => 'number', 'pourcent' => 'pourcent', 'price' => 'price'))),
      'remun_min'   => new sfWidgetFormInputText(),
      'remun_max'   => new sfWidgetFormInputText(),
      'rank'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'url'         => new sfValidatorString(array('max_length' => 128)),
      'html'        => new sfValidatorString(array('max_length' => 128)),
      'description' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'remun_type'  => new sfValidatorChoice(array('choices' => array(0 => 'number', 1 => 'pourcent', 2 => 'price'), 'required' => false)),
      'remun_min'   => new sfValidatorInteger(array('required' => false)),
      'remun_max'   => new sfValidatorInteger(),
      'rank'        => new sfValidatorInteger(),
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
