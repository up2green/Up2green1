<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

/**
 * Test Frontend / Recherche / actions.class.php file
 *
 * @category Test
 * @package  Functional
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class functional_frontend_rechercheActionsTest extends FrontendFunctionalTestCase
{
  /**
   * Test the executeIndex action
   */
  public function testIndex()
  {
    $this->getBrowser()->
      getAndCheck('recherche', 'index', '/', 200)
    ;
  }

  /**
   * Test the executeIndex action
   */
  public function testIndexWithQueryForward()
  {
    $this->getBrowser()
      ->get('/', array('q' => 'test'))
      ->isForwardedTo('recherche', 'search')
    ;
  }

  /**
   * Test the executeSearch action
   */
  public function testSearch()
  {
    $this->getBrowser()
      ->get('/search', array('q' => 'test'))
      ->with('request')->begin()
        ->isParameter('action', 'search')
        ->isParameter('module', 'recherche')
      ->end()
      ->with('response')->begin()
        ->isStatusCode(200)
      ->end()
    ;
  }

  /**
   * Test the executeSearch action without query parameter
   */
  public function testSearchWithoutQueryForward()
  {
    $this->getBrowser()
      ->getAndCheck('recherche', 'search', '/search')
      ->isForwardedTo('recherche', 'index')
    ;
  }

}
