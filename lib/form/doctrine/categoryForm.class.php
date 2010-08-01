<?php

/**
 * category form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryForm extends BasecategoryForm {
    public function configure() {
        unset(
                $this['root_id'],
                $this['lft'],
                $this['rgt'],
                $this['level']
        );
        $this->languages = sfConfig::get('app_cultures_enabled');

        $langs = array_keys($this->languages);

        $this->embedI18n($langs);
        foreach($this->languages as $lang => $label) {
            $this->widgetSchema[$lang]->setLabel($label);
        }
    }

    protected function doSave($con = null) {
        if (file_exists($this->getObject()->getFile())) {
            unlink($this->getObject()->getFile());
        }

        $file = $this->getValue('file');
        $filename = sha1($file->getOriginalName()).$file->getExtension($file->getOriginalExtension());
        $file->save(sfConfig::get('sf_upload_dir').'/'.$filename);

        return parent::doSave($con);
    }
}
