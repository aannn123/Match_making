<?php

use Phinx\Migration\AbstractMigration;

class CreateRequestTaarufTable extends AbstractMigration
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
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $user = $this->table('request_taaruf');
             $user->addColumn('id_perequest', 'integer')
                  ->addColumn('id_terequest', 'integer')
                  ->addColumn('status', 'integer', ['limit' => 3, 'default' => 0])
                  ->addColumn('blokir', 'integer', ['limit' => 1, 'default' => 0])
                  ->addColumn('update_at', 'datetime')
                  ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                  ->addForeignKey('id_perequest', 'users', 'id')
                  ->addForeignKey('id_terequest', 'users', 'id')
                  ->create();
    }
}
