<?php

class partenaireProgrammeTable extends Doctrine_Table
{

  public function getByPartenaireAndProgramme(partenaire $partenaire, programme $programme)
  {
    return $this->addQuery()
        ->where('pp.partenaire_id = ?', $partenaire->getId())
        ->where('pp.programme_id = ?', $programme->getId())
        ->fetchOne();
  }

  public function addQuery(Doctrine_Query $q = null)
  {
    if (is_null($q)) {
      $q = $this->createQuery('pp');
    }
    return $q;
  }

  public static function getInstance()
  {
    return Doctrine_Core::getTable('partenaireProgramme');
  }

}
