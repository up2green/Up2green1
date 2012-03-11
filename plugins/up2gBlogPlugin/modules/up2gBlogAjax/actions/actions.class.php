<?php

/**
 * blog actions.
 *
 * @package    up2gBlogPlugin
 * @subpackage Ajax
 * @author     Clément Gautier
 */
class up2gBlogAjaxActions extends sfActions
{

  /**
   * If a request is not XmlHttpRequest, then return a 404
   *
   * @param sfWebRequest $request 
   */
  public function execute($request)
  {
    //$this->forward404Unless($request->isXmlHttpRequest());
    return parent::execute($request);
  }

  /**
   * Render the articles
   */
  public function executeArticles()
  {
    return $this->renderComponent('up2gBlogDefault', 'articlesBloc');
  }

  /**
    * Render the programs
    */
  public function executeProgrammes()
  {
    return $this->renderComponent('up2gBlogDefault', 'programmesBloc');
  }

  /**
    * Render the partners
    */
  public function executePartenaires()
  {
    return $this->renderComponent('up2gBlogDefault', 'partenairesBloc');
  }

}
