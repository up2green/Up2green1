<?php

/**
 * categorie form base class.
 *
 * @method categorie getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasecategorieForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'parent_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('categorie'), 'add_empty' => true)),
      'is_active' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'parent_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('categorie'), 'required' => false)),
      'is_active' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'categorie', 'column' => array('unique_name')))
    );

    $this->widgetSchema->setNameFormat('categorie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'categorie';
  }

}
