<?php

use Phinx\Migration\AbstractMigration;

class CreateUserTable extends AbstractMigration
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
         $user = $this->table('users');
            $user->addColumn('username', 'string')
                 ->addColumn('gender', 'enum', ['values' => ['laki-laki', 'perempuan']])
                 ->addColumn('email', 'string')
                 ->addColumn('phone', 'string')
                 ->addColumn('password', 'string')
                 // ->addColumn('password_reset_token', 'string')
                 ->addColumn('photo', 'string', ['default' => 'avatar.png'])
                 ->addColumn('ktp', 'string', ['default' => 'avatar.png'])
                 ->addColumn('role', 'integer', ['limit' => 3, 'default' => 0])
                 ->addColumn('status', 'string', ['default' => 0])
                 // ->addColumn('accepted_by', 'integer', ['default' => 0])
                 ->addColumn('last_online', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                 ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                 ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP','update' => 'CURRENT_TIMESTAMP'])
                 ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0])
                 ->addIndex(['username', 'email', 'id'], ['unique' => true])
                 ->create();
    }
}
