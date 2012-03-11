<?php

/**
 * newsletterTranslation form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class newsletterTranslationForm extends BasenewsletterTranslationForm
{

  public function configure()
  {
    unset($this['slug']);
    $this->widgetSchema['content'] = new sfWidgetFormCKEditor();
  }
}
