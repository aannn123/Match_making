<?php

use Phinx\Seed\AbstractSeed;

class CiriFisikSeed extends AbstractSeed
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
            'tinggi'        => '170',
            'berat'         => '56',
            'warna_kulit'   => 'putih',
            'suku'          => 'sunda',
            'jenggot'       => 'pendek',
            'kaca_mata'     => 'ya',
            'status_kesehatan'  => 'sehat',
            'ciri_fisik_lain'  => 'sehat',
        ];

         $data[] = [
            'user_id'       => '4',
            'tinggi'        => '170',
            'berat'         => '56',
            'warna_kulit'   => 'putih',
            'suku'          => 'sunda',
            'jenggot'       => 'pendek',
            'kaca_mata'     => 'ya',
            'status_kesehatan'  => 'sehat',
            'ciri_fisik_lain'  => 'sehat',
        ];

         $data[] = [
            'user_id'       => '5',
            'tinggi'        => '170',
            'berat'         => '56',
            'warna_kulit'   => 'putih',
            'suku'          => 'sunda',
            'jenggot'       => 'pendek',
            'kaca_mata'     => 'ya',
            'status_kesehatan'  => 'sehat',
            'ciri_fisik_lain'  => 'sehat',
        ];

        $data[] = [
            'user_id'       => '6',
            'tinggi'        => '170',
            'berat'         => '56',
            'warna_kulit'   => 'putih',
            'suku'          => 'sunda',
            'jenggot'       => 'pendek',
            'kaca_mata'     => 'ya',
            'status_kesehatan'  => 'sehat',
            'ciri_fisik_lain'  => 'sehat',
        ];

         $data[] = [
            'user_id'       => '7',
            'tinggi'        => '170',
            'berat'         => '56',
            'warna_kulit'   => 'putih',
            'suku'          => 'sunda',
            'hijab'       => 'sedang',
            'cadar'       => 'tidak',
            'kaca_mata'     => 'ya',
            'status_kesehatan'  => 'sehat',
            'ciri_fisik_lain'  => 'sehat',
        ];

         $data[] = [
            'user_id'       => '8',
            'tinggi'        => '170',
            'berat'         => '56',
            'warna_kulit'   => 'putih',
            'suku'          => 'sunda',
            'hijab'       => 'sedang',
            'cadar'       => 'tidak',
            'kaca_mata'     => 'ya',
            'status_kesehatan'  => 'sehat',
            'ciri_fisik_lain'  => 'sehat',
        ];

         $data[] = [
            'user_id'       => '9',
            'tinggi'        => '170',
            'berat'         => '56',
            'warna_kulit'   => 'putih',
            'suku'          => 'sunda',
            'hijab'       => 'sedang',
            'cadar'       => 'tidak',
            'kaca_mata'     => 'ya',
            'status_kesehatan'  => 'sehat',
            'ciri_fisik_lain'  => 'sehat',
        ];

         $data[] = [
            'user_id'       => '10',
            'tinggi'        => '170',
            'berat'         => '56',
            'warna_kulit'   => 'putih',
            'suku'          => 'sunda',
            'hijab'       => 'sedang',
            'cadar'       => 'tidak',
            'kaca_mata'     => 'ya',
            'status_kesehatan'  => 'sehat',
            'ciri_fisik_lain'  => 'sehat',
        ];

        $this->insert('ciri-fisik', $data);

    }
}
