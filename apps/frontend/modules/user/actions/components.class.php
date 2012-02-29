<?php

class userComponents extends sfComponents
{

  /**
   * Execute the main menu
   *
   * @param sfWebRequest $request 
   */
  public function executeMenu(sfWebRequest $request)
  {
    if ($request->hasParameter('code')) {
      $coupon = Doctrine_Core::getTable('coupon')->findOneByCode($request->getParameter('code'));
      if ($coupon && !$coupon->getPartenaire()->isNew()) {
        $this->hideCreateAccount = $coupon->getPartenaire()->getPartenaire()->getId() == sfConfig::get("app_vedif_id");
      }
    }
  }

  public function executeMenuProfil()
  {
    $user = $this->getUser()->getGuardUser();
    $this->partenaire = ($user->isPartenaire() ? $user->getPartenaire() : null);
  }

  public function executeSideSignin()
  {
    $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
    $this->signinForm = new $class();
  }

  public function executeLanguage()
  {
    $this->languages = sfConfig::get('app_cultures_enabled');
    $this->current = $this->getUser()->getCulture();

    $this->form = new sfFormLanguage(
        $this->getUser(),
        array('languages' => array_keys($this->languages))
    );
  }

}