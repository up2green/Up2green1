<?php

/**
 * logCoupon form base class.
 *
 * @method logCoupon getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaselogCouponForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'ip'         => new sfWidgetFormInputText(),
      'email'      => new sfWidgetFormInputText(),
      'coupon_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('coupon'), 'add_empty' => false)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ip'         => new sfValidatorString(array('max_length' => 15)),
      'email'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'coupon_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('coupon'))),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'logCoupon', 'column' => array('coupon_id')))
    );

    $this->widgetSchema->setNameFormat('log_coupon[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'logCoupon';
  }

}
