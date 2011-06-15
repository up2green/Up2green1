<?php

/**
 * profil form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class partenaireProfilForm extends partenaireForm
{
	public function configure()	{	
		
		parent::configure();
				
		/* Some attributes */
		$this->widgetSchema['title']->setAttribute('style', 'width:80%');
		$this->widgetSchema['url']->setAttribute('style', 'width:80%');
		$this->widgetSchema['logo']->setAttribute('style', 'max-width: 200px;max-height: 200px;');
	}
	
	protected function removeFields() {
		unset(
			$this['created_at'], 
			$this['updated_at'], 
			$this['description'], 
			$this['programmes_list'], 
			$this['page'], 
			$this['attestation'], 
			$this['user_id']
		);
	}
}
