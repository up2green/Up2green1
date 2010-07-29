<?php

/**
 * coupon form base class.
 *
 * @method coupon getObject() Returns the current form's model object
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecouponForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'code'       => new sfWidgetFormInputText(),
      'credit'     => new sfWidgetFormInputText(),
      'is_active'  => new sfWidgetFormInputCheckbox(),
      'used_at'    => new sfWidgetFormDateTime(),
      'used_by'    => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'code'       => new sfValidatorString(array('max_length' => 128)),
      'credit'     => new sfValidatorInteger(array('required' => false)),
      'is_active'  => new sfValidatorBoolean(array('required' => false)),
      'used_at'    => new sfValidatorDateTime(array('required' => false)),
      'used_by'    => new sfValidatorInteger(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'coupon', 'column' => array('code')))
    );

    $this->widgetSchema->setNameFormat('coupon[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'coupon';
  }

}
