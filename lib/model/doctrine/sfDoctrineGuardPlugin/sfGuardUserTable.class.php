<?php


class sfGuardUserTable extends PluginsfGuardUserTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardUser');
    }

    public function getUp2greenId()
    {
        $user = self::getInstance()
			->createQuery('u')
			->where('u.username = ?', 'up2green')
			->fetchOne();

		return $user ? $user->getId() : 0;
    }
}