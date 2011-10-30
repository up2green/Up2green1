<?php

/**
 * recherche actions.
 *
 * @package    up2green
 * @subpackage recherche
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rechercheActions extends sfActions
{

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $params = $request->getParameterHolder();

    $this->results = array();
    $this->textSearch = "";
    $this->singleShopResult = array();

    if (($strRecherche = $params->get('recherche_text')) || ($strRecherche = $params->get('q')))
    {
      $this->moteur = $params->get('hidden_moteur_search', SearchEngine::WEB);
      $this->textSearch = $strRecherche;
      $engine = new SearchEngine($this->textSearch, $this->moteur);
      $this->results = $engine->getResults();
      if (sfConfig::get('app_show_shop_results', true))
      {
        $this->singleShopResult = $engine->getOneShopResult();
      }
      $this->pubResults = $engine->getPubResults(4);
    } else
    {
      $this->moteur = SearchEngine::WEB;
      $this->totalTrees = Doctrine_Core::getTable('tree')->count();
    }
  }

  public function executeViewElement(sfWebRequest $request)
  {
    $this->type = $request->getParameter('type');
    $this->element = Doctrine::getTable(strtolower($this->type))->getOneActiveBySlug($request->getParameter("slug"));
    if (empty($this->element))
    {
      return $this->forward404();
    }
  }

}
