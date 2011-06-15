<?php

/**
 * profil form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profilPartenaireForm extends BasepartenaireForm
{
	public function configure()	{		
		unset(
			$this['created_at'], 
			$this['updated_at'], 
			$this['description'], 
			$this['user_id']
		);
		
		/* Widgets */
		
		$this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
			'file_src'  => '/uploads/partenaire/'.$this->getObject()->getLogo(),
			'is_image'  => true,
			'with_delete'  => true,
			'edit_mode' => !$this->isNew(),
			'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
		));

		$this->widgetSchema['accroche'] = new sfWidgetFormCKEditor(array('jsoptions'=>array(
			'height' 	=> '75px',
			'toolbar'	=> 'Basic'
		)));
		
		/* Validators */
		
		$this->validatorSchema['logo'] = new sfValidatorFile(array(
			'required'   => false,
			'path'       => sfConfig::get('sf_upload_dir').'/partenaire',
			'mime_types' => 'web_images',
		));
		
		$this->validatorSchema['logo_delete'] = new sfValidatorPass();;
		
		$this->validatorSchema['url'] = new sfValidatorUrl();
		
		/* Some attributes */
		
		$this->widgetSchema['title']->setAttribute('style', 'width:80%');
		$this->widgetSchema['url']->setAttribute('style', 'width:80%');
		$this->widgetSchema['logo']->setAttribute('style', 'max-width: 200px;max-height: 200px;');
	}
}
