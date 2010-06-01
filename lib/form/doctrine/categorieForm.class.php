<?php

/**
 * categorie form.
 *
 * @package    up2green
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categorieForm extends BasecategorieForm
{
  public function configure()
  {
        $this->embedI18n(array('en', 'fr'));
        $this->widgetSchema->setLabel('en', 'English');
        $this->widgetSchema->setLabel('fr', 'French');
  }
}
