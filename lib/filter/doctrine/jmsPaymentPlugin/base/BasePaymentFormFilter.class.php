<?php

/**
 * Payment filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePaymentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'target_amount'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'approved_amount'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'approving_amount'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'deposited_amount'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'depositing_amount' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'currency'          => new sfWidgetFormChoice(array('choices' => array('' => '', 'EUR' => 'EUR', 'USD' => 'USD', 'JPY' => 'JPY', 'BGN' => 'BGN', 'CZK' => 'CZK', 'DKK' => 'DKK', 'EEK' => 'EEK', 'GBP' => 'GBP', 'HUF' => 'HUF', 'LTL' => 'LTL', 'LVL' => 'LVL', 'PLN' => 'PLN', 'RON' => 'RON', 'SEK' => 'SEK', 'CHF' => 'CHF', 'NOK' => 'NOK', 'HRK' => 'HRK', 'RUB' => 'RUB', 'TRY' => 'TRY', 'AUD' => 'AUD', 'BRL' => 'BRL', 'CAD' => 'CAD', 'CNY' => 'CNY', 'HKD' => 'HKD', 'IDR' => 'IDR', 'INR' => 'INR', 'KRW' => 'KRW', 'MXN' => 'MXN', 'MYR' => 'MYR', 'NZD' => 'NZD', 'PHP' => 'PHP', 'SGD' => 'SGD', 'THB' => 'THB', 'ZAR' => 'ZAR'))),
      'state'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'target_amount'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'approved_amount'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'approving_amount'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'deposited_amount'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'depositing_amount' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'currency'          => new sfValidatorChoice(array('required' => false, 'choices' => array('EUR' => 'EUR', 'USD' => 'USD', 'JPY' => 'JPY', 'BGN' => 'BGN', 'CZK' => 'CZK', 'DKK' => 'DKK', 'EEK' => 'EEK', 'GBP' => 'GBP', 'HUF' => 'HUF', 'LTL' => 'LTL', 'LVL' => 'LVL', 'PLN' => 'PLN', 'RON' => 'RON', 'SEK' => 'SEK', 'CHF' => 'CHF', 'NOK' => 'NOK', 'HRK' => 'HRK', 'RUB' => 'RUB', 'TRY' => 'TRY', 'AUD' => 'AUD', 'BRL' => 'BRL', 'CAD' => 'CAD', 'CNY' => 'CNY', 'HKD' => 'HKD', 'IDR' => 'IDR', 'INR' => 'INR', 'KRW' => 'KRW', 'MXN' => 'MXN', 'MYR' => 'MYR', 'NZD' => 'NZD', 'PHP' => 'PHP', 'SGD' => 'SGD', 'THB' => 'THB', 'ZAR' => 'ZAR'))),
      'state'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('payment_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Payment';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'target_amount'     => 'Number',
      'approved_amount'   => 'Number',
      'approving_amount'  => 'Number',
      'deposited_amount'  => 'Number',
      'depositing_amount' => 'Number',
      'currency'          => 'Enum',
      'state'             => 'Number',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
    );
  }
}
