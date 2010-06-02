<?php

/**
 * profil form base class.
 *
 * @method profil getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseprofilForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'user_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'add_empty' => false)),
      'mail'          => new sfWidgetFormInputText(),
      'credit'        => new sfWidgetFormInputText(),
      'is_newsletter' => new sfWidgetFormInputText(),
      'culture'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'user_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'))),
      'mail'          => new sfValidatorString(array('max_length' => 50)),
      'credit'        => new sfValidatorInteger(array('required' => false)),
      'is_newsletter' => new sfValidatorInteger(array('required' => false)),
      'culture'       => new sfValidatorString(array('max_length' => 7, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'profil', 'column' => array('user_id'))),
        new sfValidatorDoctrineUnique(array('model' => 'profil', 'column' => array('mail'))),
      ))
    );

    $this->widgetSchema->setNameFormat('profil[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'profil';
  }

}
