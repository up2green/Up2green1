<?php
class myTestFunctional extends sfTestFunctional {

	public static $admin = array(
		'username' => 'admin',
		'password' => 'up2g@dm1n',
	);

	public static $user = array(
		'username' => 'admin',
		'password' => 'up2g@dm1n',
	);

	public function getSimpleUser(){
		return Doctrine_Core::getTable('sfGuardUser')
			->createQuery('u')
			->leftJoin('u.Partenaire p')
			->leftJoin('u.Permissions up')
			->where('p.user_id IS NULL')
			->addWhere('up.id IS NULL')
			->fetchOne();
	}

}
