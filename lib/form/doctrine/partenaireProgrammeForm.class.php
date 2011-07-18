<?php

/**
 * partenaireProgramme form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class partenaireProgrammeForm extends BasepartenaireProgrammeForm
{
  public function configure()
  {
    unset($this['partenaire_id']);
    $this->widgetSchema['programme_id'] = new sfWidgetFormDoctrineChoice(array(
		'model' => 'programme',
		'add_empty' => true,
	));
    $this->validatorSchema['programme_id'] = new sfValidatorDoctrineChoice(array(
		'required' => true,
		'model' => 'programme'
    ));
  }
}
