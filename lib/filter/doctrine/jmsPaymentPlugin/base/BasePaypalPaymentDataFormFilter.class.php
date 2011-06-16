<?php

/**
 * PaypalPaymentData filter form base class.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePaypalPaymentDataFormFilter extends PaymentDataFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('paypal_payment_data_filters[%s]');
  }

  public function getModelName()
  {
    return 'PaypalPaymentData';
  }
}
