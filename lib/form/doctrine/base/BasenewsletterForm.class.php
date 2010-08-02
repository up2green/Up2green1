<?php

/**
 * newsletter form base class.
 *
 * @method newsletter getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasenewsletterForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'unique_name' => new sfWidgetFormInputText(),
      'reply_to'    => new sfWidgetFormInputText(),
      'email_from'  => new sfWidgetFormInputText(),
      'is_forced'   => new sfWidgetFormInputCheckbox(),
      'sent_at'     => new sfWidgetFormDateTime(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'unique_name' => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'reply_to'    => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'email_from'  => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'is_forced'   => new sfValidatorBoolean(array('required' => false)),
      'sent_at'     => new sfValidatorDateTime(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'newsletter', 'column' => array('unique_name')))
    );

    $this->widgetSchema->setNameFormat('newsletter[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'newsletter';
  }

}
