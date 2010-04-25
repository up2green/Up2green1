<?php


class partenaire_userTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('partenaire_user');
    }
}