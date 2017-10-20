<?php

use Phinx\Migration\AbstractMigration;

class CreateKeseharianTable extends AbstractMigration
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
        $keseharian = $this->table('keseharian');
            $keseharian->addColumn('user_id', 'integer')
                 ->addColumn('pekerjaan', 'string')
                 ->addColumn('merokok', 'string')
                 ->addColumn('status_pekerjaan', 'string')
                 ->addColumn('penghasilan_per_bulan', 'string')
                 ->addColumn('status', 'string')
                 ->addColumn('jumlah_anak', 'integer')
                 ->addColumn('status_tinggal', 'string')
                 ->addColumn('memiliki_cicilan', 'string')
                 ->addColumn('bersedia_pindah_tinggal', 'string')
                 ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP','update' => 'CURRENT_TIMESTAMP'])
                 ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                 ->addIndex('user_id', ['unique' => true])
                 ->addForeignKey('user_id', 'users', 'id')
                 ->create();
    }
}
