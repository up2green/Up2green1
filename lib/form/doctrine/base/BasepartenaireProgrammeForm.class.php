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
      'id'            => new sfWidgetFormInputHidden(),
      'partenaire_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('partenaire'), 'add_empty' => false)),
      'programme_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('programme'), 'add_empty' => false)),
      'number'        => new sfWidgetFormInputText(),
      'hardcode'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'partenaire_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('partenaire'))),
      'programme_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('programme'))),
      'number'        => new sfValidatorInteger(array('required' => false)),
      'hardcode'      => new sfValidatorInteger(array('required' => false)),
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
