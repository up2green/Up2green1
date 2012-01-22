<?php

class myUser extends sfGuardSecurityUser
{

  /**
   * Surcharge de la fonction setFlash pour permettre plusieurs flashes
   */
  public function setFlash($name, $value, $persist = true)
  {
    if ($this->hasFlash($name)) {
      $value = $this->getFlash($name) . '|' . $value;
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

  public function setPlantSession($params)
  {
    $this->setAttribute('plant-session', $params);
  }

  public function removePlantSession()
  {
    $this->getAttributeHolder()->remove('plant-session');
  }

  public function getPlantSession(array $defaults = array())
  {
    $session = $this->getAttribute('plant-session');
    $values = array_merge($defaults, (is_null($session) ? array() : $session));
    $this->setPlantSession($values);
    return $values;
  }

  public function setMapMode($params)
  {
    $this->setAttribute('map-mode', $params);
  }

  public function removeMapMode()
  {
    $this->getAttributeHolder()->remove('map-mode');
  }

  public function getMapMode(array $defaults)
  {
    $session = $this->getAttribute('map-mode');
    $values = array_merge($defaults, (is_null($session) ? array() : $session));
    $this->setMapMode($values);
    return $values;
  }

}
