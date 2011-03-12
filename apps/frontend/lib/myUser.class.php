<?php

class myUser extends sfGuardSecurityUser {
	/**
   * Surcharge de la fonction setFlash pour permettre plusieurs flashes
   */
  public function setFlash($name, $value, $persist = true)
  {
    if ($this->hasFlash($name)) {
		$value = $this->getFlash($name).'|'.$value;
    }

	return parent::setFlash($name, $value, $persist);
  }

  /**
   * surcharge de getFlash pour permettre plusieurs flashes
   */
  public function getFlashArray($name, $default = null)
  {
    return explode('|', parent::getFlash($name, $default));
  }
}
