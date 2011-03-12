<?php

/**
 * sfGuardChangeUserPasswordForm for changing a users password
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: sfGuardChangeUserPasswordForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class changeUserPasswordForm extends sfGuardChangeUserPasswordForm
{
  /**
   * @see sfForm
   */
	public function setup() {
		parent::setup();
		$this->widgetSchema['password_old'] = new sfWidgetFormInputPassword();
		$this->validatorSchema['password_old'] = clone $this->validatorSchema['password'];
		$this->validatorSchema['password_old']->setOption('required', true);
		$this->validatorSchema['password']->setOption('min_length', 6);
		$this->validatorSchema['password_again']->setOption('min_length', 6);
	}
}