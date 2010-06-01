<?php

/**
 * partenaireUser form base class.
 *
 * @method partenaireUser getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasepartenaireUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'partenaire_id' => new sfWidgetFormInputHidden(),
      'user_id'       => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'partenaire_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'partenaire_id', 'required' => false)),
      'user_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'user_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('partenaire_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'partenaireUser';
  }

}
