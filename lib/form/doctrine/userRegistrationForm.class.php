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

        $this->widgetSchema->setLabels(array(
                'username'     => 'Nom d\'utilisateur* :',
                'password'     => 'Mot de passe* :',
                'password_bis' => 'Confirmation* :',
        ));

        $this->validatorSchema['username']     = new sfValidatorString(array('required' => true), array('invalid' => 'Cet nom n\'est pas valide.', 'required' => 'Champ obligatoire.'));
        $this->validatorSchema['password']     = new sfValidatorString(array('required' => true, 'min_length' => 6), array('min_length' => '"%value%" est trop court (%min_length% lettres minimum).', 'required' => 'Champ obligatoire.'));
        $this->validatorSchema['password_bis'] = new sfValidatorString(array('required' => true, 'min_length' => 6), array('min_length' => '"%value%" est trop court (%min_length% lettres minimum).', 'required' => 'Champ obligatoire.'));

        $this->mergePostValidator(new sfValidatorSchemaCompare(
                'password',
                sfValidatorSchemaCompare::EQUAL,
                'password_bis',
                array(),
                array('invalid' => 'Les champs doivent être identiques.')
        ));

        $profileForm = new profilForm($this->object->userProfile);
        unset(
                $profileForm['user_id'],
                $profileForm['id'],
                $profileForm['credit'],
                $profileForm['is_newsletter'],
                $profileForm['culture']
        );
        $profileForm->widgetSchema->setLabels(array('mail' => 'Adresse e-mail* :'));

        $this->embedForm('UserProfile', $profileForm);
    }

}