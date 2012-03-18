<?php

class partenaireTable extends up2gTable
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('partenaire');
  }

}