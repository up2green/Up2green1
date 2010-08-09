<?php

/**
 * organismeTranslation form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class organismeTranslationForm extends BaseorganismeTranslationForm {
    public function configure() {
//        $this->widgetSchema['description'] = new sfWidgetFormTextareaCKEditor(array('custom_config' => '/js/ckeditor_config.js', 'toolbar' => 'Basic', 'config' => array('width' => '800px', 'height' => '100px')));
        $this->widgetSchema['description'] = new sfWidgetFormCKEditor();
    }
}
