<?php

/**
 * engine form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class engineForm extends BaseengineForm
{

  public function configure()
  {
    unset(
      $this['created_at'], $this['updated_at']
    );

    $this->widgetSchema['id_plateforme'] = new sfWidgetFormDoctrineChoice(array(
        'model' => 'affiliatePlateforme',
      ));

    $this->validatorSchema['id_plateforme'] = new sfValidatorDoctrineChoice(array(
        'required' => true,
        'model'    => 'affiliatePlateforme'
      ));

    $this->widgetSchema['id_devise'] = new sfWidgetFormDoctrineChoice(array(
        'model' => 'devise',
      ));

    $this->validatorSchema['id_devise'] = new sfValidatorDoctrineChoice(array(
        'required' => true,
        'model'    => 'devise'
      ));
  }
}
