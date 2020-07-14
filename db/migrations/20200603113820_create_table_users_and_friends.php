<?php

use Phinx\Migration\AbstractMigration;

class CreateTableUsersAndFriends extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public $dir = __DIR__;
    
    public function up()
    {
        $sql = file_get_contents($this->dir.'/../data/CreateTableUsersAndFriends_up.sql', true);
        $this->execute($sql);
    }
    
    public function down(){
        $sql = file_get_contents($this->dir.'/../data/CreateTableUsersAndFriends_down.sql', true);
        $this->execute($sql);
    }
}
