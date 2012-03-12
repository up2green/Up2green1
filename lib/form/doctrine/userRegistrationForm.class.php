<?php

/**
 * formulaire d'inscription
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class userRegistrationForm extends PluginsfGuardUserForm
{

  public function setup()
  {
    parent::setup();
  }

  public function configure()
  {
    unset(
      $this['groups_list'], $this['permissions_list'], $this['algorithm'], $this['salt'], $this['is_active'], $this['is_super_admin'], $this['last_login'], $this['created_at'], $this['updated_at']
    );

    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->widgetSchema['password_bis'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['username'] = new sfValidatorString(array('required' => true), array(
        'invalid' => 'test'
      ));
    $this->validatorSchema['password'] = new sfValidatorString(array('required'   => true, 'min_length' => 6));
    $this->validatorSchema['password_bis'] = new sfValidatorString(array('required'   => true, 'min_length' => 6));
    $this->validatorSchema['email_address'] = new sfValidatorEmail(array('required' => true));

    $this->mergePostValidator(new sfValidatorSchemaCompare(
        'password',
        sfValidatorSchemaCompare::EQUAL,
        'password_bis'
    ));

    $profileForm = new profilForm($this->object->getProfile());
    unset(
      $profileForm['user_id'], $profileForm['id'], $profileForm['credit'], $profileForm['culture']
    );

    $this->embedForm('UserProfile', $profileForm);
  }

}