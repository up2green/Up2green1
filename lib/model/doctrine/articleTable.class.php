<?php

class articleTable extends ActiveAndI18nTable
{

  /**
   * Construction de la requête permettant de récupérer les derniers articles
   *
   * @param <String> $culture Langue de l'article
   * @param <Integer> $number Nombre d'articles à retourner
   * @param <Integer> $offset Offset de l'article de départ
   * @return <Query> Requête
   */
  protected function buildQueryForRetrieveLastArticles($culture, $number = 2, $offset = 0)
  {
    return $this->createQuery('a')
        ->leftJoin('a.Translation t')
        ->where('t.lang = ?', $culture)
        ->andWhere('a.is_active = ?', 1)
        ->orderBy('a.created_at DESC')
        ->limit($number)
        ->offset($offset);
  }

  /**
   * Retourne les derniers articles sous forme d'une collection
   *
   * @param <String> $culture Langue de l'article
   * @param <Integer> $number Nombre d'articles à retourner
   * @param <Integer> $offset Offset de l'article de départ
   * @return <List<Article>> Liste des $number derniers articles
   */
  public function retrieveLastArticles($culture, $number = 2, $offset = 0)
  {
    return $this->buildQueryForRetrieveLastArticles($culture, $number, $offset)->execute();
  }

  /**
   * Retourne les derniers articles sous forme d'un array
   *
   * @param <String> $culture Langue de l'article
   * @param <Integer> $number Nombre d'articles à retourner
   * @param <Integer> $offset Offset de l'article de départ
   * @return <array> Tableau des $number derniers articles
   */
  public function retrieveLastArticlesInArray($culture, $number = 2, $offset = 0)
  {
    return $this->buildQueryForRetrieveLastArticles($culture, $number, $offset)->fetchArray();
  }

  /**
   * Return the name of the table for queries, its strange but if its not
   * uppercased I have some trouble with Translations
   *
   * TODO : uppercase the table name in the schema
   * @return string 
   */
  public function getComponentName()
  {
    return 'Article';
  }

  public static function getInstance()
  {
    return Doctrine_Core::getTable('article');
  }

}
