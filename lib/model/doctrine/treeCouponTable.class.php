<?php

/**
 * treeCoupon Table class
 *
 * @category Lib
 * @package  ModelTable
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class treeCouponTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('treeCoupon');
  }

  /**
   * Create the query for trees planted by partners vouchers
   *
   * @return Doctrine_Query
   */
  public function createUserVoucherQuery($indexBy = null)
  {
    $query = $this->createQuery('tc');

    if (null !== $indexBy)
    {
      $query->from(sprintf('treeCoupon tc INDEXBY %s', $indexBy));
    }

    return $query->innerJoin('tc.tree t')
      ->innerJoin('tc.coupon c')
      ->innerJoin('c.User cu');
  }

  /**
   * Create the query for trees planted by partners vouchers
   *
   * @return Doctrine_Query
   */
  public function createPartnerVoucherQuery($indexBy = null)
  {
    $query = $this->createQuery('tc');

    if (null !== $indexBy)
    {
      $query->from(sprintf('treeCoupon tc INDEXBY %s', $indexBy));
    }

    return $query->innerJoin('tc.tree t')
        ->innerJoin('tc.coupon c')
        ->innerJoin('c.Partenaire cu');
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

  public function getArray(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->fetchArray();
  }

  public function addQuery(Doctrine_Query $q = null)
  {
    if (is_null($q))
    {
      $q = $this->createQuery('tc');
    }

    $alias = $q->getRootAlias();

    return $q;
  }

}
