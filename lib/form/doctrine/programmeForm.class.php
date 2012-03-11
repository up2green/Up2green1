<?php

/**
 * programme form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class programmeForm extends BaseprogrammeForm
{

  public function configure()
  {
    parent::configure();

    $this->embedRelations(array(
      'Point' => array(
        'considerNewFormEmptyFields' => array('longitude', 'latitude', 'altitude'),
        'newFormLabel'         => 'Point',
        'newFormClass'         => 'programmePointForm',
        'multipleNewForms'     => false,
        'newFormsInitialCount' => 1,
        'formClassArgs'        => array(array('ah_add_delete_checkbox' => false))
      )
    ));

    unset(
      $this['created_at'], $this['updated_at']
    );

    $this->widgetSchema['polygonnes_list'] = new sfWidgetFormDoctrineChoice(array(
        'model'    => 'polygonne',
        'multiple' => true,
        'order_by' => array('unique_name', 'asc')
      ));

    $this->validatorSchema['polygonnes_list'] = new sfValidatorDoctrineChoice(array(
        'model'    => 'polygonne',
        'required' => false,
      ));

    $this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
        'label'     => 'Logo',
        'file_src'  => '/uploads/programme/' . $this->getObject()->getLogo(),
        'is_image'  => true,
        'edit_mode' => !$this->isNew(),
        'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
      ));

    $this->validatorSchema['logo'] = new sfValidatorFile(array(
        'required'   => false,
        'path'       => sfConfig::get('sf_upload_dir') . '/programme',
        'mime_types' => 'web_images',
      ));

    $this->languages = sfConfig::get('app_cultures_enabled');

    $langs = array_keys($this->languages);

    $this->embedI18n($langs);
    foreach ($this->languages as $lang => $label) {
      $this->widgetSchema[$lang]->setLabel($label);
    }
  }

}
