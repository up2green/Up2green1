<?php

class myUser extends sfGuardSecurityUser
{
    public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
  {
    parent::initialize($dispatcher, $storage, $options);

    $this->setCulture('fr');
  }
}
