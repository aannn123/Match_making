<?php

use Phinx\Seed\AbstractSeed;

class KeseharianSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
         $data[] = [
            'user_id'       => '3',
            'pekerjaan'        => 'belum bekerja',
            'merokok'         => 'tidak',
            'status_pekerjaan'   => 'pelajar/mahasiswa',
            'penghasilan_per_bulan'          => 'tidak bekerja',
            'status'       => 'belum menikah',
            'jumlah_anak'       => '0',
            'status_tinggal'     => 'rumah sendiri',
            'bersedia_pindah_tinggal'  => 'ya',
            'memiliki_cicilan'  => 'tidak',
        ];

        $data[] = [
            'user_id'       => '4',
            'pekerjaan'        => 'belum bekerja',
            'merokok'         => 'tidak',
            'status_pekerjaan'   => 'pelajar/mahasiswa',
            'penghasilan_per_bulan'          => 'tidak bekerja',
            'status'       => 'belum menikah',
            'jumlah_anak'       => '0',
            'status_tinggal'     => 'rumah sendiri',
            'bersedia_pindah_tinggal'  => 'ya',
            'memiliki_cicilan'  => 'tidak',
        ];

        $data[] = [
            'user_id'       => '5',
            'pekerjaan'        => 'belum bekerja',
            'merokok'         => 'tidak',
            'status_pekerjaan'   => 'pelajar/mahasiswa',
            'penghasilan_per_bulan'          => 'tidak bekerja',
            'status'       => 'belum menikah',
            'jumlah_anak'       => '0',
            'status_tinggal'     => 'rumah sendiri',
            'bersedia_pindah_tinggal'  => 'ya',
            'memiliki_cicilan'  => 'tidak',
        ];

        $data[] = [
            'user_id'       => '6',
            'pekerjaan'        => 'belum bekerja',
            'merokok'         => 'tidak',
            'status_pekerjaan'   => 'pelajar/mahasiswa',
            'penghasilan_per_bulan'          => 'tidak bekerja',
            'status'       => 'belum menikah',
            'jumlah_anak'       => '0',
            'status_tinggal'     => 'rumah sendiri',
            'bersedia_pindah_tinggal'  => 'ya',
            'memiliki_cicilan'  => 'tidak',
        ];

        $data[] = [
            'user_id'       => '7',
            'pekerjaan'        => 'belum bekerja',
            'merokok'         => 'tidak',
            'status_pekerjaan'   => 'pelajar/mahasiswa',
            'penghasilan_per_bulan'          => 'tidak bekerja',
            'status'       => 'belum menikah',
            'jumlah_anak'       => '0',
            'status_tinggal'     => 'rumah sendiri',
            'bersedia_pindah_tinggal'  => 'ya',
            'memiliki_cicilan'  => 'tidak',
        ];

        $data[] = [
            'user_id'       => '8',
            'pekerjaan'        => 'belum bekerja',
            'merokok'         => 'tidak',
            'status_pekerjaan'   => 'pelajar/mahasiswa',
            'penghasilan_per_bulan'          => 'tidak bekerja',
            'status'       => 'belum menikah',
            'jumlah_anak'       => '0',
            'status_tinggal'     => 'rumah sendiri',
            'bersedia_pindah_tinggal'  => 'ya',
            'memiliki_cicilan'  => 'tidak',
        ];

        $data[] = [
            'user_id'       => '9',
            'pekerjaan'        => 'belum bekerja',
            'merokok'         => 'tidak',
            'status_pekerjaan'   => 'pelajar/mahasiswa',
            'penghasilan_per_bulan'          => 'tidak bekerja',
            'status'       => 'belum menikah',
            'jumlah_anak'       => '0',
            'status_tinggal'     => 'rumah sendiri',
            'bersedia_pindah_tinggal'  => 'ya',
            'memiliki_cicilan'  => 'tidak',
        ];

        $data[] = [
            'user_id'       => '10',
            'pekerjaan'        => 'belum bekerja',
            'merokok'         => 'tidak',
            'status_pekerjaan'   => 'pelajar/mahasiswa',
            'penghasilan_per_bulan'          => 'tidak bekerja',
            'status'       => 'belum menikah',
            'jumlah_anak'       => '0',
            'status_tinggal'     => 'rumah sendiri',
            'bersedia_pindah_tinggal'  => 'ya',
            'memiliki_cicilan'  => 'tidak',
        ];

        $this->insert('keseharian', $data);

    }
}
