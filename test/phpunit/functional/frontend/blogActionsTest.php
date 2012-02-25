<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

/**
 * Test Frontend / Blog / Actions
 */
class functional_frontend_blogActionsTest extends FrontendFunctionalTestCase
{
  /**
   * Test the indexAction
   */
  public function testIndex()
  {
    $this->getBrowser()->
      getAndCheck('blog', 'index', '/blog/index', 200)
    ;
  }

}
