<?php

/**
 * profil form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class partenairePageForm extends partenaireForm
{
  protected $canEmbedProgramme = false;
  protected $canEmbedLogo      = false;

  public function configure()
  {
    parent::configure();
    $this->widgetSchema['page_title']->setAttribute('style', 'width:100%');
  }

  protected function removeFields()
  {
    unset(
      $this['created_at'], $this['updated_at'], $this['description'], 
      $this['accroche'], $this['attestation'], $this['programmes_list'], 
      $this['title'], $this['url'], $this['logo'], $this['user_id']
    );
  }
}
