<?php


class engine_tagTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('engine_tag');
    }
}