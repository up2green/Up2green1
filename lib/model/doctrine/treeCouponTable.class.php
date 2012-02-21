<?php

class treeCouponTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('treeCoupon');
  }

  // DRY

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

  public function getArray(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->fetchArray();
  }

  public function addQuery(Doctrine_Query $q = null)
  {
    if (is_null($q)) {
      $q = $this->createQuery('tc');
    }

    $alias = $q->getRootAlias();

    return $q;
  }

}
