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

  /**
   * Signs in the user on the application.
   *
   * @param sfGuardUser $user The sfGuardUser id
   * @param boolean $remember Whether or not to remember the user
   * @param Doctrine_Connection $con A Doctrine_Connection object
   */
  public function signIn($user, $remember = false, $con = null)
  {
    parent::signIn($user, $remember, $con);
    
    // remember?
    if ($remember)
    {
      $expiration_age = sfConfig::get('app_sf_guard_plugin_remember_key_expiration_age', 15 * 24 * 3600);

      // remove old keys
      Doctrine_Core::getTable('sfGuardRememberKey')->createQuery()
        ->delete()
        ->where('created_at < ?', date('Y-m-d H:i:s', time() - $expiration_age))
        ->execute();

      // remove other keys from this user
      Doctrine_Core::getTable('sfGuardRememberKey')->createQuery()
        ->delete()
        ->where('user_id = ?', $user->getId())
        ->execute();

      // generate new keys
      $key = $this->generateRandomKey();

      // save key
      $rk = new sfGuardRememberKey();
      $rk->setRememberKey($key);
      $rk->setUser($user);
      $rk->setIpAddress($_SERVER['REMOTE_ADDR']);
      $rk->save($con);

      // make key as a cookie
      $remember_cookie = sfConfig::get('app_sf_guard_plugin_remember_cookie_name', 'sfRemember');
      $remember_domain = sfConfig::get('app_sf_guard_plugin_remember_cookie_domain', '.up2green.com');
      
      sfContext::getInstance()->getResponse()->setCookie($remember_cookie, $key, time() + $expiration_age, '/', $remember_domain);
    }
  }
}
