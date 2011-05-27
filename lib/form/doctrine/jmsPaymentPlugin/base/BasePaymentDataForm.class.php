<?php

/**
 * PaymentData form base class.
 *
 * @method PaymentData getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePaymentDataForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'payment_id'                => new sfWidgetFormInputHidden(),
      'method_class_name'         => new sfWidgetFormInputText(),
      'subject'                   => new sfWidgetFormInputText(),
      'internal_reference_number' => new sfWidgetFormInputText(),
      'external_reference_number' => new sfWidgetFormInputText(),
      'bank_country'              => new sfWidgetFormInputText(),
      'bank_code'                 => new sfWidgetFormInputText(),
      'account_holder'            => new sfWidgetFormInputText(),
      'account_number'            => new sfWidgetFormInputText(),
      'project'                   => new sfWidgetFormInputText(),
      'project_campaign'          => new sfWidgetFormInputText(),
      'payment_text'              => new sfWidgetFormInputText(),
      'ip'                        => new sfWidgetFormInputText(),
      'express_token'             => new sfWidgetFormInputText(),
      'express_url'               => new sfWidgetFormTextarea(),
      'cancel_url'                => new sfWidgetFormTextarea(),
      'return_url'                => new sfWidgetFormTextarea(),
      'payer_id'                  => new sfWidgetFormInputText(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'payment_id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('payment_id')), 'empty_value' => $this->getObject()->get('payment_id'), 'required' => false)),
      'method_class_name'         => new sfValidatorString(array('max_length' => 100)),
      'subject'                   => new sfValidatorString(array('max_length' => 255)),
      'internal_reference_number' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'external_reference_number' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'bank_country'              => new sfValidatorString(array('max_length' => 2)),
      'bank_code'                 => new sfValidatorString(array('max_length' => 255)),
      'account_holder'            => new sfValidatorString(array('max_length' => 255)),
      'account_number'            => new sfValidatorString(array('max_length' => 255)),
      'project'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'project_campaign'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'payment_text'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ip'                        => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'express_token'             => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'express_url'               => new sfValidatorString(array('max_length' => 2048, 'required' => false)),
      'cancel_url'                => new sfValidatorString(array('max_length' => 2048)),
      'return_url'                => new sfValidatorString(array('max_length' => 2048)),
      'payer_id'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('payment_data[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PaymentData';
  }

}
