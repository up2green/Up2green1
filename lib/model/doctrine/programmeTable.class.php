<?php

class programmeTable extends Doctrine_Table
{

  /**
   * Construction de la requête permettant de récupérer les derniers programmes
   *
   * @param <String> $culture Langue du programme
   * @param <Integer> $number Nombre de programmes à retourner
   * @param <Integer> $offset Offset du programme de départ
   * @return <Query> Requête
   */
  protected function buildQueryForRetrieveLastProgrammes($culture, $number = 2, $offset = 0) {
    $q = $this->createQuery('p')
              ->leftJoin('p.Translation t')
              ->where('t.lang = ?', $culture)
              ->orderBy('p.created_at DESC')
              ->limit($number)
              ->offset($offset);
    return $q;
  }

  /**
   * Retourne les derniers programmes sous forme d'une collection
   *
   * @param <String> $culture Langue du programme
   * @param <Integer> $number Nombre de programmes à retourner
   * @param <Integer> $offset Offset du programme de départ
   * @return <List<Programme>> Liste des $number derniers programmes
   */
  public function retrieveLastProgrammes($culture, $number = 2, $offset = 0) {
    return $this->buildQueryForRetrieveLastProgrammes($culture, $number, $offset)->execute();
  }

  /**
   * Retourne les derniers programmes sous forme d'un array
   *
   * @param <String> $culture Langue du programme
   * @param <Integer> $number Nombre de programmes à retourner
   * @param <Integer> $offset Offset du programme de départ
   * @return <array> Tableau des $number derniers programmes
   */
  public function retrieveLastProgrammesInArray($culture, $number = 2, $offset = 0) {
    return $this->buildQueryForRetrieveLastProgrammes($culture, $number, $offset)->fetchArray();
  }

  /**
   * Retourne le programme correspondant au slug passé en paramètre
   *
   * @param <String> $slug Slug du programme
   * @return <Programme> Programme correspondant
   */
  public function retrieveBySlug($slug) {
    $q = $this->createQuery('p')
              ->leftJoin('p.Translation t')
              ->andWhere('t.slug = ?', $slug);

    return $this->getOne($q);
  }

  public function getActiveByLang($lang, $limit = 10) {
    $q = $this->createQuery('p');
		$q = $this->addByLangQuery($lang, $q);
		if(!empty($limit))
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
			->leftJoin('p.Translation t')
			->andWhere('t.lang = ?', $lang);
	}
    
	public function addActiveQuery(Doctrine_Query $q = null)
	{
		return $this->addQuery($q)->andwhere('p.is_active = ?', 1);
	}
    
	public function addQuery(Doctrine_Query $q = null)
	{
		if (is_null($q)) {$q = Doctrine_Query::create()->from('programme p');}
		
		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.created_at DESC');
		
		return $q;
	}

}
