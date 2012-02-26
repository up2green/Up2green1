<?php

/**
 * Programme model class
 *
 * @category Lib
 * @package  Model
 * @author   Clément Gautier <clement.gautier@smartit.fr>
 * @license  http://creativecommons.org/licenses/by-nc-nd/3.0/ CC BY-NC-ND 3.0
 */
class programme extends Baseprogramme
{

  /**
   * Get the trees planted in this program using the reforestation
   * platform by the users with partners vouchers grouped by date
   *
   * @return array
   */
  public function getTreesVoucherPartnerGroupByMonth()
  {
    return $this->createTreesVoucherPartnerQuery('month')
      ->select('tc.tree_id')
      ->addSelect('COUNT(t.id) as partnerVoucherCount')
      ->addSelect('DATE_FORMAT(t.created_at, "%Y-%m") as month')
      ->groupBy('month')
      ->fetchArray();
  }

  /**
   * Count the trees planted in this program using the reforestation
   * platform by the users with partners vouchers
   *
   * @return int
   */
  public function countTreesVoucherPartner()
  {
    return $this->createTreesVoucherPartnerQuery()->count();
  }

  /**
   * Get the trees planted in this program using the reforestation
   * platform by the users with vouchers they bought (not partner)
   * grouped by date
   *
   * @return array
   */
  public function getTreesVoucherUserGroupByMonth()
  {
    return $this->createTreesVoucherUserQuery('month')
      ->select('tc.tree_id')
      ->addSelect('COUNT(t.id) as userVoucherCount')
      ->addSelect('DATE_FORMAT(t.created_at, "%Y-%m") as month')
      ->groupBy('month')
      ->fetchArray();
  }

  /**
   * Count the trees planted in this program using the reforestation
   * platform by the users with vouchers they bought (not partner)
   *
   * @return int
   */
  public function countTreesVoucherUser()
  {
    return $this->createTreesVoucherUserQuery()->count();
  }

  /**
   * Get the trees planted in this program using the reforestation
   * platform by the users without vouchers grouped by date
   *
   * @return array
   */
  public function getTreesUserGroupByMonth()
  {
    return $this->createTreesUserQuery('month')
      ->select('tu.tree_id')
      ->addSelect('COUNT(t.id) as userAccountCount')
      ->addSelect('DATE_FORMAT(t.created_at, "%Y-%m") as month')
      ->groupBy('month')
      ->fetchArray();
  }

  /**
   * Count the trees planted in this program using the reforestation
   * platform by the users without vouchers
   *
   * @return int
   */
  public function countTreesUser()
  {
    return $this->createTreesUserQuery()->count();
  }

  /**
   * Count the trees planted in this program using the reforestation
   * platform (without adding any hardcoded number)
   *
   * @return int
   */
  public function countTrees()
  {
    return Doctrine_Core::getTable('tree')
      ->createQuery('t')
      ->where('t.programme_id = ?', $this->getId())
      ->count();
  }

  /**
   * Create a query for trees planted in
   * this program by user vouchers (not partners)
   *
   * @return Doctrine_Query
   */
  public function createTreesVoucherUserQuery($indexBy = null)
  {
    return Doctrine_Core::getTable('treeCoupon')
      ->createUserVoucherQuery($indexBy)
      ->addWhere('t.programme_id = ?', $this->getId());
  }

  /**
   * Create a query for trees planted in
   * this program by partners vouchers
   *
   * @return Doctrine_Query
   */
  public function createTreesVoucherPartnerQuery($indexBy = null)
  {
    return Doctrine_Core::getTable('treeCoupon')
      ->createPartnerVoucherQuery($indexBy)
      ->addWhere('t.programme_id = ?', $this->getId());
  }

  /**
   * Create a query for trees planted in this program 
   * by users without using vouchers
   *
   * @return Doctrine_Query
   */
  public function createTreesUserQuery($indexBy = null)
  {
    return Doctrine_Core::getTable('treeUser')
      ->createTreeWitoutVoucherQuery($indexBy)
      ->addWhere('t.programme_id = ?', $this->getId());
  }

}
