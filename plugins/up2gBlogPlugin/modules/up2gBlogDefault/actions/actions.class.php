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
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    // S'il s'agit d'une requête AJAX, on redirige vers la bonne action 
    // (en fonction de l'élément à récupérer)
    if ($request->isXmlHttpRequest()) {
      $this->forward('default', 'AjaxRetrieve' . ucfirst($request->getParameter('changement')));
    }
  }

  public function executeAjaxRetrieveArticles()
  {
    $this->renderComponent('default', 'articlesBloc');
    return sfView::NONE;
  }

  public function executeAjaxRetrieveProgrammes()
  {
    $this->renderComponent('default', 'programmesBloc');
    return sfView::NONE;
  }

  public function executeAjaxRetrievePartenaires()
  {
    $this->renderComponent('default', 'partenairesBloc');
    return sfView::NONE;
  }

  /**
   * Executes viewArticle action
   *
   * @param sfRequest $request A request object
   */
  public function executeViewElement(sfWebRequest $request)
  {
    $this->type = $request->getParameter('type');
    $this->element = Doctrine::getTable($this->type)->getOneBySlug($request->getParameter("slug"));
  }

  /**
   * Executes the list action
   *
   * @param sfRequest $request A request object
   */
  public function executeList(sfWebRequest $request)
  {
    $this->type = $request->getParameter('type');

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
