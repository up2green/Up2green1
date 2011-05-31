<?php
/**
 * formulaire d'inscription
 *
 * @package    form
 * @subpackage sfGuardUser
 * @author     Lexik
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */



class userRegistrationForm extends PluginsfGuardUserForm {

	public function setup() {
		parent::setup();
	}

    public function configure() {
        unset(
                $this['groups_list'],
                $this['permissions_list'],
                $this['algorithm'],
                $this['salt'],
                $this['is_active'],
                $this['is_super_admin'],
                $this['last_login'],
                $this['created_at'],
                $this['updated_at']
        );
		
        $this->widgetSchema['password']     = new sfWidgetFormInputPassword();
        $this->widgetSchema['password_bis'] = new sfWidgetFormInputPassword();
        $this->validatorSchema['username']     = new sfValidatorString(array('required' => true), array(
						'invalid'=> 'test'
				));
        $this->validatorSchema['password']     = new sfValidatorString(array('required' => true, 'min_length' => 6));
        $this->validatorSchema['password_bis'] = new sfValidatorString(array('required' => true, 'min_length' => 6));
        $this->validatorSchema['email_address']= new sfValidatorEmail(array('required'  => true));

				$this->mergePostValidator(new sfValidatorSchemaCompare(
                'password',
                sfValidatorSchemaCompare::EQUAL,
                'password_bis'
        ));

        $profileForm = new profilForm($this->object->getProfile());
        unset(
                $profileForm['user_id'],
                $profileForm['id'],
                $profileForm['credit'],
                $profileForm['culture']
        );

        $this->embedForm('UserProfile', $profileForm);
    }

}