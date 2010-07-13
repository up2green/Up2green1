<?php

/**
 * blog components.
 *
 * @package    up2green
 * @subpackage blog
 * @author     Oliver Dolbeau
 */
class blogComponents extends sfComponents {
  
  public function executeArticlesBloc(sfWebRequest $request) {
    // Récupération des articles
    $currentOffset = $request->getParameter('articlesOffset', 0);
    $this->offsets = $this->retrieveArticlesOffsets($currentOffset);

    // On n'affiche pas le bloc s'il s'agit d'une requête AJAX
    if($request->isXmlHttpRequest())
      $this->noBloc = true;

    $this->articles = Doctrine::getTable('Article')->retrieveLastArticles($this->getUser()->getCulture(), sfConfig::get('app_blog_bloc_articles_max'), $currentOffset);
  }

  public function executeProgrammesBloc(sfWebRequest $request) {
    // Récupération des programmes
    $currentOffset = $request->getParameter('programmesOffset', 0);
    $this->offsets = $this->retrieveProgrammesOffsets($currentOffset);

    // On n'affiche pas le bloc s'il s'agit d'une requête AJAX
    if($request->isXmlHttpRequest())
      $this->noBloc = true;
    
    $this->programmes = Doctrine::getTable('Programme')->retrieveLastProgrammes($this->getUser()->getCulture(), sfConfig::get('app_blog_bloc_programmes_max'), $currentOffset);
  }

  public function executePartenairesBloc(sfWebRequest $request) {
    // Chargement du flux RSS
    $xml = simplexml_load_file(sfConfig::get('app_blog_partenaires_url'));
    // Récupération des programmes
    $currentOffset = $request->getParameter('partenairesOffset', 0);
    $this->offsets = $this->retrievePartenairesOffsets($currentOffset, count($xml->channel->item));

    // On n'affiche pas le bloc s'il s'agit d'une requête AJAX
    if($request->isXmlHttpRequest())
      $this->noBloc = true;

//    echo '<pre>';
//    print_r($xml->channel->item[0]);
//    echo '</pre>';

//    echo '<pre>';
//    foreach($xml->channel->item as $i) {
//      echo $i->title.'<br />';
////      print_r($i);
//    }
//    echo '</pre>';

    $this->partenaires = array();
//    echo 'CURRENT OFFSET: '.$currentOffset.' / MAX OFFSET: '.($currentOffset+sfConfig::get('app_blog_bloc_partenaires_max')).'<br />';
    for($i=$currentOffset; $i < $currentOffset+sfConfig::get('app_blog_bloc_partenaires_max'); $i++) {
      if(isset($xml->channel->item[intval($i)])) {
        $this->partenaires[] = $xml->channel->item[intval($i)];
//        echo $xml->channel->item[$i+1]->title;
      }
    }

//    $this->programmes = Doctrine::getTable('Programme')->retrieveLastProgrammes($this->getUser()->getCulture(), sfConfig::get('app_blog_bloc_programmes_max'));
  }

  public function executeDiaporama(sfWebRequest $request) {
    // Récupération des 3 derniers programmes
    $this->programmes = Doctrine::getTable('Programme')->retrieveLastProgrammes($this->getUser()->getCulture(), 3, 0);
  }



  protected function retrieveArticlesOffsets($offset) {
    return $this->retrieveOffsets($offset, sfConfig::get('app_blog_bloc_articles_max'), Doctrine::getTable('Article')->count());
  }

  protected function retrieveProgrammesOffsets($offset) {
    return $this->retrieveOffsets($offset, sfConfig::get('app_blog_bloc_programmes_max'), Doctrine::getTable('Programme')->count());
  }

  protected function retrievePartenairesOffsets($offset, $max) {
    return $this->retrieveOffsets($offset, sfConfig::get('app_blog_bloc_partenaires_max'), $max);
  }

  protected function retrieveOffsets($offset, $nbElements, $maxOffset) {
    // Calcul de l'offset à utiliser lors du clic sur le bouton précédent
    $return['prev'] = ($offset - $nbElements <= 0)? 0: $offset - $nbElements;
    // Calcul de l'offset à utiliser lors du clic sur le bouton suivant
//    $return['next'] = ($offset + $nbElements >= $maxOffset)? ($offset - $nbElements <= 0)? 0: $offset - $nbElements: $offset + $nbElements;
    $return['next'] = ($offset + $nbElements >= $maxOffset)? $offset: $offset + $nbElements;

    return $return;
  }
}
