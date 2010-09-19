<?php

/**
 * partenaire form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class partenaireForm extends BasepartenaireForm
{
  public function configure()
  {
		unset($this['created_at'], $this['updated_at']);
		
		$this->validatorSchema['url'] = new sfValidatorUrl();

		$this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
			'label' => 'Logo',
			'file_src'  => '/uploads/partenaire/'.$this->getObject()->getLogo(),
			'is_image'  => true,
			'edit_mode' => !$this->isNew(),
			'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
		));
		
		$this->widgetSchema['programmes'] = new sfWidgetFormDoctrineChoice(array(
			'model' => 'programme', 
			'add_empty' => true,
			'multiple' => true
		));

		$this->validatorSchema['logo'] = new sfValidatorFile(array(
			'required'   => false,
			'path'       => sfConfig::get('sf_upload_dir').'/partenaire',
			'mime_types' => 'web_images',
		));
		
		$this->widgetSchema['accroche'] = new sfWidgetFormCKEditor(array('jsoptions'=>array(
			'height' 	=> '75px',
			'toolbar'	=> 'Basic'
		)));
		
		$this->widgetSchema['description'] = new sfWidgetFormCKEditor();
  }
}
