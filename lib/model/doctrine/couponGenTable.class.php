<?php

class couponGenTable extends Doctrine_Table
{

  public static function getTabChoices()
  {
    $tab = array();
    foreach (self::getInstance()->findAll() as $coupon) {
      $tab[$coupon->getId()] = $coupon->__toString();
    }
    return $tab;
  }

  public function getArrayById(Doctrine_Query $q = null)
  {
    $results = $this->getArray($q);
    $ret     = array();
    foreach ($results as $result) {
      $ret[$result['id']] = $result;
    }
    return $ret;
  }

  // -----------------------------------------
  // DRY
  // -----------------------------------------

  public function getArrayPurchasable(Doctrine_Query $q = null)
  {
    return $this->getArray($this->addPurchasableQuery($q));
  }

  public function countPurchasable(Doctrine_Query $q = null)
  {
    return $this->count($this->addPurchasableQuery($q));
  }

  public function getOnePurchasable(Doctrine_Query $q = null)
  {
    return $this->getOne($this->addPurchasableQuery($q));
  }

  public function getPurchasable(Doctrine_Query $q = null)
  {
    return $this->get($this->addPurchasableQuery($q));
  }

  // -----------------------------------------

  public function getArray(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->fetchArray();
  }

  public function count(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->count();
  }

  public function getOne(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->fetchOne();
  }

  public function get(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->execute();
  }

  // -----------------------------------------
  /* Return Query */
  // -----------------------------------------

  public function addPurchasableQuery(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->addWhere('c.is_purchasable = ?', 1);
  }

  public function addQuery(Doctrine_Query $q = null)
  {
    if (is_null($q)) {
      $q     = $this->createQuery('c');
    }
    $alias = $q->getRootAlias();
    $q->addOrderBy($alias . '.credit');
    return $q;
  }

  // -----------------------------------------
  /* default */
  // -----------------------------------------

  public static function getInstance()
  {
    return Doctrine_Core::getTable('couponGen');
  }

}