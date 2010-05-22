<?php


class lien_categorieTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('lien_categorie');
    }
}