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
   * Test the index action
   */
  public function testIndex()
  {
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'index', '/blog');
  }

  /**
   * Test the index action in ajax w/o parameter
   */
  public function testIndexAjaxWithoutParameter()
  {
    $this->getBrowser()->setHttpHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'index', '/blog', 404);
  }

  /**
   * Test the index action in ajax with an invalid parameter
   */
  public function testIndexAjaxInvalidParameter()
  {
    $this->getBrowser()->setHttpHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'index', '/blog?changement=notFound', 404);
  }

  /**
   * Test the index action in ajax for retrive articles
   */
  public function testIndexAjaxRetrieveArticles()
  {
    $this->getBrowser()->setHttpHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
    $this->getBrowser()
      ->getAndCheck('up2gBlogDefault', 'index', '/blog?changement=articles')
      ->with('response')->begin()
        ->checkElement('div.article', 3)
      ->end()
     ;
  }

  /**
   * Test the index action in ajax for retrive programmes
   */
  public function testIndexAjaxRetrieveProgrammes()
  {
    $this->getBrowser()->setHttpHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
    $this->getBrowser()
      ->getAndCheck('up2gBlogDefault', 'index', '/blog?changement=programmes')
      ->with('response')->begin()
        ->checkElement('div.article', 1)
      ->end()
     ;
  }

  /**
   * Test the index action in ajax for retrive partners
   */
  public function testIndexAjaxRetrievePartenaires()
  {
    $this->getBrowser()->setHttpHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
    $this->getBrowser()
      ->getAndCheck('up2gBlogDefault', 'index', '/blog?changement=partenaires')
      ->with('response')->begin()
        ->checkElement('div.article', 3)
      ->end()
     ;
  }

  /**
   * Test the list action without parameters
   */
  public function testListWithoutParameter()
  {
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/up2gBlogDefault/list', 404);
  }

  /**
   * Test the list action with an invalid parameter
   */
  public function testListInvalidParameter()
  {
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/up2gBlogDefault/list?type=NotFound', 404);
  }

  /**
   * Test the list action
   */
  public function testList()
  {
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/up2gBlogDefault/list?type=programme');
  }

  /**
   * Test the list action special routing
   */
  public function testListRouting()
  {
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/blog/programme');
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/blog/organisme');
    // FIXME What the hell is the problem with Translation ? Capitalize the tablename ??!
    //$this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/blog/article');
  }


}
