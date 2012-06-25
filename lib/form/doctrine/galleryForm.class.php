<?php

/**
 * gallery form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class galleryForm extends BasegalleryForm
{

  public function configure()
  {
    $this->embedRelations(array(
      'Pictures' => array(
        'considerNewFormEmptyFields' => array('src'),
        'newFormLabel'         => 'New picture',
        'multipleNewForms'     => true,
        'newFormsInitialCount' => 1,
      )
    ));

    // In case we dont have any pictures yet we have to had a fake form
    if (!isset($this['Pictures'])) {
      $this->widgetSchema['Pictures'] = new sfWidgetFormInputHidden();
      $this->validatorSchema['Pictures'] = new sfValidatorPass();
    }

    unset(
      $this['created_at'], $this['updated_at']
    );

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

    $this->languages = sfConfig::get('app_cultures_enabled');
    $this->embedI18n(array_keys($this->languages));

    foreach ($this->languages as $lang => $label)
    {
      $this->widgetSchema[$lang]->setLabel($label);
    }
  }
}
