<?php

/**
 * tree_programme form base class.
 *
 * @method tree_programme getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class Basetree_programmeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'programme_id' => new sfWidgetFormInputHidden(),
      'tree_id'      => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'programme_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'programme_id', 'required' => false)),
      'tree_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'tree_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tree_programme[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'tree_programme';
  }

}
