<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

class functional_frontend_defaultActionsTest extends FunctionalTestCase
{

  public function getApplication()
  {
    return 'frontend';
  }

  public function testDefault()
  {
    $browser = $this->getBrowser();

    $browser
      ->getAndCheck('default', 'error404', '/default/error404', 404)
      ->get('/truc/Introuvable')
      ->with('response')
      ->begin()
      ->isStatusCode(404)
      ->end()
    ;
  }

}
