<?php

/**
 * lien form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lienForm extends BaselienForm {
    public function configure() {
        unset(
                $this['created_at'],
                $this['updated_at']
        );
        $this->validatorSchema['url'] = new sfValidatorUrl();
        $this->languages = sfConfig::get('app_cultures_enabled');

        $this->widgetSchema['category_list'] = new sfWidgetFormDoctrineChoiceNestedSet(array(
                        'model'=>'Category',
                        'add_empty' => "",
                        "multiple"=>true
        ));
        $langs = array_keys($this->languages);

        $this->embedI18n($langs);
        foreach($this->languages as $lang => $label) {
            $this->widgetSchema[$lang]->setLabel($label);
        }
    }
}
