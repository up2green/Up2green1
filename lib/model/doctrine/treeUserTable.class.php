<?php


class treeUserTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('treeUser');
    }

	public function plantArbre($nb, programme $programme, $user) {
		for ($i = 0; $i < $nb; $i ++) {
			$tree = new tree();
			$tree->setProgramme($programme);
			$tree->save();

			if ($user->getGuardUser()) {
				$treeUser = new treeUser();
				$treeUser->setTree($tree);
				$treeUser->setUser($user->getGuardUser());
				$treeUser->save();
			}
		}
    }
}