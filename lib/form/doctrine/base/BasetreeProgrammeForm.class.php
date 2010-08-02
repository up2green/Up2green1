<?php

/**
 * treeProgramme form base class.
 *
 * @method treeProgramme getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasetreeProgrammeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'programme_id' => new sfWidgetFormInputHidden(),
      'tree_id'      => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'programme_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('programme_id')), 'empty_value' => $this->getObject()->get('programme_id'), 'required' => false)),
      'tree_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('tree_id')), 'empty_value' => $this->getObject()->get('tree_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tree_programme[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'treeProgramme';
  }

}
