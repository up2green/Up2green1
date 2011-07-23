<?php

/**
 * partenaireLogo form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class partenaireLogoForm extends BasepartenaireLogoForm
{
  public function configure()
  {
	  unset($this['partenaire_id']);
		$this->widgetSchema['src'] = new sfWidgetFormInputFileEditable(array(
				'file_src'  => '/uploads/partenaire/'.$this->getObject()->getPartenaireId().'/'.$this->getObject()->getSrc(),
				'is_image'  => true,
				'edit_mode' => !$this->isNew(),
				'template'  => '<div>%file%<br />%input%</div>',
			));

	  $this->widgetSchema['src']->setAttribute('style', 'max-width: 200px;max-height: 200px;');
		
		$this->validatorSchema['src'] = new sfValidatorFile(array(
				'required'   => true,
				'path'       => sfConfig::get('sf_upload_dir').'/partenaire/'.$this->getObject()->getPartenaireId(),
				'mime_types' => 'web_images',
		));

		$this->validatorSchema['href'] = new sfValidatorUrl();
  }
}
