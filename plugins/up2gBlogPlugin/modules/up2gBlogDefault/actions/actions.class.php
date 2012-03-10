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

    // TODO : dont do this, call the right action instead
    // TODO : Move this to an ajax module
    if ($request->isXmlHttpRequest())
    {
      $action = 'AjaxRetrieve' . ucfirst($request->getParameter('changement', 'default'));
      $this->forward404Unless(method_exists($this, 'execute'.$action));
      $this->forward('up2gBlogDefault', $action);
    }
  }

  /**
   * Render the articles
   */
  public function executeAjaxRetrieveArticles()
  {
    $this->renderComponent('up2gBlogDefault', 'articlesBloc');
    return sfView::NONE;
  }

  /**
    * Render the programs
    */
  public function executeAjaxRetrieveProgrammes()
  {
    $this->renderComponent('up2gBlogDefault', 'programmesBloc');
    return sfView::NONE;
  }

  /**
    * Render the partners
    */
  public function executeAjaxRetrievePartenaires()
  {
    $this->renderComponent('up2gBlogDefault', 'partenairesBloc');
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
