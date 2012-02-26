<?php

/**
 * Project class for Functional tests in the backend application
 *
 * @category Lib
 * @package  Test
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class BackendFunctionalTestCase extends FunctionalTestCase
{
  /**
   * @see FunctionalTestCase
   * @return string 
   */
  public function getApplication()
  {
    return 'backend';
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
