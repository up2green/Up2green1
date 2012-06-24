<?php

class up2gTable extends Doctrine_Table
{
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

  public function addQuery(Doctrine_Query $q = null)
  {
    if (is_null($q)) {
      $q     = $this->createQuery($this->getAlias());
    }

    $alias = $q->getRootAlias();
    $q->addOrderBy($alias . '.created_at DESC');
    return $q;
  }

  /**
   * Return 
   *
   * @return string
   */
  protected function getAlias()
  {
    return strtolower(substr($this->getComponentName(), 0, 1));
  }
}

?>
