<?php


class couponGenTable extends Doctrine_Table
{


	public static function getTabChoices(){
	$tab = array();
	foreach (self::getInstance()->findAll() as $coupon){
	$tab[$coupon->getId()] = $coupon->__toString();
	}
	return $tab;
	}
	
	public function getArrayById(Doctrine_Query $q = null) {
		$results = $this->addQuery($q)->fetchArray();
		$ret = array();
		foreach($results as $result) {
			$ret[$result['id']] = $result;
		}
		return $ret;
	}
	
	public function count(Doctrine_Query $q = null) {
		return $this->addQuery($q)->count();
	}

	public function getOne(Doctrine_Query $q) {
		return $this->addQuery($q)->fetchOne();
	}

	public function getArray(Doctrine_Query $q = null) {
		return $this->addQuery($q)->fetchArray();
	}

	public function get(Doctrine_Query $q = null) {
		return $this->addQuery($q)->execute();
	}
	
	public function addQuery(Doctrine_Query $q = null) {
		if (is_null($q)) {$q = Doctrine_Query::create()->from('couponGen c');}
		$alias = $q->getRootAlias();
		$q->addOrderBy($alias . '.credit ASC');
		return $q;
	}
	
	public static function getInstance() {
		return Doctrine_Core::getTable('couponGen');
	}
}