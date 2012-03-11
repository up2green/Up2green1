<?php

class ActiveAndI18nTable extends up2gTable
{
  public function getActiveByLangQuery($lang)
  {
    return $this->addLangQuery($lang, $this->addActiveQuery());
  }

  public function getArrayActiveBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->getArrayActive($this->addSlugQuery($slug, $q));
  }

  public function countActiveBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->countActive($this->addSlugQuery($slug, $q));
  }

  public function getOneActiveBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->getOneActive($this->addSlugQuery($slug, $q));
  }

  public function getActiveBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->getActive($this->addSlugQuery($slug, $q));
  }

  public function getArrayBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->getArray($this->addSlugQuery($slug, $q));
  }

  public function countBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->count($this->addSlugQuery($slug, $q));
  }

  public function getOneBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->getOne($this->addSlugQuery($slug, $q));
  }

  public function getBySlug($slug, Doctrine_Query $q = null)
  {
    return $this->get($this->addSlugQuery($slug, $q));
  }

  // -----------------------------------------

  public function getArrayActiveByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->getArrayActive($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function countActiveByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->countActive($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function getOneActiveByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->getOneActive($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function getActiveByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->getActive($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function getArrayByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->getArray($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function countByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->count($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function getOneByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->getOne($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

  public function getByLang($lang, $limit = 10, $offset = 0, Doctrine_Query $q = null)
  {
    return $this->get($this->addLangQuery($lang, $q)->limit($limit)->offset($offset));
  }

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

  public function addSlugQuery($slug, Doctrine_Query $q = null)
  {
    return $this->addQuery($q)
        ->innerJoin($this->getAlias().'.Translation t')
        ->where('t.slug = ?', $slug);
  }

  public function addLangQuery($lang, Doctrine_Query $q = null)
  {
    return $this->addQuery($q)
        ->innerJoin($this->getAlias().'.Translation t')
        ->where('t.lang = ?', $lang);
  }

  public function addActiveQuery(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->addWhere($this->getAlias().'.is_active = ?', 1);
  }

  public function addInactiveQuery(Doctrine_Query $q = null)
  {
    return $this->addQuery($q)->addWhere($this->getAlias().'.is_active = ?', 0);
  }
}

?>
