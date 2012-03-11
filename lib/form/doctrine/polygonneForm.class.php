<?php

/**
 * polygonne form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class polygonneForm extends BasepolygonneForm
{

  public function configure()
  {
    $this->embedRelations(array(
      'Points' => array(
        'considerNewFormEmptyFields' => array('longitude', 'latitude', 'altitude'),
        'newFormLabel'         => 'Nouveau points',
        'multipleNewForms'     => true,
        'newFormsInitialCount' => 1,
      )
    ));
  }
}
