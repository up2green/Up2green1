<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

class functional_frontend_landingActionsTest extends FunctionalTestCase
{

  public function getApplication()
  {
    return 'frontend';
  }

  public function testDefault()
  {
    $browser = $this->getBrowser();

    $browser
      ->info('1 - Landing Plantation (simple)')
      ->get('/landing/plantation')
      ->with('request')->begin()
        ->isParameter('module', 'landing')
        ->isParameter('action', 'plantation')
      ->end()
      ->with('response')->begin()
        ->isStatusCode(200)
      ->end()

      ->info('1.1 - Empty code')
      ->click('Utiliser')
      ->isForwardedTo('landing', 'plantation')
      //->testNotification
      //
      ->info('1.2 - Fake code')
      ->info('1.3 - Expired voucher')
      ->info('1.4 - Already used voucher')
      ->info('1.5 - Valid voucher')

      ->info('2 - Landing Plantation (with partner)')
      ->get('/landing/plantation/up2test')
      ->with('request')->begin()
        ->isParameter('module', 'landing')
        ->isParameter('action', 'plantation')
        ->isParameter('partenaire', 'up2test')
      ->end()
      ->with('response')->begin()
        ->isStatusCode(200)
      ->end()

      ->info('2.1 - Empty code')
      ->info('2.2 - Fake code')
        ->info('2.3 - Expired voucher')
        ->info('2.4 - Already used voucher')
      ->info('2.5 - Valid voucher')

      ->info('3 - Landing Plantation (with partner and campaign)')
      ->get('/landing/plantation/up2test')
      ->with('request')->begin()
        ->isParameter('module', 'landing')
        ->isParameter('action', 'plantation')
        ->isParameter('partenaire', 'up2test')
      ->end()
      ->with('response')->begin()
        ->isStatusCode(200)
      ->end()

      ->info('3.1 - Empty code')
        ->info('3.2 - Fake code')
        ->info('3.3 - Expired voucher')
        ->info('3.4 - Already used voucher')
        ->info('3.5 - Valid voucher')
      ->info('4 - Landing Plantation - Sedif')
      ->get('/landing/plantation/vedif/special')
      ->with('request')->begin()
        ->isParameter('partenaire', 'vedif')
        ->isParameter('operation', 'special')
      ->end()
      ->with('response')->begin()
        ->isStatusCode(200)
        ->checkElement('#but:contains("500 000")', true)
      ->end()
    ;

  }

}
