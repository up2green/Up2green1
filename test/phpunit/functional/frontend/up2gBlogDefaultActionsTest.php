<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

/**
 * Test Plugins / up2gBlogPlugin / Modules / Default / actions.class.php file
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
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'index', '/up2gBlogDefault/index');
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
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/up2gBlogDefault/list?type=organisme');
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/up2gBlogDefault/list?type=article');
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/up2gBlogDefault/list?type=partenaire&method=addQuery');
  }

  /**
   * Test the show action without parameters
   */
  public function testShowWithoutParameter()
  {
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'show', '/up2gBlogDefault/show', 404);
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'show', '/up2gBlogDefault/show?type=article', 404);
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'show', '/up2gBlogDefault/show?slug=annee-internationale-de-la-foret', 404);
  }

  /**
   * Test the show action with an invalid parameter
   */
  public function testShowInvalidParameter()
  {
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'show', '/up2gBlogDefault/show?type=article&slug=NotFound', 404);
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'show', '/up2gBlogDefault/show?type=NotFound&slug=annee-internationale-de-la-foret', 404);
  }

  /**
   * Test the show action
   */
  public function testShow()
  {
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'show', '/up2gBlogDefault/show?type=article&slug=annee-internationale-de-la-foret');
  }

  /**
   * Test the list action special routing
   */
  public function testListRouting()
  {
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/blog/programme');
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/blog/organisme');
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/blog/article');
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'list', '/blog/partenaire');
  }

  /**
   * Test the show action special routing
   */
  public function tesShowRouting()
  {
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'show', '/blog/article/annee-internationale-de-la-foret');
  }

  /**
   * Test the index action special routing
   */
  public function testIndexRouting()
  {
    $this->getBrowser()->getAndCheck('up2gBlogDefault', 'index', '/blog');
  }

}
