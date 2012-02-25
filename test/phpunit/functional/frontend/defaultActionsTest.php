<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

/**
 * Test Frontend / Default / Actions
 */
class functional_frontend_defaultActionsTest extends FrontendFunctionalTestCase
{
  public function testDefault()
  {
    $this->getBrowser()
      ->getAndCheck('default', 'error404', '/default/error404', 404)
      ->get('/truc/Introuvable')
      ->with('response')
      ->begin()
      ->isStatusCode(404)
      ->end()
    ;
  }
}
