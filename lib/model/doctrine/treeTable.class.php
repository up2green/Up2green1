<?php

class treeTable extends Doctrine_Table
{

  public function countFromUser($idUser)
  {
    return $this->createQuery('t')
        ->select('COUNT(t.id) AS nbTree')
        ->innerJoin('t.User tu')
        ->where('tu.user_id = ?', $idUser)
        ->count();
  }

  public function countFromUserByProgramme($idUser, $idProgrammes)
  {
    return $this->createQuery('t')
        ->select('t.id, t.programme_id, COUNT(t.id) AS nbTree')
        ->innerJoin('t.User tu')
        ->where('tu.user_id = ?', $idUser)
        ->whereIn('t.programme_id', $idProgrammes)
        ->groupBy('t.programme_id')
        ->fetchArray();
  }

  public function countFromCouponPartenaire($idPartenaire)
  {
    $q = $this->createQuery('t')
      ->select('COUNT(t.id) AS nbTree')
      ->innerJoin('t.Coupon tc')
      ->innerJoin('tc.coupon c')
      ->innerJoin('c.Partenaire cp')
      ->addWhere('cp.partenaire_id = ?', $idPartenaire);

    $result = $q->fetchArray();
    return (int) $result[0]['nbTree'];
  }

  public function countFromCouponPartenaireByProgramme($idPartenaire, $idProgrammes)
  {
    $q = $this->createQuery('t')
      ->select('COUNT(t.id) AS nbTree')
      ->innerJoin('t.Coupon tc')
      ->innerJoin('tc.coupon c')
      ->innerJoin('c.Partenaire cp')
      ->addWhere('cp.partenaire_id = ?', $idPartenaire)
      ->addWhere('t.programme_id = ?', $idProgrammes);

    $result = $q->fetchArray();
    return (int) $result[0]['nbTree'];
  }

  public function countByUserAndProgramme($idUser, $idProgramme)
  {
    $result = $this->createQuery('t')
      ->select('COUNT(t.id) AS nbTree')
      ->innerJoin('t.User tu')
      ->addWhere('tu.user_id = ?', $idUser)
      ->addWhere('t.programme_id = ?', $idProgramme)
      ->fetchArray();

    return $result[0]["nbTree"];
  }

  public function countByProgramme($id)
  {
    $result = $this->createQuery('t')
      ->select('t.id, COUNT(t.id) AS nbTree, p.add_tree')
      ->leftJoin('t.Programme p')
      ->addWhere('t.programme_id = ?', $id)
      ->groupBy('t.programme_id')
      ->limit(1)
      ->fetchArray();

    return $result[0]['nbTree'] + $result[0]["Programme"]["add_tree"];
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
      $q     = $this->createQuery('t');
    }
    $alias = $q->getRootAlias();
    $q->addOrderBy($alias . '.created_at DESC');
    return $q;
  }

  // -----------------------------------------
  /* default */
  // -----------------------------------------

  public static function getInstance()
  {
    return Doctrine_Core::getTable('tree');
  }

}
