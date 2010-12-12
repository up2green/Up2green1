<?php

/**
 * profil filter form.
 *
 * @package    up2green
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profilFormFilter extends BaseprofilFormFilter
{
  public function configure()
  {
	  $this->widgetSchema['culture'] = new sfWidgetFormI18nChoiceLanguage(array(
		  'languages' => array_keys(sfConfig::get('app_cultures_enabled'))
	  ));

	  $this->validatorSchema['culture'] = new sfValidatorI18nChoiceLanguage();
  }
}
