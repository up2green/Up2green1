<?php


class couponTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('coupon');
    }

    public static function getNumUnused() {

        $string = substr(md5(date('Y-m-d h:i:s:u') . rand(0, 100)), 0, 20);
        if (! $coupon = self::getInstance()->createQuery('c')->where('c.code = ?', $string)->fetchOne())
            return $string;
//        else return $this->getNumUnused();
        else return self::getNumUnused();
    }
}