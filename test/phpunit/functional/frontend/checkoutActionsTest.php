<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

/**
 * Test Frontend / Checkout / actions.class.php file
 *
 * @category Test
 * @package  Functional
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class functional_frontend_checkoutActionsTest extends FrontendFunctionalTestCase
{

  /**
   * Test the executeIndex method
   */
  public function testIndex()
  {
    $this->getBrowser()
      ->getAndCheck('checkout', 'index', '/checkout/index', 404)
    ;
  }

  /**
   * Test the executeCredit method
   */
  public function testCredit()
  {
    $this->getBrowser()
      ->get('/checkout/credit')
      ->isForwardedTo('sfGuardAuth', 'signin')
      // log in
      ->with('form')->begin()
      ->click('Se connecter', array(
        'signin' => array(
          'username' => self::$user['username'],
          'password' => self::$user['password']
        )))
      ->end()
      ->followRedirect()
      ->with('request')->begin()->
      isParameter('module', 'checkout')->
      isParameter('action', 'credit')->
      end()->
      with('response')->begin()->
      isStatusCode('200')->
      end()
    ;
  }

  /**
   * Test the executeCoupon method
   */
  public function testCoupon()
  {
    $this->getBrowser()
      ->get('/checkout/coupon')
      ->isForwardedTo('sfGuardAuth', 'signin')
      // log in
      ->with('form')->begin()
      ->click('Se connecter', array(
        'signin' => array(
          'username' => self::$user['username'],
          'password' => self::$user['password']
        )))
      ->end()
      ->followRedirect()
      ->with('request')->begin()->
      isParameter('module', 'checkout')->
      isParameter('action', 'coupon')->
      end()->
      with('response')->begin()->
      isStatusCode('200')->
      end()
    ;
  }

}
