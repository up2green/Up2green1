<?php
require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

/**
 * Test Frontend / Landing / Actions / plantationAction method
 * 
 * @category Test
 * @package  Frontend
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class functional_frontend_landingActionsTest extends FrontendFunctionalTestCase
{

  /**
   * Test the plantationAction return a 200 without parameter 
   */
  public function testPlantation()
  {
    $this->getBrowser()
      ->getAndCheck('landing', 'plantation', '/landing/plantation', 200)
    ;
  }

  /**
   * Test the plantationAction action with an empty voucher
   */
  public function testPlantationVoucherEmpty()
  {
    $this->getBrowser()
      ->get('/landing/plantation')
      ->click('Utiliser')
      ->isForwardedTo('landing', 'plantation')
    ;
  }

  /**
   *  Test the plantationAction action with an invalid voucher
   */
  public function testPlantationVoucherInvalid()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an expired voucher
   */
  public function testPlantationVoucherExpired()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an already used voucher
   */
  public function testPlantationVoucherAlreadyUsed()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an already used voucher
   */
  public function testPlantationVoucherValid()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an already used voucher
   */
  public function testPlantationPartner()
  {
    $this->getBrowser()
      ->getAndCheck('landing', 'plantation', '/landing/plantation/up2test', 200)
      ->with('request')->begin()
      ->isParameter('partenaire', 'up2test')
      ->end()
    ;
  }

  /**
   *  Test the plantationAction action with an invalid voucher
   */
  public function testPlantationPartnerVoucherInvalid()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an expired voucher
   */
  public function testPlantationPartnerVoucherExpired()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an already used voucher
   */
  public function testPlantationPartnerVoucherAlreadyUsed()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an already used voucher
   */
  public function testPlantationPartnerVoucherValid()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an already used voucher
   */
  public function testPlantationPartnerCampaign()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an invalid voucher
   */
  public function testPlantationPartnerCampaignVoucherInvalid()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an expired voucher
   */
  public function testPlantationPartnerCampaignVoucherExpired()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an already used voucher
   */
  public function testPlantationPartnerCampaignVoucherAlreadyUsed()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an already used voucher
   */
  public function testPlantationPartnerCampaignVoucherValid()
  {
    $this->markTestIncomplete('TODO');
  }

  /**
   *  Test the plantationAction action with an already used voucher
   */
  public function testPlantationVedifSpecial()
  {
    $this->getBrowser()
      ->getAndCheck('landing', 'plantation', '/landing/plantation/vedif/special', 200)
      ->with('request')->begin()
      ->isParameter('partenaire', 'vedif')
      ->isParameter('operation', 'special')
      ->end()
      ->with('response')->begin()
      ->checkElement('#but:contains("500 000")', true)
      ->end()
    ;
  }

}
