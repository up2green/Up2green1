<?php

require_once dirname(__FILE__).'/../../bootstrap/functional.php';

class functional_frontend_checkoutActionsTest extends FunctionalTestCase
{

  public function getApplication()
  {
    return 'frontend';
  }
 
  public function testDefault()
  {
    $this->markTestIncomplete('TODO');
//    $browser = $this->getBrowser();
//    $user = $browser->getSimpleUser();
//
//    $browser->
//      info('1 - index')->
//      get('/checkout/index')->
//
//      with('request')->begin()->
//        isParameter('module', 'checkout')->
//        isParameter('action', 'index')->
//      end()->
//
//      with('response')->begin()->
//        isStatusCode(404)->
//      end()->
//
//      info('2 - Checkout credits')->
//      get('/checkout/credit')->
//      info('2.1 - Test login')->
//
//      isForwardedTo('sfGuardAuth', 'signin')->
//
//      // log in
//      with('form')->begin()->
//        click('Se connecter', array(
//          'signin' => array(
//            'username' => myTestFunctional::$user['username'],
//            'password' => myTestFunctional::$user['password']
//          )))->
//        end()->
//      followRedirect()->
//
//      info('2.2 - Test redirect & status')->
//
//      with('request')->begin()->
//        isParameter('module', 'checkout')->
//        isParameter('action', 'credit')->
//      end()->
//
//      with('response')->begin()->
//        isStatusCode('200')->
//      end()->
//
//      info('3 - Checkout coupons')->
//      //clearCookies()->
//      get('/checkout/coupon')->
//
//      //isForwardedTo('sfGuardAuth', 'signin')->
//
//      // log in
//      /*with('form')->begin()->
//        click('Se connecter', array(
//          'signin' => array(
//            'username' => myTestFunctional::$user['username'],
//            'password' => myTestFunctional::$user['password']
//          )))->
//        end()->
//      followRedirect()->
//      */
//      with('request')->begin()->
//        isParameter('module', 'checkout')->
//        isParameter('action', 'coupon')->
//      end()->
//
//      with('response')->begin()->
//        isStatusCode('200')->
//      end()
//
//    ;
  }
}
