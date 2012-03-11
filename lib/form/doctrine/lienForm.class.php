<?php

/**
 * lien form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class lienForm extends BaselienForm
{

  public function configure()
  {
    unset(
      $this['created_at'], $this['updated_at']
    );

    $this->languages = sfConfig::get('app_cultures_enabled');

    $this->widgetSchema['category_id'] = new sfWidgetFormDoctrineChoice(array(
        'model'     => 'category',
        'add_empty' => '~ (object is at root level)',
        'order_by'  => array('root_id, lft', ''),
        'method' => 'getIndentedName'
      ));

    $this->validatorSchema['category_id'] = new sfValidatorDoctrineChoice(array(
        'required' => false,
        'model'    => 'category'
      ));

    $langs = array_keys($this->languages);

    $this->embedI18n($langs);
    foreach ($this->languages as $lang => $label) {
      $this->widgetSchema[$lang]->setLabel($label);
    }
  }
}
