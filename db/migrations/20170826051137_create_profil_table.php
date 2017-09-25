<?php

use Phinx\Migration\AbstractMigration;

class CreateProfilTable extends AbstractMigration
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
        $profil = $this->table('profil');
        $profil->addColumn('user_id', 'integer')
               ->addColumn('nama_lengkap', 'string')
               ->addColumn('tanggal_lahir', 'date')
               ->addColumn('tempat_lahir', 'string')
               ->addColumn('alamat', 'text')
               ->addColumn('umur', 'integer')
               ->addColumn('kota', 'integer')
               ->addColumn('provinsi', 'integer')
               ->addColumn('kewarganegaraan', 'integer')
               ->addColumn('target_menikah', 'date')
               ->addColumn('tentang_saya', 'text')
               ->addColumn('pasangan_harapan', 'text')
               ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP','update' => 'CURRENT_TIMESTAMP'])
               ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
               ->addIndex('user_id', ['unique' => true])
               ->addForeignKey('user_id', 'users', 'id')
               ->addForeignKey('kota', 'kota', 'id')
               ->addForeignKey('provinsi', 'provinsi', 'id')
               ->addForeignKey('kewarganegaraan', 'negara', 'id')
               ->create();
    }
}
