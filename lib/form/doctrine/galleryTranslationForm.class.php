<?php

/**
 * galleryTranslation form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Clément Gautier
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class galleryTranslationForm extends BasegalleryTranslationForm
{
  public function configure()
  {
    unset($this['slug']);
    $this->widgetSchema['description'] = new sfWidgetFormCKEditor();
  }
}
