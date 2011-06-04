<?php


class sfGuardUserTable extends PluginsfGuardUserTable
{
    public function getUp2greenId()
    {
        $user = self::getInstance()
			->createQuery('u')
			->where('u.username = ?', 'up2green')
			->fetchOne();

		return $user ? $user->getId() : 0;
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
   
	public function addQuery(Doctrine_Query $q = null) {
		if (is_null($q)) {$q = $this->createQuery('u');}
		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.created_at DESC');
		return $q;
	}
	
	// -----------------------------------------
	/* default */
	// -----------------------------------------

  public static function getInstance() {
    return Doctrine_Core::getTable('sfGuardUser');
  }
}