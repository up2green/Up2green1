<?php


class tree_programmeTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('tree_programme');
    }
}