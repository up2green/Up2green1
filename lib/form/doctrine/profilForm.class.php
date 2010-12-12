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
	public function configure()	{

		$this->widgetSchema['is_newsletter'] = new sfWidgetFormInputCheckbox();
		$this->widgetSchema['culture'] = new sfWidgetFormI18nChoiceLanguage(array(
			'languages' => array_keys(sfConfig::get('app_cultures_enabled'))
		));

		$this->validatorSchema['is_newsletter'] = new sfValidatorBoolean();
		$this->validatorSchema['culture'] = new sfValidatorI18nChoiceLanguage();

		$this->widgetSchema->setLabels(array(
			'is_newsletter' => 'Recevoir les newsletter',
			'credits' => 'Crédits arbres',
			'culture' => 'Langue',
		));
	}
}
