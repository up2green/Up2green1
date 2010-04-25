<?php


class article_categorieTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('article_categorie');
    }
}