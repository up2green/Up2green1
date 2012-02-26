<?php
require_once dirname(__FILE__).'/../../bootstrap/functional.php';

/**
 * Test Backend / Programme / actions.class.php file
 *
 * @category Test
 * @package  Functional
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class functional_backend_programmeActionsTest extends BackendFunctionalTestCase
{
  /**
   * Test the executeIndex
   */
  public function testIndex()
  {
    $this->getAndCheckWithLogin('programme', 'index', '/programme/index');
  }

  /**
   * Test the executeShowTrees
   */
  public function testShowTrees()
  {
    $this->getAndCheckWithLogin('programme', 'showTrees', '/programme/8/showTrees.html');
  }
}