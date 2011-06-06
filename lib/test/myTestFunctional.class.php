<?php
class myTestFunctional extends sfTestFunctional {

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
