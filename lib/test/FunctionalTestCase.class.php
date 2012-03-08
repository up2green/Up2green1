<?php

/**
 * Project class for Functional tests
 *
 * @category Lib
 * @package  Test
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class FunctionalTestCase extends sfPHPUnitBaseFunctionalTestCase
{
  public static $admin = array(
    'username' => 'admin',
    'password' => 'up2g@dm1n',
  );
  
  public static $user = array(
    'username' => 'admin',
    'password' => 'up2g@dm1n',
  );

  public static function getSimpleUser()
  {
    return Doctrine_Core::getTable('sfGuardUser')
        ->createQuery('u')
        ->leftJoin('u.Partenaire p')
        ->leftJoin('u.Permissions up')
        ->where('p.user_id IS NULL')
        ->addWhere('up.id IS NULL')
        ->fetchOne();
  }

  public static function getVoucher()
  {
    return Doctrine_Core::getTable('coupon')
        ->createQuery('c')
        ->where('c.created_at > (NOW() - INTERVAL 2 MONTH)')
        ->addWhere('c.is_active = ?', true)
        ->fetchOne();
  }

  /**
   * Shortcut form action that require login : test a first time
   * the action, if its forwarded with a 401 status and after the
   * login that the user is redirected to the url with a non generic 
   * template
   *
   * @param string $module
   * @param string $action
   * @param string $url
   * @param int $code 
   */
  protected function getAndCheckWithLogin($module, $action, $url = null, $code = 200)
  {
    $this->getBrowser()
      ->getAndCheck($module, $action, $url, 401)
      ->isForwardedTo('sfGuardAuth', 'signin')
      ->with('form')->begin()
      ->click('Se connecter', array(
        'signin' => array(
          'username' => self::$user['username'],
          'password' => self::$user['password']
        )))
      ->end()
      ->followRedirect()
      ->with('request')->begin()
        ->isParameter('module', $module)
        ->isParameter('action', $action)
      ->end()
      ->with('response')->begin()
        ->isStatusCode($code)
        ->checkElement('body', '!/This is a temporary page/')->
      end()
    ;
  }

}
