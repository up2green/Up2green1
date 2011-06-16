<?php

/**
 * PaymentData filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePaymentDataFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'method_class_name'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'subject'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'internal_reference_number' => new sfWidgetFormFilterInput(),
      'external_reference_number' => new sfWidgetFormFilterInput(),
      'bank_country'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'bank_code'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'account_holder'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'account_number'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'project'                   => new sfWidgetFormFilterInput(),
      'project_campaign'          => new sfWidgetFormFilterInput(),
      'payment_text'              => new sfWidgetFormFilterInput(),
      'ip'                        => new sfWidgetFormFilterInput(),
      'express_token'             => new sfWidgetFormFilterInput(),
      'express_url'               => new sfWidgetFormFilterInput(),
      'cancel_url'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'return_url'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'payer_id'                  => new sfWidgetFormFilterInput(),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'method_class_name'         => new sfValidatorPass(array('required' => false)),
      'subject'                   => new sfValidatorPass(array('required' => false)),
      'internal_reference_number' => new sfValidatorPass(array('required' => false)),
      'external_reference_number' => new sfValidatorPass(array('required' => false)),
      'bank_country'              => new sfValidatorPass(array('required' => false)),
      'bank_code'                 => new sfValidatorPass(array('required' => false)),
      'account_holder'            => new sfValidatorPass(array('required' => false)),
      'account_number'            => new sfValidatorPass(array('required' => false)),
      'project'                   => new sfValidatorPass(array('required' => false)),
      'project_campaign'          => new sfValidatorPass(array('required' => false)),
      'payment_text'              => new sfValidatorPass(array('required' => false)),
      'ip'                        => new sfValidatorPass(array('required' => false)),
      'express_token'             => new sfValidatorPass(array('required' => false)),
      'express_url'               => new sfValidatorPass(array('required' => false)),
      'cancel_url'                => new sfValidatorPass(array('required' => false)),
      'return_url'                => new sfValidatorPass(array('required' => false)),
      'payer_id'                  => new sfValidatorPass(array('required' => false)),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('payment_data_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PaymentData';
  }

  public function getFields()
  {
    return array(
      'payment_id'                => 'Number',
      'method_class_name'         => 'Text',
      'subject'                   => 'Text',
      'internal_reference_number' => 'Text',
      'external_reference_number' => 'Text',
      'bank_country'              => 'Text',
      'bank_code'                 => 'Text',
      'account_holder'            => 'Text',
      'account_number'            => 'Text',
      'project'                   => 'Text',
      'project_campaign'          => 'Text',
      'payment_text'              => 'Text',
      'ip'                        => 'Text',
      'express_token'             => 'Text',
      'express_url'               => 'Text',
      'cancel_url'                => 'Text',
      'return_url'                => 'Text',
      'payer_id'                  => 'Text',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
    );
  }
}
