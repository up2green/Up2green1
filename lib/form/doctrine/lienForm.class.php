<?php

/**
 * lien form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lienForm extends BaselienForm 
{
	public function configure() 
	{
		unset(
			$this['created_at'],
			$this['updated_at']
		);
		
		$this->languages = sfConfig::get('app_cultures_enabled');

		$this->widgetSchema['category_id'] = new sfWidgetFormDoctrineChoice(array(
			'model' => 'category',
			'add_empty' => '~ (object is at root level)',
			'order_by' => array('root_id, lft',''),
			'method' => 'getIndentedName'
		));
		
		$this->validatorSchema['category_id'] = new sfValidatorDoctrineChoice(array(
			'required' => false,
			'model' => 'category'
		));
		
		$langs = array_keys($this->languages);

		$this->embedI18n($langs);
		foreach($this->languages as $lang => $label) {
				$this->widgetSchema[$lang]->setLabel($label);
		}
	}
}
