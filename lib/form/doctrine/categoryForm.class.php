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
        $this->embedI18n(array('en', 'fr'));
        $this->widgetSchema->setLabel('en', 'English');
        $this->widgetSchema->setLabel('fr', 'French');
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
