<?php

class couponTable extends Doctrine_Table {

	public static function getInstance() {
		return Doctrine_Core::getTable('coupon');
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

	public static function getNumUnused($prefix = '') {
		$string = strtoupper($prefix);
		$string .= substr(md5(date('Y-m-d h:i:s:u') . rand(0, 100)), 0, 9 - strlen($prefix));

		if (! $coupon = self::getInstance()
			->createQuery('c')
			->where('c.code = ?', $string)
			->fetchOne()) {
			return strtoupper($string);
		}
		else {
			return self::getNumUnused($prefix);
		}
	}
	
	public function addQuery(Doctrine_Query $q = null) {
		if (is_null($q)) {$q = Doctrine_Query::create()->from('coupon c');}
		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.created_at ASC');
		return $q;
	}
}