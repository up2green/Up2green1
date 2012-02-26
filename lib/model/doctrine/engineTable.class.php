<?php

class engineTable extends Doctrine_Table
{

  public function getSearch($search, $number = 10, $offset = 0)
  {
    return $this->get($this->buildSearchQuery($search, $number, $offset));
  }

  public function getArraySearch($search, $number = 10, $offset = 0)
  {
    return $this->getArray($this->buildSearchQuery($search, $number, $offset));
  }

  protected function buildSearchQuery($search, $number = 10, $offset = 0)
  {
    return $this->addActiveQuery()
        ->where('site_display LIKE ?', '%' . $search . '%')
        ->orWhere('description LIKE ?', '%' . $search . '%')
        ->orWhere('html LIKE ?', '%' . $search . '%')
        ->limit($number)
        ->offset($offset);
  }

  public static function getInstance()
  {
    return Doctrine_Core::getTable('engine');
  }

  public function countActive(Doctrine_Query $q = null)
  {
    return $this->count($this->addActiveQuery($q));
  }

  public function getOneActive(Doctrine_Query $q)
  {
    return $this->getOne($this->addActiveQuery($q));
  }

  public function getActive(Doctrine_Query $q = null)
  {
    return $this->get($this->addActiveQuery($q));
  }

  public function getArrayActive(Doctrine_Query $q = null)
  {
    return $this->getArray($this->addActiveQuery($q));
  }

  public function count(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->count();
  }

  public function getOne(Doctrine_Query $q)
  {
    return $this->addQuery($q)->fetchOne();
  }

  public function getArray(Doctrine_Query $q)
  {
    return $this->addQuery($q)->fetchArray();
  }

  public function get(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->execute();
  }

  public function addActiveQuery(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->andwhere('e.is_active = ?', '1');
  }

  public function addQuery(Doctrine_Query $q = null)
  {
    if (is_null($q)) {
      $q = Doctrine_Query::create()->from('engine e');
    }

    $alias = $q->getRootAlias();
    $q->addOrderBy($alias . '.created_at DESC');

    return $q;
  }

}