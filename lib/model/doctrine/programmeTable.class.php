<?php


class programmeTable extends Doctrine_Table
{
    
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
        return $this->addQuery($q)->fetchOne();
    }
    
    public function addQuery(Doctrine_Query $q = null)
	{
		if (is_null($q)) {$q = Doctrine_Query::create()->from('programme p');}
		
		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.created_at DESC');
		
		return $q;
	}

}
