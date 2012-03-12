<?php

/**
 * generationCouponPartenaire form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class generationCouponPartenaireForm extends BaseForm
{

  public function configure()
  {
    $this->setWidgets(array(
      'type_coupon' => new sfWidgetFormSelect(array('choices' => couponGenTable::getTabChoices())),
      'nombre'  => new sfWidgetFormInputText(),
      'prefix'  => new sfWidgetFormInputText()
    ));
    $this->setValidators(array(
      'type_coupon' => new sfValidatorChoice(array('choices'  => array_keys(couponGenTable::getTabChoices()), 'required' => 'true')),
      'nombre'   => new sfValidatorInteger(array('required' => 'true')),
      'prefix'   => new sfValidatorString(array(
        'max_length' => '5',
        'required'   => false
      )),
    ));

    $this->widgetSchema->setNameFormat('couponPartenaire[%s]');
  }
}