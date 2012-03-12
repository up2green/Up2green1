<?php

/**
 * organisme form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class organismeForm extends BaseorganismeForm
{

  public function configure()
  {

    parent::configure();
    $pointForm = new organismePointForm($this->object->Point);
    unset($pointForm['id'], $pointForm['type']);
    $this->embedForm('Point', $pointForm);

    unset(
      $this['created_at'], $this['updated_at'], $this['point_id']
    );

    $this->validatorSchema['url'] = new sfValidatorUrl();


    $this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
        'label'     => 'Logo',
        'file_src'  => '/uploads/organisme/' . $this->getObject()->getLogo(),
        'is_image'  => true,
        'edit_mode' => !$this->isNew(),
        'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
      ));

    $this->validatorSchema['logo'] = new sfValidatorFile(array(
        'required'   => false,
        'path'       => sfConfig::get('sf_upload_dir') . '/organisme',
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
