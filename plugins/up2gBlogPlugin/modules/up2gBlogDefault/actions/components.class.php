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

  /**
   * Render the topbar 
   */
  public function executeTopbar()
  {
    $this->totalTrees = Doctrine_Core::getTable('tree')->count();
    $this->totalTrees += sfConfig::get('app_hardcode_tree_number');
  }

  /**
   * Render the articles blocs, w/o bloc if it is Ajax
   *
   * @param sfWebRequest $request 
   */
  public function executeArticlesBloc(sfWebRequest $request)
  {
    $offset = $request->getParameter('offset', 0);

    if (!is_numeric($offset))
    {
      throw new InvalidArgumentException("Offset parameter '%s' is invalid");
    }

    $this->offsets = $this->retrieveOffsets(
      $offset,
      sfConfig::get('app_blog_bloc_articles_max'), 
      Doctrine::getTable('Article')->countActive()
    );

    $this->noBloc = $request->isXmlHttpRequest();
    $this->articles = Doctrine::getTable('Article')->getActiveByLang(
      $this->getUser()->getCulture(), 
      sfConfig::get('app_blog_bloc_articles_max'), 
      $offset
    );
  }

  /**
   * Render the programs blocs, w/o bloc if it is Ajax
   *
   * @param sfWebRequest $request 
   */
  public function executeProgrammesBloc(sfWebRequest $request)
  {
    $offset = $request->getParameter('offset', 0);

    if (!is_numeric($offset))
    {
      throw new InvalidArgumentException("Offset parameter '%s' is invalid");
    }

    $this->offsets = $this->retrieveOffsets(
      $offset,
      sfConfig::get('app_blog_bloc_programmes_max'), 
      Doctrine::getTable('programme')->countActive()
    );

    $this->noBloc = $request->isXmlHttpRequest();
    $this->programmes = Doctrine::getTable('programme')->getActiveByLang(
      $this->getUser()->getCulture(), 
      sfConfig::get('app_blog_bloc_programmes_max'), 
      $offset
    );
  }

  /**
   * Render the partners blocs, w/o bloc if it is Ajax
   *
   * @param sfWebRequest $request 
   */
  public function executePartenairesBloc(sfWebRequest $request)
  {
    $offset = $request->getParameter('offset', 0);

    if (!is_numeric($offset))
    {
      throw new InvalidArgumentException("Offset parameter '%s' is invalid");
    }

    // Chargement du flux RSS
    $dom = new DOMDocument();
    $dom->load(sfConfig::get('app_blog_partenaires_url'));

    $items = $dom->getElementsByTagName('item');

    $this->offsets = $this->retrieveOffsets(
      $offset,
      sfConfig::get('app_blog_bloc_partenaires_max'), 
      $items->length
    );

    $this->noBloc = $request->isXmlHttpRequest();
    $this->partenaires = array();

    // TODO : review this
    $maxOffset = $offset + sfConfig::get('app_blog_bloc_partenaires_max');
    for ($i         = $offset; $i < $maxOffset; $i++) {
      if ($i >= 0 && $i < $items->length) {
        $this->partenaires[] = $dom->getElementsByTagName('item')->item($i);
      }
    }
  }

  /**
   * Render the slideshow 
   */
  public function executeDiaporama()
  {
    $this->programmes = Doctrine::getTable('programme')
      ->getActiveByLang($this->getUser()->getCulture(), 5);
  }

  /**
   * Render the menu 
   */
  public function executeMenu()
  {
    // Récupération du menu-top dynamique
    $this->elements = array();
    $main_category = Doctrine::getTable('Category')
      ->getByName('main-menu');

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
