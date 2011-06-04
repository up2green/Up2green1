<?php

/**
 * blog components.
 *
 * @package    up2green
 * @subpackage blog
 * @author     Oliver Dolbeau
 */
class blogComponents extends sfComponents {
  
	public function executeTopbar(sfWebRequest $request) {
		$this->totalTrees = Doctrine_Core::getTable('tree')->count();
		$this->totalTrees += sfConfig::get('app_hardcode_tree_number');
	}

  public function executeArticlesBloc(sfWebRequest $request) {
    // Récupération des articles
    $currentOffset = $request->getParameter('articlesOffset', 0);
    $this->offsets = $this->retrieveArticlesOffsets($currentOffset);
    // On n'affiche pas le bloc s'il s'agit d'une requête AJAX
    $this->noBloc = $request->isXmlHttpRequest();
    $this->articles = Doctrine::getTable('Article')->getActiveByLang($this->getUser()->getCulture(), sfConfig::get('app_blog_bloc_articles_max'), $currentOffset);
  }

  public function executeProgrammesBloc(sfWebRequest $request) {
    // Récupération des programmes
    $currentOffset = $request->getParameter('programmesOffset', 0);
    
    //fix temporaire et permet de pas avoir 2 foios le même programme en homepage
    if(!$request->isXmlHttpRequest() && empty($currentOffset))
    	$currentOffset = 1;
    
    if(!in_array($currentOffset, array('min', 'max')))
    {
			$this->offsets = $this->retrieveprogrammesOffsets($currentOffset);
			$this->offsets['next'] = $currentOffset == $this->offsets['next'] ? 'max' : $this->offsets['next']; 
			$this->offsets['prev'] = $currentOffset == $this->offsets['prev'] ? 'min' : $this->offsets['prev']; 
			// On n'affiche pas le bloc s'il s'agit d'une requête AJAX
			if($request->isXmlHttpRequest())
				$this->noBloc = true;
			
			$this->programmes = Doctrine::getTable('programme')->getActiveByLang($this->getUser()->getCulture(), sfConfig::get('app_blog_bloc_programmes_max'), $currentOffset);
		}
		
		if($request->isXmlHttpRequest())
			die();
  }

  public function executePartenairesBloc(sfWebRequest $request) {
  	
    // Chargement du flux RSS
    $dom = new DOMDocument();
    $dom->load(sfConfig::get('app_blog_partenaires_url'));
    
    $items = $dom->getElementsByTagName('item');
    // Récupération des programmes
    $currentOffset = $request->getParameter('partenairesOffset', 0);
    $this->offsets = $this->retrievePartenairesOffsets($currentOffset, $items->length);

    // On n'affiche pas le bloc s'il s'agit d'une requête AJAX
    if($request->isXmlHttpRequest())
      $this->noBloc = true;

    $this->partenaires = array();
    
    for($i=$currentOffset; $i < $currentOffset+sfConfig::get('app_blog_bloc_partenaires_max'); $i++) {
		if($i >= 0 && $i < $items->length) {
			$this->partenaires[] = $dom->getElementsByTagName('item')->item($i);
		}
    }
  }

  public function executeDiaporama(sfWebRequest $request) {
    $this->programmes = Doctrine::getTable('programme')->getActiveByLang($this->getUser()->getCulture(), 5);
  }

  public function executeMenu(sfWebRequest $request) {
    // Récupération du menu-top dynamique
    $this->elements = array();
    $main_category = Doctrine::getTable('Category')->getByName('main-menu');
    
    foreach($main_category->getActiveLinks() as $link)
    	$this->elements[] = array(
    		'classname'	=> 'link',
    		'object'		=> $link
    	);
	
    foreach($main_category->getActiveSubs() as $category)
    	$this->elements[] = array(
    		'classname'	=> 'category',
    		'object'		=> $category
    	);
    
    $this->programms = Doctrine::getTable('programme')->getActiveByLang($this->getUser()->getCulture());
  }

  public function executeFooter(sfWebRequest $request) {
    // Récupération du menu-top dynamique
    $this->category = Doctrine::getTable('Category')->getByName('footer');
  }

  public function executeFooterLegal(sfWebRequest $request) {
    // Récupération du menu-top dynamique
    $this->category = Doctrine::getTable('Category')->getByName('footer-legal ');
  }

  protected function retrieveArticlesOffsets($offset) {
    return $this->retrieveOffsets($offset, sfConfig::get('app_blog_bloc_articles_max'), Doctrine::getTable('Article')->countActive());
  }

  protected function retrieveprogrammesOffsets($offset) {
    return $this->retrieveOffsets($offset, sfConfig::get('app_blog_bloc_programmes_max'), Doctrine::getTable('programme')->countActive());
  }

  protected function retrievePartenairesOffsets($offset, $max) {
    return $this->retrieveOffsets($offset, sfConfig::get('app_blog_bloc_partenaires_max'), $max);
  }

  protected function retrieveOffsets($offset, $nbElements, $maxOffset) {
    // Calcul de l'offset à utiliser lors du clic sur le bouton précédent / suivant
    return array(
				'prev' => ($offset - $nbElements <= 0)? 0: $offset - $nbElements,
				'next' => ($offset + $nbElements >= $maxOffset)? $offset: $offset + $nbElements
		);
  }
}
