<?php

/**
 * polygonne form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class polygonneForm extends BasepolygonneForm
{
  public function configure()
  {
		$this->embedRelations(array(
			'Points' => array(
				'considerNewFormEmptyFields'		=> array('longitude', 'latitude', 'altitude'),
				'newFormLabel'                  => 'Nouveau points',
				'multipleNewForms'              => true,
				'newFormsInitialCount'          => 1,
			)
		));
		
  }
}
