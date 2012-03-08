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
   * Test the executeCredit method
   */
  public function testCredit()
  {
    $this->getAndCheckWithLogin('checkout', 'credit', '/checkout/credit');
  }

  /**
   * Test the executeCoupon method
   */
  public function testCoupon()
  {
    $this->getAndCheckWithLogin('checkout', 'coupon', '/checkout/coupon');
  }

}
