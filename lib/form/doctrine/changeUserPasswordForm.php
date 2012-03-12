<?php

/**
 * sfGuardChangeUserPasswordForm for changing a users password
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class changeUserPasswordForm extends sfGuardChangeUserPasswordForm
{
  /**
   * @see sfForm
   */
	public function setup()
  {
		parent::setup();
		$this->widgetSchema['password_old'] = new sfWidgetFormInputPassword();
		$this->validatorSchema['password_old'] = clone $this->validatorSchema['password'];
		$this->validatorSchema['password_old']->setOption('required', true);
		$this->validatorSchema['password']->setOption('min_length', 6);
		$this->validatorSchema['password_again']->setOption('min_length', 6);
	}
}