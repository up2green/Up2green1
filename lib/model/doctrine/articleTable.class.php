<?php


class articleTable extends Doctrine_Table {

  /**
   * Construction de la requête permettant de récupérer les derniers articles
   *
   * @param <String> $culture Langue de l'article
   * @param <Integer> $number Nombre d'articles à retourner
   * @param <Integer> $offset Offset de l'article de départ
   * @return <Query> Requête
   */
  protected function buildQueryForRetrieveLastArticles($culture, $number = 2, $offset = 0) {
    $q = $this->createQuery('a')
              ->leftJoin('a.Translation t')
              ->where('t.lang = ?', $culture)
              ->orderBy('a.created_at DESC')
              ->limit($number)
              ->offset($offset);
    return $q;
  }

  /**
   * Retourne les derniers articles sous forme d'une collection
   *
   * @param <String> $culture Langue de l'article
   * @param <Integer> $number Nombre d'articles à retourner
   * @param <Integer> $offset Offset de l'article de départ
   * @return <List<Article>> Liste des $number derniers articles
   */
  public function retrieveLastArticles($culture, $number = 2, $offset = 0) {
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
  public function retrieveLastArticlesInArray($culture, $number = 2, $offset = 0) {
    return $this->buildQueryForRetrieveLastArticles($culture, $number, $offset)->fetchArray();
  }

  /**
   * Retourne l'article correspondant au slug passé en paramètre
   *
   * @param <String> $slug Slug de l'article
   * @return <Article> Article correspondant
   */
  public function retrieveBySlug($slug) {
    $q = $this->createQuery('a')
              ->leftJoin('a.Translation t')
              ->andWhere('t.slug = ?', $slug);

    return $q->fetchOne();
  }
  
  public function getActiveByLang($lang, $limit = 10) {
    $q = $this->createQuery('a');
		$q = $this->addByLangQuery($lang, $q);
		return $this->getActive($q->limit($limit));
  }
  
  public function countActive(Doctrine_Query $q = null)
	{
		return $this->count($this->addActiveQuery($q));
	}

	public function getOneActive(Doctrine_Query $q)
	{
		return $this->getOne($this->addActiveQuery($q));
	}


	public function getActive(Doctrine_Query $q = null)
	{
		return $this->get($this->addActiveQuery($q));
	}
  
	public function count(Doctrine_Query $q = null)
	{
		return $this->addQuery($q)->count();
	}

	public function getOne(Doctrine_Query $q)
	{
		return $this->addQuery($q)->fetchOne();
	}


	public function get(Doctrine_Query $q = null)
	{
		return $this->addQuery($q)->execute();
	}
    
	public function addByLangQuery($lang, Doctrine_Query $q = null)
	{
		return $this->addQuery($q)
			->leftJoin('a.Translation t')
			->andWhere('t.lang = ?', $lang);
	}
    
	public function addActiveQuery(Doctrine_Query $q = null)
	{
		return $this->addQuery($q)->andwhere('a.is_active = ?', 1);
	}
    
	public function addQuery(Doctrine_Query $q = null)
	{
		if (is_null($q)) {$q = Doctrine_Query::create()->from('article a');}
		
		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.created_at DESC');
		
		return $q;
	}

  public static function getInstance() {
    return Doctrine_Core::getTable('article');
  }
}
