<?php

use Phinx\Migration\AbstractMigration;

class CreateLatarBelakangTable extends AbstractMigration
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
        $user = $this->table('latar_belakang');
             $user->addColumn('user_id', 'integer')
                  ->addColumn('pendidikan', 'string')
                  ->addColumn('penjelasan_pendidikan', 'text')
                  ->addColumn('agama', 'string')
                  ->addColumn('penjelasan_agama', 'text')
                  ->addColumn('muallaf', 'string', ['null' => true])
                  ->addColumn('baca_quran', 'string')
                  ->addColumn('hafalan', 'string')
                  ->addColumn('keluarga', 'string')
                  ->addColumn('penjelasan_keluarga', 'text')
                  ->addColumn('shalat', 'string')
                  ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP','update' => 'CURRENT_TIMESTAMP'])
                  ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                  ->addIndex('user_id', ['unique' => true])
                  ->addForeignKey('user_id', 'users', 'id')
                  ->create();
    }
}
