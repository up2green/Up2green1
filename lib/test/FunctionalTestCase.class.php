<?php

/**
 * Project class for Functional tests 
 */
class FunctionalTestCase extends sfPHPUnitBaseFunctionalTestCase
{
  public static $admin = array(
    'username' => 'admin',
    'password' => 'up2g@dm1n',
  );
  
  public static $user = array(
    'username' => 'admin',
    'password' => 'up2g@dm1n',
  );

  public static function getSimpleUser()
  {
    return Doctrine_Core::getTable('sfGuardUser')
        ->createQuery('u')
        ->leftJoin('u.Partenaire p')
        ->leftJoin('u.Permissions up')
        ->where('p.user_id IS NULL')
        ->addWhere('up.id IS NULL')
        ->fetchOne();
  }

  public static function getVoucher()
  {
    return Doctrine_Core::getTable('coupon')
        ->createQuery('c')
        ->where('c.created_at > (NOW() - INTERVAL 2 MONTH)')
        ->addWhere('c.is_active = ?', true)
        ->fetchOne();
  }

}
