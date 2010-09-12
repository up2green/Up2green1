<?php


class couponGenTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('couponGen');
    }

    public static function getTabChoices(){
        $tab = array();
        foreach (self::getInstance()->findAll() as $coupon){
            $tab[$coupon->getId()] = $coupon->__toString();
        }
        return $tab;
    }
}