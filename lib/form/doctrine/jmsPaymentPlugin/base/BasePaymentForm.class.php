<?php

/**
 * Payment form base class.
 *
 * @method Payment getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePaymentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'target_amount'     => new sfWidgetFormInputText(),
      'approved_amount'   => new sfWidgetFormInputText(),
      'approving_amount'  => new sfWidgetFormInputText(),
      'deposited_amount'  => new sfWidgetFormInputText(),
      'depositing_amount' => new sfWidgetFormInputText(),
      'currency'          => new sfWidgetFormChoice(array('choices' => array('EUR' => 'EUR', 'USD' => 'USD', 'JPY' => 'JPY', 'BGN' => 'BGN', 'CZK' => 'CZK', 'DKK' => 'DKK', 'EEK' => 'EEK', 'GBP' => 'GBP', 'HUF' => 'HUF', 'LTL' => 'LTL', 'LVL' => 'LVL', 'PLN' => 'PLN', 'RON' => 'RON', 'SEK' => 'SEK', 'CHF' => 'CHF', 'NOK' => 'NOK', 'HRK' => 'HRK', 'RUB' => 'RUB', 'TRY' => 'TRY', 'AUD' => 'AUD', 'BRL' => 'BRL', 'CAD' => 'CAD', 'CNY' => 'CNY', 'HKD' => 'HKD', 'IDR' => 'IDR', 'INR' => 'INR', 'KRW' => 'KRW', 'MXN' => 'MXN', 'MYR' => 'MYR', 'NZD' => 'NZD', 'PHP' => 'PHP', 'SGD' => 'SGD', 'THB' => 'THB', 'ZAR' => 'ZAR'))),
      'state'             => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'target_amount'     => new sfValidatorNumber(),
      'approved_amount'   => new sfValidatorNumber(),
      'approving_amount'  => new sfValidatorNumber(),
      'deposited_amount'  => new sfValidatorNumber(),
      'depositing_amount' => new sfValidatorNumber(),
      'currency'          => new sfValidatorChoice(array('choices' => array(0 => 'EUR', 1 => 'USD', 2 => 'JPY', 3 => 'BGN', 4 => 'CZK', 5 => 'DKK', 6 => 'EEK', 7 => 'GBP', 8 => 'HUF', 9 => 'LTL', 10 => 'LVL', 11 => 'PLN', 12 => 'RON', 13 => 'SEK', 14 => 'CHF', 15 => 'NOK', 16 => 'HRK', 17 => 'RUB', 18 => 'TRY', 19 => 'AUD', 20 => 'BRL', 21 => 'CAD', 22 => 'CNY', 23 => 'HKD', 24 => 'IDR', 25 => 'INR', 26 => 'KRW', 27 => 'MXN', 28 => 'MYR', 29 => 'NZD', 30 => 'PHP', 31 => 'SGD', 32 => 'THB', 33 => 'ZAR'), 'required' => false)),
      'state'             => new sfValidatorInteger(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('payment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Payment';
  }

}
