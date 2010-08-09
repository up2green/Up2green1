<?php

/**
 * articleTranslation form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class articleTranslationForm extends BasearticleTranslationForm
{
  public function configure()
  {
          unset($this['slug']);
          $this->widgetSchema['description'] = new sfWidgetFormCKEditor();
  }
}
