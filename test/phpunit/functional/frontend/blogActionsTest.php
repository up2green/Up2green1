<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

/**
 * Test Frontend / Blog / actions.class.php file
 *
 * @category Test
 * @package  Functional
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
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
