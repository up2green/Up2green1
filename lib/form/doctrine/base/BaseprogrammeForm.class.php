<?php

/**
 * programme form base class.
 *
 * @method programme getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseprogrammeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'organisme_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('organisme'), 'add_empty' => true)),
      'geoadress'    => new sfWidgetFormInputText(),
      'latitude'     => new sfWidgetFormInputText(),
      'longitude'    => new sfWidgetFormInputText(),
      'is_active'    => new sfWidgetFormInputCheckbox(),
      'max_tree'     => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'organisme_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('organisme'), 'required' => false)),
      'geoadress'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'latitude'     => new sfValidatorNumber(array('required' => false)),
      'longitude'    => new sfValidatorNumber(array('required' => false)),
      'is_active'    => new sfValidatorBoolean(array('required' => false)),
      'max_tree'     => new sfValidatorInteger(),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('programme[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'programme';
  }

}
