<?php

/**
 * preinscription form base class.
 *
 * @method preinscription getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepreinscriptionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'first_name'    => new sfWidgetFormInputText(),
      'last_name'     => new sfWidgetFormInputText(),
      'email_address' => new sfWidgetFormInputText(),
      'username'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'first_name'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'last_name'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email_address' => new sfValidatorString(array('max_length' => 255)),
      'username'      => new sfValidatorString(array('max_length' => 128)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'preinscription', 'column' => array('email_address'))),
        new sfValidatorDoctrineUnique(array('model' => 'preinscription', 'column' => array('username'))),
      ))
    );

    $this->widgetSchema->setNameFormat('preinscription[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'preinscription';
  }

}
