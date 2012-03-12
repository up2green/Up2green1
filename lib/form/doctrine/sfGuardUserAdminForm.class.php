<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @category Lib
 * @package  Form
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm
{

  /**
   * @see sfForm
   */
  public function configure()
  {
    parent::configure();
    $profileForm = new profilForm($this->object->Profile);
    unset($profileForm['id'], $profileForm['user_id']);
    $this->embedForm('Profile', $profileForm);
  }

}
