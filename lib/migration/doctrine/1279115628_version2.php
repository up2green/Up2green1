<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version2 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropForeignKey('categorie', 'categorie_parent_id_categorie_id');
    }

    public function down()
    {
        $this->createForeignKey('categorie', 'categorie_parent_id_categorie_id', array(
             'name' => 'categorie_parent_id_categorie_id',
             'local' => 'parent_id',
             'foreign' => 'id',
             'foreignTable' => 'categorie',
             'onUpdate' => '',
             'onDelete' => 'CASCADE',
             ));
    }
}