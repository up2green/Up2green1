<?php

/**
 * MicropaymentDebitPaymentData form base class.
 *
 * @method MicropaymentDebitPaymentData getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMicropaymentDebitPaymentDataForm extends PaymentDataForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('micropayment_debit_payment_data[%s]');
  }

  public function getModelName()
  {
    return 'MicropaymentDebitPaymentData';
  }

}
