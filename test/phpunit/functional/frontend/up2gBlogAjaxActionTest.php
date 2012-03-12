<?php

require_once dirname(__FILE__) . '/../../bootstrap/functional.php';

/**
 * Test Plugins / up2gBlogPlugin / Modules / Ajax / actions.class.php file
 *
 * @category Test
 * @package  Functional
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class functional_frontend_up2gBlogAjaxActionsTest extends FrontendFunctionalTestCase
{
  /**
   * Test the index action in ajax w/o parameter
   */
  public function testNotAjax()
  {
    $this->getBrowser()->getAndCheck('up2gAjaxDefault', 'articles', '/blog/up2gAjaxDefault/articles', 404);
    $this->getBrowser()->getAndCheck('up2gAjaxDefault', 'programmes', '/blog/up2gAjaxDefault/programmes', 404);
    $this->getBrowser()->getAndCheck('up2gAjaxDefault', 'partenaires', '/blog/up2gAjaxDefault/partenaires', 404);
  }

  /**
   * Test the articles action
   */
  public function testArticles()
  {
    $this->getBrowser()->setHttpHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
    $this->getBrowser()
      ->getAndCheck('up2gBlogAjax', 'articles', '/blog/ajax/articles/0')
      ->with('response')->begin()
        ->checkElement('div.article', 3)
      ->end()
     ;
  }

  /**
   * Test the programmes action
   */
  public function testProgrammes()
  {
    $this->getBrowser()->setHttpHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
    $this->getBrowser()
      ->getAndCheck('up2gBlogAjax', 'programmes', '/blog/ajax/programmes/0')
      ->with('response')->begin()
        ->checkElement('div.article', 1)
      ->end()
     ;
  }

  /**
   * Test the partenaires action
   */
  public function testPartenaires()
  {
    $this->getBrowser()->setHttpHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
    $this->getBrowser()
      ->getAndCheck('up2gBlogAjax', 'partenaires', '/blog/ajax/partenaires/0')
      ->with('response')->begin()
        ->checkElement('div.article', 3)
      ->end()
     ;
  }
}
