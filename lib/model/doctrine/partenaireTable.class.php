<?php

class partenaireTable extends up2gTable
{

    // -----------------------------------------

    public function getArrayActive(Doctrine_Query $q = null)
    {
        return $this->getArray($this->addActiveQuery($q));
    }

    public function countActive(Doctrine_Query $q = null)
    {
        return $this->count($this->addActiveQuery($q));
    }

    public function getOneActive(Doctrine_Query $q = null)
    {
        return $this->getOne($this->addActiveQuery($q));
    }

    public function getActive(Doctrine_Query $q = null)
    {
        return $this->get($this->addActiveQuery($q));
    }

    // -----------------------------------------
    /* Return Query */
    // -----------------------------------------

    public function addActiveQuery(Doctrine_Query $q = null)
    {
        return $this->addQuery($q)->addWhere($this->getAlias() . '.is_active = ?', 1);
    }

    public function addInactiveQuery(Doctrine_Query $q = null)
    {
        return $this->addQuery($q)->addWhere($this->getAlias() . '.is_active = ?', 0);
    }

    public static function getInstance()
    {
        return Doctrine_Core::getTable('partenaire');
    }
}