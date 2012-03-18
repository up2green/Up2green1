<?php

class lienTable extends ActiveAndI18nTable
{
  public static function getInstance()
  {
    return Doctrine_Core::getTable('lien');
  }
}
