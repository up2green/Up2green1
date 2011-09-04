<?php

class couponTable extends Doctrine_Table {

	public static function getInstance() {
		return Doctrine_Core::getTable('coupon');
	}
  
  public function countUsedByPartenaire($partenaireId)
  {
    return $this->addQuery()
      ->innerJoin('c.Partenaire cp')
      ->where('cp.partenaire_id = ?', $partenaireId)
      ->andWhere('c.is_active = ?', 0)
      ->count();
  }
	
	public function getByUserQuery($userId) {
		return $this->addQuery()
				->innerJoin('c.User cu')
				->innerJoin('c.couponGen cg')
				->where('cu.user_id = ?', $userId);
	}
	
	public function getByPartenaireQuery($partenaireId) {
		return $this->addQuery()
				->innerJoin('c.Partenaire cp')
				->innerJoin('c.couponGen cg')
				->where('cp.partenaire_id = ?', $partenaireId);
	}

	public function addQuery(Doctrine_Query $q = null) {
		if (is_null($q)) {$q = Doctrine_Query::create()->from('coupon c');}
		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.created_at ASC');
		return $q;
	}
}
