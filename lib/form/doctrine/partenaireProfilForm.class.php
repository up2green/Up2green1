<?php

/**
 * profil form.
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class partenaireProfilForm extends partenaireForm
{
  protected $canEmbedProgramme = false;

  public function configure()
  {

    parent::configure();

    /* Some attributes */
    $this->widgetSchema['title']->setAttribute('style', 'width:80%');
    $this->widgetSchema['url']->setAttribute('style', 'width:80%');
  }

  protected function removeFields()
  {
    unset(
      $this['created_at'], $this['updated_at'], $this['description'], 
      $this['programmes_list'], $this['page'], $this['attestation'], 
      $this['user_id'], $this['page_title']
    );
  }
}
