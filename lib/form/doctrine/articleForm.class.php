<?php

/**
 * article form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class articleForm extends BasearticleForm 
{
	public function configure() 
	{
		unset(
			$this['created_at'],
			$this['updated_at']
		);

		$this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
			'label' => 'Logo',
			'file_src'  => '/uploads/article/'.$this->getObject()->getLogo(),
			'is_image'  => true,
			'edit_mode' => !$this->isNew(),
			'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
		));

		$this->validatorSchema['logo'] = new sfValidatorFile(array(
			'required'   => false,
			'path'       => sfConfig::get('sf_upload_dir').'/article',
			'mime_types' => 'web_images',
		));

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

		$this->languages = sfConfig::get('app_cultures_enabled');

		$langs = array_keys($this->languages);

		$this->embedI18n($langs);
		foreach($this->languages as $lang => $label) {
				$this->widgetSchema[$lang]->setLabel($label);
		}
	}
}
