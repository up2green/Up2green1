<?php

/**
 * profil form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class partenairePageForm extends partenaireForm
{	
	protected function removeFields() {
		unset(
			$this['created_at'], 
			$this['updated_at'], 
			$this['description'], 
			$this['accroche'], 
			$this['attestation'], 
			$this['programmes_list'], 
			$this['title'], 
			$this['url'], 
			$this['logo'], 
			$this['user_id']
		);
	}
}