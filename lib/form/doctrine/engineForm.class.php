<?php

/**
 * engine form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class engineForm extends BaseengineForm
{
  public function configure()
  {
	unset(
		$this['created_at'],
		$this['updated_at']
	);

	$this->widgetSchema['id_plateforme'] = new sfWidgetFormDoctrineChoice(array(
		'model' => 'affiliatePlateforme',
	));

	$this->validatorSchema['id_plateforme'] = new sfValidatorDoctrineChoice(array(
		'required' => true,
		'model' => 'affiliatePlateforme'
	));

	$this->widgetSchema['id_devise'] = new sfWidgetFormDoctrineChoice(array(
		'model' => 'devise',
	));

	$this->validatorSchema['id_devise'] = new sfValidatorDoctrineChoice(array(
		'required' => true,
		'model' => 'devise'
	));
  }
}
