<?php

/**
 * newsletter form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsletterForm extends BasenewsletterForm {
    protected $langages;
    protected $I18nFormsIgnored = array();
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

    protected function doBind(array $values) {
        foreach($this->languages as $lang => $label) {
            if($this->embeddedI18nFormEmpty($values[$lang])) {
                $this->I18nFormsIgnored[] = $lang;
                unset(
                        $values[$lang],
                        $this[$lang]
                );
            }
        }

        parent::doBind($values);
    }

    protected function embeddedI18nFormEmpty(array $values) {
        foreach($values as $key => $value) {
            if(in_array($key, array('id', 'lang', 'title', 'content')))
                continue;

            if('' !== trim($value)) {
                return false;
            }
        }
        return true;
    }
    protected function doUpdateObject($values) {
        

        foreach($this->I18nFormsIgnored as $lang) {
            unset($this->object->Translation[$lang]);
            unset($values[$lang]);
        }
        parent::doUpdateObject($values);
    }
}
