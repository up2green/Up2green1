<?php

class logCouponTable extends Doctrine_Table
{

  public function getDistinctEmails($forced = false, $excludes = array())
  {
    $excludes[] = '';

    $q = $this->createQuery('lc')
      ->select('DISTINCT(lc.email) as email')
      ->orderBy('lc.email')
      ->whereNotIn('lc.email', $excludes)
      ->andWhere('lc.email IS NOT NULL');

    if (!$forced) {
      $q->andWhere('lc.is_newsletter = ?', 1);
    }

    $values = $q->fetchArray();
    $return = array();

    foreach ($values as $value) {
      $return[] = $value['email'];
    }

    return $return;
  }

  public static function getInstance()
  {
    return Doctrine_Core::getTable('logCoupon');
  }

}