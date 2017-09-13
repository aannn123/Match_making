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
                  ->addColumn('warna_kulit', 'enum', ['values' => ['sangat putih', 'putih', 'kuning langsat','kuning','sawo matang','coklat','gelap']])
                  ->addColumn('suku', 'string')
                  ->addColumn('jenggot', 'enum', ['values' => ['dicukur', 'tipis', 'sedang', 'panjang'], 'null' => true])
                  ->addColumn('hijab', 'enum', ['values' => ['sangat panjang', 'panjang', 'sedang', 'kecil', 'belum berhijab'], 'null' => true])
                  ->addColumn('cadar', 'enum', ['values' => ['ya', 'tidak', 'setelah menikah'], 'null' => true])
                  ->addColumn('kaca_mata', 'enum', ['values' => ['ya', 'tidak']])
                  ->addColumn('status_kesehatan', 'enum', ['values' => ['sehat', 'masalah kesehatan serius', 'cacat fisik ringan', 'cacat fisik serius']])
                  ->addColumn('ciri_fisik_lain', 'text')
                  ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP','update' => 'CURRENT_TIMESTAMP'])
                  ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                  ->addIndex('user_id', ['unique' => true])
                  ->addForeignKey('user_id', 'users', 'id')
                  ->create();
    }
}
