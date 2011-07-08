<?php


class organismeTable extends Doctrine_Table {
	
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
	       
	public function getArrayInactive(Doctrine_Query $q = null) {
		return $this->getArray($this->addInactiveQuery($q));
	}
	                                 
	public function countInactive(Doctrine_Query $q = null) {
		return $this->count($this->addInactiveQuery($q));
	}
	                                                         
	public function getOneInactive(Doctrine_Query $q = null) {
		return $this->getOne($this->addInactiveQuery($q));
	}
	                                                                                 
	public function getInactive(Doctrine_Query $q = null) {
		return $this->get($this->addInactiveQuery($q));
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
			->innerJoin('o.Translation t')
			->where('t.slug = ?', $slug);
	}
	
	public function addLangQuery($lang, Doctrine_Query $q = null) {
		return $this->addQuery($q)
			->innerJoin('o.Translation t WITH t.lang = ?', $lang);
	}
  
	public function addActiveQuery(Doctrine_Query $q = null) {
		return $this->addQuery($q)->addWhere('o.is_active = ?', 1);
	}

	public function addInactiveQuery(Doctrine_Query $q = null) {
		return $this->addQuery($q)->addWhere('o.is_active = ?', 0);
	}
    
	public function addQuery(Doctrine_Query $q = null) {
		if (is_null($q)) {$q = $this->createQuery('o');}
		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.created_at DESC');
		return $q;
	}
	
	// -----------------------------------------
	/* default */
	// -----------------------------------------

  public static function getInstance() {
    return Doctrine_Core::getTable('organisme');
  }
}
