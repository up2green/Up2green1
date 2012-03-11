<?php

/**
 * blog actions.
 *
 * @package    up2gBlogPlugin
 * @subpackage Default
 * @author     Clément Gautier
 */
class up2gBlogDefaultActions extends sfActions
{
  /**
   * Executes index action
   */
  public function executeIndex()
  {
  }

  /**
   * Executes viewArticle action
   *
   * @param sfRequest $request A request object
   */
  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('type'));
    $this->forward404Unless($request->hasParameter('slug'));
    $this->type = $request->getParameter('type');
    $this->forward404Unless(class_exists($this->type.'Table'));

    $this->element = Doctrine::getTable($this->type)
      ->getOneBySlug($request->getParameter('slug'));

    $this->forward404Unless($this->element);
  }

  /**
   * Executes the list action
   *
   * @param sfRequest $request A request object
   */
  public function executeList(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('type'));
    $this->type = $request->getParameter('type');
    $this->forward404Unless(class_exists($this->type.'Table'));

    $query = Doctrine::getTable($this->type)
      ->getActiveByLangQuery($this->getUser()->getCulture());

    $this->pager = new sfDoctrinePager($this->type, 5);
    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();

    $this->elements = $this->pager->getResults();
    
    $this->route = sprintf('blog_%s_list', $this->type);
  }

}
