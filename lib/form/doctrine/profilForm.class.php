<?php

/**
 * profil form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profilForm extends BaseprofilForm
{
  public function configure()
  {
		$this->setWidgets(array(
			'is_newsletter' => new sfWidgetFormInputCheckbox(),
		));

		$this->setValidators(array(
			'is_newsletter' => new sfValidatorBoolean()
		));
		
		$this->widgetSchema->setLabels(array(
			'is_newsletter' => 'Recevoir les newsletter'
		));
  }
}
