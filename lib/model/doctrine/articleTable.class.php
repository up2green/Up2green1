<?php


class articleTable extends Doctrine_Table {

  /**
   * Construction de la requête permettant de récupérer les derniers articles
   *
   * @param <String> $culture Langue de l'article
   * @param <Integer> $number Nombre d'articles à retourner
   * @param <Integer> $offset Offset de l'article de départ
   * @return <Query> Requête
   */
  protected function buildQueryForRetrieveLastArticles($culture, $number = 2, $offset = 0) {
    $q = $this->createQuery('a')
              ->leftJoin('a.Translation t')
              ->where('t.lang = ?', $culture)
              ->orderBy('a.created_at DESC')
              ->limit($number)
              ->offset($offset);
    return $q;
  }

  /**
   * Retourne les derniers articles sous forme d'une collection
   *
   * @param <String> $culture Langue de l'article
   * @param <Integer> $number Nombre d'articles à retourner
   * @param <Integer> $offset Offset de l'article de départ
   * @return <List<Article>> Liste des $number derniers articles
   */
  public function retrieveLastArticles($culture, $number = 2, $offset = 0) {
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
  public function retrieveLastArticlesInArray($culture, $number = 2, $offset = 0) {
    return $this->buildQueryForRetrieveLastArticles($culture, $number, $offset)->fetchArray();
  }

  /**
   * Retourne l'article correspondant au slug passé en paramètre
   *
   * @param <String> $slug Slug de l'article
   * @return <Article> Article correspondant
   */
  public function retrieveBySlug($slug) {
    $q = $this->createQuery('a')
              ->leftJoin('a.Translation t')
              ->andWhere('t.slug = ?', $slug);

    return $q->fetchOne();
  }

  public static function getInstance() {
    return Doctrine_Core::getTable('article');
  }
}