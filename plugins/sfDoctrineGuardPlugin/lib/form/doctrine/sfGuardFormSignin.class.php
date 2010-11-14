<?php

/**
 * sfGuardFormSignin for sfGuardAuth signin action
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardFormSignin.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */

class sfGuardFormSignin extends BasesfGuardFormSignin
{
  /**
   * @see sfForm
   */
	public function setup() {
		parent::setup();
	}
	
	public function configure()
	{
		parent::configure();
		$this->widgetSchema['password']->setLabel('Mot de passe');

		if (sfConfig::get('app_sf_guard_plugin_allow_login_with_email', true))
		{
		  $this->widgetSchema['username']->setLabel('Identifiant ou E-Mail');
		}
	}
}
