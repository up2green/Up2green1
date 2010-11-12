<?php

/**
 * sfGuardUser form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserForm extends PluginsfGuardUserForm
{
  public function configure()
  {
		unset($this['created_at'], $this['updated_at']);
		
		$this->widgetSchema->setLabels(array(
			'first_name' => 'Prénom',
			'last_name' => 'Nom',
			'email_address' => 'E-mail',
			'username' => 'Identifiant',
			'password' => 'Mot de passe',
			'is_active' => 'Actif'
		));
  }
}
