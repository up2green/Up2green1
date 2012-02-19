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

  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new SearchForm();
    $this->totalTrees = Doctrine_Core::getTable('tree')->count();
  }
  
  public function executeSearch(sfWebRequest $request)
  {
    $this->form = new SearchForm();
    $this->form->bind(array(
      'q' => $request->getParameter('q'),
      'type' => $request->getParameter('type'),
    ));

    $this->forwardUnless($this->form->isValid(), 'recherche', 'index');

    $this->textSearch = $this->form->getValue('q');
    $this->type = $this->form['type']->getValue();
    $this->typeSlug = SearchEngine::getSlug($this->type);

    $engine = new SearchEngine($this->textSearch, $this->type);
    
    $this->results = $engine->getResults();
    $this->singleShopResult = sfConfig::get('app_show_shop_results', true) ? $engine->getOneShopResult() : array();
    $this->pubResults = $engine->getPubResults();
  }

  public function executeViewElement(sfWebRequest $request)
  {
    $this->type = $request->getParameter('type');
    $this->element = Doctrine::getTable(strtolower($this->type))
      ->getOneActiveBySlug($request->getParameter("slug"));

    if (empty($this->element))
    {
      return $this->forward404();
    }
  }

}
