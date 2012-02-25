<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

/**
 * Test Frontend / Partenaire / Actions
 */
class functional_frontend_partenaireActionsTest extends FrontendFunctionalTestCase
{
  public function testDefault()
  {
    $this->getBrowser()->
      getAndCheck('partenaire', 'index', '/partenaire/index', 404)
    ;
  }

}

