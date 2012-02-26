<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

/**
 * Test Frontend / Default / actions.class.php file
 *
 * @category Test
 * @package  Functional
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class functional_frontend_defaultActionsTest extends FrontendFunctionalTestCase
{

  /**
   * Test the executeError404 method
   */
  public function testError404()
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
