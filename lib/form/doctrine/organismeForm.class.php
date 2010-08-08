<?php

/**
 * organisme form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class organismeForm extends BaseorganismeForm {
    public function configure() {
        unset(
                $this['created_at'],
                $this['updated_at']
        );
        $this->validatorSchema['url'] = new sfValidatorUrl();
      

        $this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable(array(
                        'label' => 'Logo',
                        'file_src'  => '/uploads/organisme/'.$this->getObject()->getLogo(),
                        'is_image'  => true,
                        'edit_mode' => !$this->isNew(),
                        'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
        ));

        $this->validatorSchema['logo'] = new sfValidatorFile(array(
                        'required'   => false,
                        'path'       => sfConfig::get('sf_upload_dir').'/organisme',
                        'mime_types' => 'web_images',
        ));
        $this->languages = sfConfig::get('app_cultures_enabled');

        $langs = array_keys($this->languages);

        $this->embedI18n($langs);
        foreach($this->languages as $lang => $label) {
            $this->widgetSchema[$lang]->setLabel($label);
        }
    }
}
