<?php


class newsletter_categorieTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('newsletter_categorie');
    }
}