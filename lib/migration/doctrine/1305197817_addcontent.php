<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addcontent extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('content', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'autoincrement' => true,
              'length' => 4,
             ),
             'layout_id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'length' => 4,
             ),
             'zone_id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'length' => 4,
             ),
             'module_id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'length' => 4,
             ),
             'created_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             'updated_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             ), array(
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
              1 => 'layout_id',
              2 => 'zone_id',
              3 => 'module_id',
             ),
             'charset' => 'UTF8',
             ));
    }

    public function down()
    {
        $this->dropTable('content');
    }
}