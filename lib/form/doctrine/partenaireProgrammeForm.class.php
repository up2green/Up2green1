<?php

/**
 * partenaireProgramme form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class partenaireProgrammeForm extends BasepartenaireProgrammeForm
{

  public function configure()
  {
    unset($this['partenaire_id']);
    $this->widgetSchema['programme_id'] = new sfWidgetFormDoctrineChoice(array(
        'model'     => 'programme',
        'add_empty' => true,
      ));
    $this->validatorSchema['programme_id'] = new sfValidatorDoctrineChoice(array(
        'required' => true,
        'model'    => 'programme'
      ));
  }
}
