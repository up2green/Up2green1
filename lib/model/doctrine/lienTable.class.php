<?php

class lienTable extends Doctrine_Table
{
	public function countActive(Doctrine_Query $q = null)
	{
		return $this->addQuery($q)->andwhere('l.is_active = ?', 1)->count();
	}

	public function getOneActive(Doctrine_Query $q)
	{
		return $this->addQuery($q)->andwhere('l.is_active = ?', 1)->fetchOne();
	}


	public function getActive(Doctrine_Query $q = null)
	{
		return $this->addQuery($q)->andwhere('l.is_active = ?', 1)->execute();
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
		if (is_null($q)) {$q = Doctrine_Query::create()->from('lien l');}

		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.rank ASC');

		return $q;
	}
	
	public static function getInstance()
	{
		return Doctrine_Core::getTable('lien');
	}
}
