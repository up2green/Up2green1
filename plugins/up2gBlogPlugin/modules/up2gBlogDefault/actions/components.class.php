<?php

/**
 * blog components.
 *
 * @package    up2green
 * @subpackage blog
 * @author     Oliver Dolbeau
 */
class up2gBlogDefaultComponents extends sfComponents
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
    // TODO rename programmesOffset to offset
    $offset = $request->getParameter('programmesOffset', 0);

    if (!is_numeric($offset))
    {
      throw new InvalidArgumentException("Offset parameter '%s' is invalid");
    }

    $this->offsets = $this->retrieveprogrammesOffsets($offset);
    // On n'affiche pas le bloc s'il s'agit d'une requête AJAX
    $this->noBloc = $request->isXmlHttpRequest();

    $culture = $this->getUser()->getCulture();
    $max     = sfConfig::get('app_blog_bloc_programmes_max');

    $this->programmes = Doctrine::getTable('programme')
        ->getActiveByLang($culture, $max, $offset);
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
