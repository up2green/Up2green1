<?php

/**
 * profil form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class profilForm extends BaseprofilForm
{

  public function configure()
  {
    $this->widgetSchema['is_newsletter'] = new sfWidgetFormInputCheckbox();
    $this->widgetSchema['culture'] = new sfWidgetFormI18nChoiceLanguage(array(
        'languages' => array_keys(sfConfig::get('app_cultures_enabled'))
      ));

    $this->validatorSchema['is_newsletter'] = new sfValidatorBoolean();
    $this->validatorSchema['culture'] = new sfValidatorI18nChoiceLanguage();

    $this->widgetSchema->setLabels(array(
      'is_newsletter' => 'Recevoir les newsletter',
      'credits'       => 'Crédits arbres',
      'culture'       => 'Langue',
    ));
  }

}
