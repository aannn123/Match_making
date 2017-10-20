<?php

use Phinx\Migration\AbstractMigration;

class CreateCiriFisikTable extends AbstractMigration
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
        $fisik = $this->table('ciri_fisik');
            $fisik->addColumn('user_id', 'integer')
                  ->addColumn('tinggi', 'string')
                  ->addColumn('berat', 'string')
                  ->addColumn('warna_kulit', 'string')
                  ->addColumn('suku', 'string')
                  ->addColumn('jenggot', 'string', ['null' => true])
                  ->addColumn('hijab', 'string', ['null' => true])
                  ->addColumn('cadar', 'string', ['null' => true])
                  ->addColumn('kaca_mata', 'string')
                  ->addColumn('status_kesehatan', 'string')
                  ->addColumn('ciri_fisik_lain', 'text')
                  ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP','update' => 'CURRENT_TIMESTAMP'])
                  ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                  ->addIndex('user_id', ['unique' => true])
                  ->addForeignKey('user_id', 'users', 'id')
                  ->create();
    }
}
