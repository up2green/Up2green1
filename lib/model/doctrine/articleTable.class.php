<?php

class articleTable extends Doctrine_Table
{

  /**
   * Construction de la requête permettant de récupérer les derniers articles
   *
   * @param <String> $culture Langue de l'article
   * @param <Integer> $number Nombre d'articles à retourner
   * @param <Integer> $offset Offset de l'article de départ
   * @return <Query> Requête
   */
  protected function buildQueryForRetrieveLastArticles($culture, $number = 2, $offset = 0)
  {
    return $this->createQuery('a')
        ->leftJoin('a.Translation t')
        ->where('t.lang = ?', $culture)
        ->andWhere('a.is_active = ?', 1)
        ->orderBy('a.created_at DESC')
        ->limit($number)
        ->offset($offset);
  }

  /**
   * Retourne les derniers articles sous forme d'une collection
   *
   * @param <String> $culture Langue de l'article
   * @param <Integer> $number Nombre d'articles à retourner
   * @param <Integer> $offset Offset de l'article de départ
   * @return <List<Article>> Liste des $number derniers articles
   */
  public function retrieveLastArticles($culture, $number = 2, $offset = 0)
  {
    return $this->buildQueryForRetrieveLastArticles($culture, $number, $offset)->execute();
  }

  /**
   * Retourne les derniers articles sous forme d'un array
   *
   * @param <String> $culture Langue de l'article
   * @param <Integer> $number Nombre d'articles à retourner
   * @param <Integer> $offset Offset de l'article de départ
   * @return <array> Tableau des $number derniers articles
   */
  public function retrieveLastArticlesInArray($culture, $number = 2, $offset = 0)
  {
    return $this->buildQueryForRetrieveLastArticles($culture, $number, $offset)->fetchArray();
  }

  public function getActiveByLangQuery($lang)
  {
    return $this->addLangQuery($lang, $this->addActiveQuery());
  }

  // -----------------------------------------
  // DRY
  // -----------------------------------------

  public function getArrayActiveBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->getArrayActive($this->addSlugQuery($slug, $q));
  }

  public function countActiveBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->countActive($this->addSlugQuery($slug, $q));
  }

  public function getOneActiveBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->getOneActive($this->addSlugQuery($slug, $q));
  }

  public function getActiveBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->getActive($this->addSlugQuery($slug, $q));
  }

  public function getArrayBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->getArray($this->addSlugQuery($slug, $q));
  }

  public function countBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->count($this->addSlugQuery($slug, $q));
  }

  public function getOneBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->getOne($this->addSlugQuery($slug, $q));
  }

  public function getBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->get($this->addSlugQuery($slug, $q));
  }

  // -----------------------------------------

  public function getArrayActiveByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->getArrayActive($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function countActiveByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->countActive($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function getOneActiveByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->getOneActive($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function getActiveByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->getActive($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function getArrayByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->getArray($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function countByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->count($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function getOneByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->getOne($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function getByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->get($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  // -----------------------------------------

  public function getArrayActive(Doctrine_Query $q = null)
  {
    return $this->getArray($this->addActiveQuery($q));
  }

  public function countActive(Doctrine_Query $q = null)
  {
    return $this->count($this->addActiveQuery($q));
  }

  public function getOneActive(Doctrine_Query $q = null)
  {
    return $this->getOne($this->addActiveQuery($q));
  }

  public function getActive(Doctrine_Query $q = null)
  {
    return $this->get($this->addActiveQuery($q));
  }

  // -----------------------------------------

  public function getArray(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->fetchArray();
  }

  public function count(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->count();
  }

  public function getOne(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->fetchOne();
  }

  public function get(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->execute();
  }

  // -----------------------------------------
  /* Return Query */
  // -----------------------------------------

  public function addSlugQuery($slug, Doctrine_Query $q = null)
  {
    return $this->addQuery($q)
        ->innerJoin('a.Translation t')
        ->where('t.slug = ?', $slug);
  }

  public function addLangQuery($lang, Doctrine_Query $q = null)
  {
    return $this->addQuery($q)
        ->innerJoin('a.Translation t')
        ->where('t.lang = ?', $lang);
  }

  public function addActiveQuery(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->addWhere('a.is_active = ?', 1);
  }

  public function addQuery(Doctrine_Query $q = null)
  {
    if (is_null($q)) {
      $q     = $this->createQuery('a');
    }
    $alias = $q->getRootAlias();
    $q->addOrderBy($alias . '.created_at DESC');
    return $q;
  }

  // -----------------------------------------
  /* default */
  // -----------------------------------------

  public static function getInstance()
  {
    return Doctrine_Core::getTable('article');
  }

}
