<?php

/**
 * partenaireProgramme form base class.
 *
 * @method partenaireProgramme getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepartenaireProgrammeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'partenaire_id' => new sfWidgetFormInputHidden(),
      'programme_id'  => new sfWidgetFormInputHidden(),
      'number'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'partenaire_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('partenaire_id')), 'empty_value' => $this->getObject()->get('partenaire_id'), 'required' => false)),
      'programme_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('programme_id')), 'empty_value' => $this->getObject()->get('programme_id'), 'required' => false)),
      'number'        => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('partenaire_programme[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'partenaireProgramme';
  }

}
