<?php

class sfGuardSigninCustomForm extends BasesfGuardFormSignin
{

  public function configure()
  {
    parent::configure();

    $this->widgetSchema['password']->setLabel('Mot de passe');
    $this->widgetSchema['username']->setLabel('Identifiant ou E-Mail');
    $this->widgetSchema['remember']->setLabel('Se souvenir de moi');
    $this->widgetSchema['remember']->setDefault('on');

    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('login_form');
  }

}
