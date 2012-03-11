<?php

/**
 * Manage Queries for the programme Table 
 */
class programmeTable extends ActiveAndI18nTable
{

  /**
   * Construction de la requête permettant de récupérer les derniers programmes
   *
   * @param <String> $culture Langue du programme
   * @param <Integer> $number Nombre de programmes à retourner
   * @param <Integer> $offset Offset du programme de départ
   * @return <Query> Requête
   */
  protected function buildQueryForRetrieveLastProgrammes($culture, $number = 2, $offset = 0)
  {
    $q = $this->createQuery('p')
      ->leftJoin('p.Translation t')
      ->where('t.lang = ?', $culture)
      ->andWhere('p.is_active = ?', 1)
      ->orderBy('p.created_at DESC')
      ->limit($number)
      ->offset($offset);
    return $q;
  }

  /**
   * Retourne les derniers programmes sous forme d'une collection
   *
   * @param <String> $culture Langue du programme
   * @param <Integer> $number Nombre de programmes à retourner
   * @param <Integer> $offset Offset du programme de départ
   * @return <List<Programme>> Liste des $number derniers programmes
   */
  public function retrieveLastProgrammes($culture, $number = 2, $offset = 0)
  {
    return $this->buildQueryForRetrieveLastProgrammes($culture, $number, $offset)->execute();
  }

  /**
   * Retourne les derniers programmes sous forme d'un array
   *
   * @param <String> $culture Langue du programme
   * @param <Integer> $number Nombre de programmes à retourner
   * @param <Integer> $offset Offset du programme de départ
   * @return <array> Tableau des $number derniers programmes
   */
  public function retrieveLastProgrammesInArray($culture, $number = 2, $offset = 0)
  {
    return $this->buildQueryForRetrieveLastProgrammes($culture, $number, $offset)->fetchArray();
  }

  public function countTrees($programmes = array())
  {

    $treeTable = Doctrine_Core::getTable('tree');

    $q = $this->createQuery('p')
      ->select('p.id, COUNT(t.id) AS nbTree')
      ->innerJoin('p.Trees t');

    if (!empty($programmes)) {
      $q = $q->whereIn('p.id', $programmes);
    }

    $q   = $q->groupBy('p.id');
    $ret = $this->getArray($q);

    foreach ($ret as &$programme) {
      if (isset($treeTable::$hardcode[(int) $programme['id']])) {
        $programme['nbTree'] += $treeTable::$hardcode[$programme['id']];
      }
    }

    return $ret;
  }

  public function getArrayById(Doctrine_Query $q = null)
  {
    $results = $this->getArray($q);
    $ret     = array();
    foreach ($results as $result) {
      $ret[$result['id']] = $result;
    }
    return $ret;
  }

  public static function getInstance()
  {
    return Doctrine_Core::getTable('programme');
  }

}
