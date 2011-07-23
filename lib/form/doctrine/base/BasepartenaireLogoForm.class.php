<?php

/**
 * partenaireLogo form base class.
 *
 * @method partenaireLogo getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepartenaireLogoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'partenaire_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('partenaire'), 'add_empty' => false)),
      'src'           => new sfWidgetFormInputText(),
      'href'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'partenaire_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('partenaire'))),
      'src'           => new sfValidatorString(array('max_length' => 128)),
      'href'          => new sfValidatorString(array('max_length' => 128, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('partenaire_logo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'partenaireLogo';
  }

}
