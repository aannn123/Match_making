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
                  ->addColumn('pendidikan', 'enum', ['values' => ['sd', 'smp', 'sma', 'diploma 1', 'diploma 3', 'diploma 4', 'strata 1', 'magister', 'doktor']])
                  ->addColumn('penjelasan_pendidikan', 'text')
                  ->addColumn('agama', 'enum', ['values' => ['ngaji sunnah', 'sedang hijrah', 'islam biasa']])
                  ->addColumn('penjelasan_agama', 'text')
                  ->addColumn('muallaf', 'boolean')
                  ->addColumn('baca_quran', 'enum', ['values' => ['setiap hari', 'minimal seminggu sekali', 'minimal sebulan sekali', 'sedang belajar']])
                  ->addColumn('hafalan', 'enum', ['values' => ['surat-surat pendek', '1-3 juz', '3-10 juz', '10-20 juz', '30 juz']])
                  ->addColumn('keluarga', 'enum', ['values' => ['sudah paham sunnah', 'sedang proses hijrah', 'islam biasa']])
                  ->addColumn('penjelasan_keluarga', 'text')
                  ->addColumn('shalat', 'enum', ['values' => ['5 waktu di masjid', '5 waktu tidak di masjid', 'belum 5 waktu', 'belum shalat']])
                  ->addColumn('update_at', 'datetime')
                  ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                  ->addIndex('user_id', ['unique' => true])
                  ->addForeignKey('user_id', 'users', 'id')
                  ->create();
    }
}
