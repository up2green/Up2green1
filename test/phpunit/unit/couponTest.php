<?php

require_once dirname(__FILE__) . '/../bootstrap/doctrine.php';

class unit_couponTest extends UnitTestCase
{

  public function testCleanCodeTrim()
  {
    $this->assertEquals(libCoupon::cleanCode("   TEST "), "TEST", '::cleanCode() trim all white-spaces');
    $this->assertEquals(libCoupon::cleanCode("TEST    TEST"), "TESTTEST", '::cleanCode() clean spaces between two words');
  }

  public function testCleanCodeUppercase()
  {
    $this->assertEquals(libCoupon::cleanCode("test"), "TEST", '::cleanCode() uppercase');
    $this->assertEquals(strlen(libCoupon::getRandCode(16)), 16, '::getRandCode() returning the correct code size');
  }

  public function testCleanCodeSize()
  {
    $this->assertEquals(strlen(libCoupon::getRandCode(16)), 16, '::getRandCode() returning the correct code size');
  }

  /**
   * Test that the generated code is not already used
   */
  public function testCodeUnused()
  {
    $code   = libCoupon::getCodeUnused();
    $result = Doctrine_Core::getTable("coupon")
      ->createQuery('c')
      ->where('c.code = ?', $code)
      ->fetchOne();

    $this->assertEquals($result, false, '::getCodeUnused() get a random unused code without prefix');
  }

  /**
   * getCodeUnused must throw an Exception when the code already exist
   * 
   * @return void 
   */
  public function testCodeUsedException()
  {
    $code = libCoupon::getCodeUnused();
    $this->saveCode($code);

    try {
      libCoupon::getCodeUnused($code);
    } catch (Exception $e) {
      return;
    }

    $this->fail('Existing code must throw an Exception');
  }

  /**
   * Test that getRandCode throw an Exception when the prefix length is 
   * greater than the maximum
   * 
   * @return void
   */
  public function testRandCodeSizeException()
  {
    try {
      $supMaxPrefix = libCoupon::getRandCode(libCoupon::$length + 1);
      libCoupon::getCodeUnused($supMaxPrefix);
    } catch (Exception $e) {
      return;
    }

    $this->fail(sprintf("Trying to get a code with a suffix length > %s must throw an Exception", libCoupon::$length));
  }

  /**
   * Test the getCodeUnused method throw an Exception
   * when no more possibilities reached
   * 
   * @return void 
   */
  public function testCodeUnusedMaxPossibilities()
  {
    $randPrefix    = libCoupon::getRandCode(libCoupon::$length - 1);
    $possibilities = strlen(libCoupon::$acceptedChars);

    for ($i = 0; $i <= $possibilities; $i++) {
      if ($i == $possibilities) {
        try {
          libCoupon::getCodeUnused($randPrefix);
        } catch (Exception $e) {
          return;
        }

        $this->fail('No more possibilities to get an unused code must throw an Exception');
      } else {
        $this->saveCode(libCoupon::getCodeUnused($randPrefix));
      }
    }
  }

  /**
   * Persist a code in database
   * 
   * @param string $code 
   */
  protected function saveCode($code)
  {
    $couponGen = Doctrine_Core::getTable('couponGen')
      ->createQuery('cg')
      ->fetchOne();

    $coupon = new coupon();
    $coupon->setCode($code);
    $coupon->setCouponGen($couponGen);
    $coupon->save();
  }

}
