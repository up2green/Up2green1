<?php

/**
 * organismeTranslation form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class organismeTranslationForm extends BaseorganismeTranslationForm
{

  public function configure()
  {
    unset($this['slug']);
    $this->widgetSchema['accroche'] = new sfWidgetFormCKEditor(array('jsoptions' => array(
          'height'  => '75px',
          'toolbar' => 'Basic'
        )));
    $this->widgetSchema['description'] = new sfWidgetFormCKEditor();
  }
}
