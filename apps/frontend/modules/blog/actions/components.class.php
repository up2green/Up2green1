<?php

/**
 * blog components.
 *
 * @package    up2green
 * @subpackage blog
 * @author     Oliver Dolbeau
 */
class blogComponents extends sfComponents
{

  public function executeTopbar()
  {
    $this->totalTrees = Doctrine_Core::getTable('tree')->count();
    $this->totalTrees += sfConfig::get('app_hardcode_tree_number');
  }

  public function executeArticlesBloc(sfWebRequest $request)
  {
    // Récupération des articles
    $currentOffset = $request->getParameter('articlesOffset', 0);
    $this->offsets = $this->retrieveArticlesOffsets($currentOffset);
    // On n'affiche pas le bloc s'il s'agit d'une requête AJAX
    $this->noBloc = $request->isXmlHttpRequest();
    $this->articles = Doctrine::getTable('Article')->getActiveByLang($this->getUser()->getCulture(), sfConfig::get('app_blog_bloc_articles_max'), $currentOffset);
  }

  public function executeProgrammesBloc(sfWebRequest $request)
  {
    $currentOffset = $request->getParameter('programmesOffset', 0);

    // FIXME : Fix temporaire et permet de pas avoir 2 foios le même programme en homepage
    if (!$request->isXmlHttpRequest() && empty($currentOffset))
    {
      $currentOffset = 1;
    }

    if (!in_array($currentOffset, array('min', 'max')))
    {
      $this->offsets = $this->retrieveprogrammesOffsets($currentOffset);
      $this->offsets['next'] = $currentOffset == $this->offsets['next'] ? 'max' : $this->offsets['next'];
      $this->offsets['prev'] = $currentOffset == $this->offsets['prev'] ? 'min' : $this->offsets['prev'];
      if ($request->isXmlHttpRequest())
      {
        // On n'affiche pas le bloc s'il s'agit d'une requête AJAX
        $this->noBloc = true;
      }

      $culture = $this->getUser()->getCulture();
      $max     = sfConfig::get('app_blog_bloc_programmes_max');

      $this->programmes = Doctrine::getTable('programme')
        ->getActiveByLang($culture, $max, $currentOffset);
    }

    if ($request->isXmlHttpRequest())
      die();
  }

  public function executePartenairesBloc(sfWebRequest $request)
  {

    // Chargement du flux RSS
    $dom = new DOMDocument();
    $dom->load(sfConfig::get('app_blog_partenaires_url'));

    $items         = $dom->getElementsByTagName('item');
    // Récupération des programmes
    $currentOffset = $request->getParameter('partenairesOffset', 0);
    $this->offsets = $this->retrievePartenairesOffsets($currentOffset, $items->length);

    // On n'affiche pas le bloc s'il s'agit d'une requête AJAX
    if ($request->isXmlHttpRequest())
    {
      $this->noBloc = true;
    }

    $this->partenaires = array();

    $maxOffset = $currentOffset + sfConfig::get('app_blog_bloc_partenaires_max');
    for ($i         = $currentOffset; $i < $maxOffset; $i++) {
      if ($i >= 0 && $i < $items->length) {
        $this->partenaires[] = $dom->getElementsByTagName('item')->item($i);
      }
    }
  }

  public function executeDiaporama()
  {
    $this->programmes = Doctrine::getTable('programme')
      ->getActiveByLang($this->getUser()->getCulture(), 5);
  }

  public function executeMenu()
  {
    // Récupération du menu-top dynamique
    $this->elements = array();
    $main_category = Doctrine::getTable('Category')->getByName('main-menu');

    foreach ($main_category->getActiveLinks() as $link)
      $this->elements[] = array(
        'classname' => 'link',
        'object'    => $link
      );

    foreach ($main_category->getActiveSubs() as $category)
      $this->elements[] = array(
        'classname' => 'category',
        'object'    => $category
      );

    $this->programms = Doctrine::getTable('programme')
      ->getActiveByLang($this->getUser()->getCulture());
  }

  /**
   * Récupération du menu-top dynamique 
   */
  public function executeFooter()
  {
    $this->category = Doctrine::getTable('Category')
      ->getByName('footer');
  }

  /**
   * Récupération du menu-top dynamique 
   */
  public function executeFooterLegal()
  {
    $this->category = Doctrine::getTable('Category')
      ->getByName('footer-legal ');
  }

  protected function retrieveArticlesOffsets($offset)
  {
    return $this->retrieveOffsets($offset, sfConfig::get('app_blog_bloc_articles_max'), Doctrine::getTable('Article')->countActive());
  }

  protected function retrieveprogrammesOffsets($offset)
  {
    return $this->retrieveOffsets($offset, sfConfig::get('app_blog_bloc_programmes_max'), Doctrine::getTable('programme')->countActive());
  }

  protected function retrievePartenairesOffsets($offset, $max)
  {
    return $this->retrieveOffsets($offset, sfConfig::get('app_blog_bloc_partenaires_max'), $max);
  }

  /**
   * Calcul de l'offset à utiliser lors du clic sur le bouton précédent / suivant
   *
   * @param int $offset
   * @param int $nbElements
   * @param int $maxOffset
   * @return array 
   */
  protected function retrieveOffsets($offset, $nbElements, $maxOffset)
  {
    return array(
      'prev' => ($offset - $nbElements <= 0) ? 0 : $offset - $nbElements,
      'next' => ($offset + $nbElements >= $maxOffset) ? $offset : $offset + $nbElements
    );
  }

}
