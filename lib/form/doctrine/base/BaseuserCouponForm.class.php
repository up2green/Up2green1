<?php

/**
 * userCoupon form base class.
 *
 * @method userCoupon getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseuserCouponForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'   => new sfWidgetFormInputHidden(),
      'coupon_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'user_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user_id')), 'empty_value' => $this->getObject()->get('user_id'), 'required' => false)),
      'coupon_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('coupon_id')), 'empty_value' => $this->getObject()->get('coupon_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_coupon[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'userCoupon';
  }

}
