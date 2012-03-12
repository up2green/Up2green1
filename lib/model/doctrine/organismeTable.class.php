<?php

class organismeTable extends ActiveAndI18nTable
{
  public static function getInstance()
  {
    return Doctrine_Core::getTable('organisme');
  }
}
