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
			->andWhere('p.is_active = ?', 1)
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
    	->where('p.is_active = ?', 1)
			->leftJoin('p.Translation t')
			->andWhere('t.slug = ?', $slug);

    return $this->getOne($q);
  }
  
	public function countTrees($programmes = array()) {

		$treeTable = Doctrine_Core::getTable('tree');

		$q = $this->createQuery('p')
			->select('p.id, COUNT(t.id) AS nbTree')
			->innerJoin('p.Trees t');

		if(!empty($programmes)) {
			$q = $q->whereIn('p.id', $programmes);
		}

		$q = $q->groupBy('p.id');
		$ret = $this->getArray($q);

		foreach($ret as &$programme) {
			if(isset($treeTable::$hardcode[(int)$programme['id']])) {
				$programme['nbTree'] += $treeTable::$hardcode[$programme['id']];
			}
		}

		return $ret;
	}
  
  public function getArrayById(Doctrine_Query $q = null) {
		$results = $this->getArray($q);
		$ret = array();
		foreach($results as $result) {
			$ret[$result['id']] = $result;
		}
		return $ret;
	}

  // -----------------------------------------
	// DRY
	// -----------------------------------------
		
	public function getArrayActiveBySlug($slug, Doctrine_Query $q = null) {
		return $this->getArrayActive($this->addSlugQuery($slug, $q));
	}
  
  public function countActiveBySlug($slug, Doctrine_Query $q = null) {
		return $this->countActive($this->addSlugQuery($slug, $q));
	}

	public function getOneActiveBySlug($slug, Doctrine_Query $q = null) {
		return $this->getOneActive($this->addSlugQuery($slug, $q));
	}

	public function getActiveBySlug($slug, Doctrine_Query $q = null) {
		return $this->getActive($this->addSlugQuery($slug, $q));
	}
	
	public function getArrayBySlug($slug, Doctrine_Query $q = null) {
		return $this->getArray($this->addSlugQuery($slug, $q));
	}
  
  public function countBySlug($slug, Doctrine_Query $q = null) {
		return $this->count($this->addSlugQuery($slug, $q));
	}

	public function getOneBySlug($slug, Doctrine_Query $q = null) {
		return $this->getOne($this->addSlugQuery($slug, $q));
	}

	public function getBySlug($slug, Doctrine_Query $q = null) {
		return $this->get($this->addSlugQuery($slug, $q));
	}
	
	// -----------------------------------------
		
	public function getArrayActiveByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null) {
		return $this->getArrayActive($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
	}
  
  public function countActiveByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null) {
		return $this->countActive($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
	}

	public function getOneActiveByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null) {
		return $this->getOneActive($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
	}

	public function getActiveByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null) {
		return $this->getActive($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
	}
	
	public function getArrayByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null) {
		return $this->getArray($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
	}
  
  public function countByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null) {
		return $this->count($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
	}

	public function getOneByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null) {
		return $this->getOne($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
	}

	public function getByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null) {
		return $this->get($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
	}
	
	// -----------------------------------------
	
	public function getArrayActive(Doctrine_Query $q = null) {
		return $this->getArray($this->addActiveQuery($q));
	}
  
  public function countActive(Doctrine_Query $q = null) {
		return $this->count($this->addActiveQuery($q));
	}

	public function getOneActive(Doctrine_Query $q = null) {
		return $this->getOne($this->addActiveQuery($q));
	}

	public function getActive(Doctrine_Query $q = null) {
		return $this->get($this->addActiveQuery($q));
	}
	
	// -----------------------------------------
	
	public function getArray(Doctrine_Query $q = null) {
		return $this->addQuery($q)->fetchArray();
	}
  
	public function count(Doctrine_Query $q = null) {
		return $this->addQuery($q)->count();
	}

	public function getOne(Doctrine_Query $q = null) {
		return $this->addQuery($q)->fetchOne();
	}

	public function get(Doctrine_Query $q = null) {
		return $this->addQuery($q)->execute();
	}
	
	// -----------------------------------------
	/* Return Query */
	// -----------------------------------------
    
	public function addSlugQuery($slug, Doctrine_Query $q = null) {
		return $this->addQuery($q)
			->innerJoin('p.Translation t')
			->where('t.slug = ?', $slug);
	}
	
	public function addLangQuery($lang, Doctrine_Query $q = null) {
		return $this->addQuery($q)
			->innerJoin('p.Translation t')
			->where('t.lang = ?', $lang);
	}
  
	public function addActiveQuery(Doctrine_Query $q = null) {
		return $this->addQuery($q)->addWhere('p.is_active = ?', 1);
	}
    
	public function addQuery(Doctrine_Query $q = null) {
		if (is_null($q)) {$q = $this->createQuery('p');}
		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.created_at DESC');
		return $q;
	}
	
	// -----------------------------------------
	/* default */
	// -----------------------------------------

  public static function getInstance() {
    return Doctrine_Core::getTable('programme');
  }

}
