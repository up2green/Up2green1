<?php

/**
 * programmePolygonne form base class.
 *
 * @method programmePolygonne getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseprogrammePolygonneForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'polygonne_id' => new sfWidgetFormInputHidden(),
      'programme_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'polygonne_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('polygonne_id')), 'empty_value' => $this->getObject()->get('polygonne_id'), 'required' => false)),
      'programme_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('programme_id')), 'empty_value' => $this->getObject()->get('programme_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('programme_polygonne[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'programmePolygonne';
  }

}
