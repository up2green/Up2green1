<?php

/**
 * blog actions.
 *
 * @package    up2green
 * @subpackage blog
 * @author     Olivier Dolbeau
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class blogActions extends sfActions {
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {

    // S'il s'agit d'une requête AJAX, on redirige vers la bonne action (en fonction de l'élément à récupérer)
    if($request->isXmlHttpRequest()) {
      $this->forward('blog', 'AjaxRetrieve'.ucfirst($request->getParameter('changement')));
    }
    
  }

  public function executeAjaxRetrieveArticles(sfWebRequest $request) {
    $this->renderComponent('blog', 'articlesBloc');
    return sfView::NONE;
  }

  public function executeAjaxRetrieveProgrammes(sfWebRequest $request) {
    $this->renderComponent('blog', 'programmesBloc');
    return sfView::NONE;
  }

  public function executeAjaxRetrievePartenaires(sfWebRequest $request) {
    $this->renderComponent('blog', 'partenairesBloc');
    return sfView::NONE;
  }

 /**
  * Executes viewArticle action
  *
  * @param sfRequest $request A request object
  */
  public function executeViewElement(sfWebRequest $request) {
    $this->type = $request->getParameter('type');
    $this->element = Doctrine::getTable(ucfirst($this->type))->retrieveBySlug($request->getParameter("slug"));
  }

 /**
  * Executes viewProgramme action
  *
  * @param sfRequest $request A request object
  */
  public function executeViewProgramme(sfWebRequest $request) {
    $this->programme = Doctrine::getTable('Programme')->retrieveBySlug($request->getParameter("slug"));
  }
}
