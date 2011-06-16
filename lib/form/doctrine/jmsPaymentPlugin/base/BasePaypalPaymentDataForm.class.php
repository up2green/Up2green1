<?php

/**
 * PaypalPaymentData form base class.
 *
 * @method PaypalPaymentData getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePaypalPaymentDataForm extends PaymentDataForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('paypal_payment_data[%s]');
  }

  public function getModelName()
  {
    return 'PaypalPaymentData';
  }

}
