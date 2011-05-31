<?php
class treeTable extends Doctrine_Table {
	
	public static $hardcode = array(
		10 => 188, //Madagascar
		8 => 162, //Burkina Faso
		14 => 1620, //Perou
		18 => 189, //Inde
		17 => 155 //Ethiopie
	);
    
    public function countFromUser($idUser) {
    	return $this->createQuery('t')
				->select('COUNT(t.id) AS nbTree')
				->innerJoin('t.User tu')
				->where('tu.user_id = ?', $idUser)
				->count();
		}
		
    public function countFromUserByProgramme($idUser, $idProgrammes) {
    	return $this->createQuery('t')
				->select('t.id, t.programme_id, COUNT(t.id) AS nbTree')
				->innerJoin('t.User tu')
				->where('tu.user_id = ?', $idUser)
				->whereIn('t.programme_id', $idProgrammes)
				->groupBy('t.programme_id')
				->fetchArray();
				
		}
		
    public function countFromCouponPartenaireByProgramme($idPartenaire, $idProgrammes) {
    	return $this->createQuery('t')
				->select('t.id, t.programme_id, COUNT(t.id) AS nbTree')
				->innerJoin('t.Coupon tc')
				->innerJoin('tc.coupon c')
				->innerJoin('c.Partenaire cp')
				->where('cp.partenaire_id = ?', $idPartenaire)
				->whereIn('t.programme_id', $idProgrammes)
				->groupBy('t.programme_id')
				->fetchArray();
				
		}
		
		public function countByUserAndProgramme($idUser, $idProgramme) {
			return $this->createQuery('t')
				->innerJoin('t.User tu')
				->where('tu.user_id = ?', $idUser)
				->where('t.programme_id', $idProgramme)
				->count();
		}
		
		public function countByProgramme($id) {
			return $this->createQuery('t')
				->where('t.programme_id', $id)
				->count() + (isset(self::$hardcode[(int)$id]) ? self::$hardcode[(int)$id] : 0);
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
		if (is_null($q)) {$q = $this->createQuery('t');}
		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.created_at DESC');
		return $q;
	}
	
	// -----------------------------------------
	/* default */
	// -----------------------------------------

  public static function getInstance() {
    return Doctrine_Core::getTable('tree');
  }
}
