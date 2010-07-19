<?php


class lienTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('lien');
    }
    
    public function getActiveLiens(Doctrine_Query $q = null)
	{
/*
		if (is_null($q))
			$q = Doctrine_Query::create()->from('lien j');
		
		$alias = $q->getRootAlias();

		$q->andWhere($alias . '.is_active = true')
		->addOrderBy($alias . '.created_at DESC');

		return $q;

		return Doctrine::getTable('lien')
			->createQuery('l')
			->where('l.is_active = true')
			->addOrderBy('l.title ASC');
			->execute();
*/
	}
}
