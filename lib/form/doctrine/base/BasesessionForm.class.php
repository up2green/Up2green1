<?php

/**
 * session form base class.
 *
 * @method session getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesessionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'sess_id'           => new sfWidgetFormInputHidden(),
      'sess_data'         => new sfWidgetFormTextarea(),
      'sess_time'         => new sfWidgetFormInputText(),
      'is_authenticated'  => new sfWidgetFormInputCheckbox(),
      'last_request_time' => new sfWidgetFormInputText(),
      'user_id'           => new sfWidgetFormInputText(),
      'app'               => new sfWidgetFormInputText(),
      'module'            => new sfWidgetFormInputText(),
      'action'            => new sfWidgetFormInputText(),
      'is_ajax'           => new sfWidgetFormInputCheckbox(),
      'ip'                => new sfWidgetFormInputText(),
      'culture'           => new sfWidgetFormInputText(),
      'user_agent'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'sess_id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('sess_id')), 'empty_value' => $this->getObject()->get('sess_id'), 'required' => false)),
      'sess_data'         => new sfValidatorString(),
      'sess_time'         => new sfValidatorInteger(),
      'is_authenticated'  => new sfValidatorBoolean(array('required' => false)),
      'last_request_time' => new sfValidatorInteger(array('required' => false)),
      'user_id'           => new sfValidatorInteger(array('required' => false)),
      'app'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'module'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'action'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_ajax'           => new sfValidatorBoolean(array('required' => false)),
      'ip'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'culture'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_agent'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('session[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'session';
  }

}
