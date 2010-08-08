<?php

/**
 * programme form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class programmeForm extends BaseprogrammeForm {
    public function configure() {
        unset(
                $this['created_at'],
                $this['updated_at']
        );
        $this->languages = sfConfig::get('app_cultures_enabled');

        $langs = array_keys($this->languages);

        $this->embedI18n($langs);
        foreach($this->languages as $lang => $label) {
            $this->widgetSchema[$lang]->setLabel($label);
        }
    }
}
