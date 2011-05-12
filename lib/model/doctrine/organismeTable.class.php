<?php


class organismeTable extends Doctrine_Table
{
	public function retrieveBySlug($slug) {
    $q = $this->createQuery('o')
              ->leftJoin('o.Translation t')
              ->andWhere('t.slug = ?', $slug);

    return $this->getOne($q);
  }
  
	public function getArrayByLang($lang, $limit = 10) {
    $q = $this->createQuery('o');
		$q = $this->addByLangQuery($lang, $q);
		return $this->getArray($q->limit($limit));
  }
  
	public function getByLang($lang, $limit = 10) {
    $q = $this->createQuery('o');
		$q = $this->addByLangQuery($lang, $q);
		return $this->get($q->limit($limit));
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
    
	public function getArray(Doctrine_Query $q = null)
	{
		return $this->addQuery($q)->fetchArray();
	}
    
	public function addByLangQuery($lang, Doctrine_Query $q = null)
	{
		return $this->addQuery($q)
			->leftJoin('o.Translation t')
			->where('t.lang = ?', $lang);
	}
    
	public function addQuery(Doctrine_Query $q = null)
	{
		if (is_null($q)) {$q = $this->createQuery('o');}
		
		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.created_at DESC');
		
		return $q;
	}
	
	public static function getInstance()
	{
		return Doctrine_Core::getTable('Organisme');
	}
}
