<?php

/**
 * userCoupon form base class.
 *
 * @method userCoupon getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
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
      'user_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'user_id', 'required' => false)),
      'coupon_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'coupon_id', 'required' => false)),
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
