<?php

class treeUserTable extends Doctrine_Table
{

  public function plantArbre($nb, $programme, $user)
  {
    for ($i = 0; $i < $nb; $i++) {
      $tree = new tree();
      if (is_integer($programme)) {
        $tree->setProgrammeId($programme);
      } else {
        $tree->setProgramme($programme);
      }
      $tree->save();

      if ($user->getGuardUser()) {
        $treeUser = new treeUser();
        $treeUser->setTree($tree);
        $treeUser->setUser($user->getGuardUser());
        $treeUser->save();
      }
    }
  }

  public function countByUser($userId)
  {
    $q = $this->addQuery()->addWhere('user_id = ?', $userId);
    return $this->count($q);
  }

  // -----------------------------------------

  public function getArray(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->fetchArray();
  }

  public function count(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->count();
  }

  public function getOne(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->fetchOne();
  }

  public function get(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->execute();
  }

  // -----------------------------------------
  /* Return Query */
  // -----------------------------------------

  public function addQuery(Doctrine_Query $q = null)
  {
    if (is_null($q)) {
      $q = $this->createQuery('t');
    }
    return $q;
  }

  // -----------------------------------------
  /* default */
  // -----------------------------------------

  public static function getInstance()
  {
    return Doctrine_Core::getTable('treeUser');
  }

}