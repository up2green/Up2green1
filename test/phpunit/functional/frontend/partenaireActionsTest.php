<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

/**
 * Test Frontend / Partenaire / actions.class.php file
 *
 * @category Test
 * @package  Functional
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class functional_frontend_partenaireActionsTest extends FrontendFunctionalTestCase
{

  /**
   * Test the executeIndex method
   */
  public function testIndex()
  {
    $this->getBrowser()->
      getAndCheck('partenaire', 'index', '/partenaire/index', 404)
    ;
  }

}
