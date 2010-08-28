<?php

class categoryTable extends Doctrine_Table
{
	public function getByName($name)
	{
		$q = Doctrine_Query::create()
			->from('category c')
			->where('c.unique_name = ?', $name);
			
		return $this->getOneActive($q);
	}
	
	public function countActive(Doctrine_Query $q = null)
	{
		return $this->addQuery($q)->andwhere('c.is_active = ?', 1)->count();
	}

	public function getOneActive(Doctrine_Query $q)
	{
		return $this->addQuery($q)->andwhere('c.is_active = ?', 1)->fetchOne();
	}


	public function getActive(Doctrine_Query $q = null)
	{
		return $this->addQuery($q)->andwhere('c.is_active = ?', 1)->execute();
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
	
	public function addQuery(Doctrine_Query $q = null)
	{
		if (is_null($q)) {$q = Doctrine_Query::create()->from('category c');}

		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.level ASC');

		return $q;
	}
	
	public static function getInstance()
	{
		return Doctrine_Core::getTable('category');
	}
}
