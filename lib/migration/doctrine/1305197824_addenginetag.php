<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addenginetag extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('engine_tag', array(
             'engine_id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'length' => 4,
             ),
             'tag_id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'length' => 4,
             ),
             ), array(
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'engine_id',
              1 => 'tag_id',
             ),
             'charset' => 'UTF8',
             ));
    }

    public function down()
    {
        $this->dropTable('engine_tag');
    }
}