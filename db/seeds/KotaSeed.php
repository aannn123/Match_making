<?php

use Phinx\Seed\AbstractSeed;

class KotaSeed extends AbstractSeed
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
        // Provinsi Jakarta
         $data[] = [
            'id_provinsi' => 1,
            'nama' => 'Jakarta',
        ];

        // Provinsi Bali
        $data[] = [
            'id_provinsi' => 2,
            'nama' => 'Denpasar',
        ];

        $data[] = [
            'id_provinsi' => 2,
            'nama' => 'Singaraja',
        ];

        $data[] = [
            'id_provinsi' => 2,
            'nama' => 'Kuta, Badung',
        ];

        //  Provinsi Jawa Barat
        $data[] = [
            'id_provinsi' => 3,
            'nama' => 'Bekasi',
        ];

         $data[] = [
            'id_provinsi' => 3,
            'nama' => 'Bandung',
        ];

         $data[] = [
            'id_provinsi' => 3,
            'nama' => 'Bogor',
        ];

         $data[] = [
            'id_provinsi' => 3,
            'nama' => 'Depok',
        ];

         $data[] = [
            'id_provinsi' => 3,
            'nama' => 'Tasikmalaya',
        ];

        //  Provinsi Jawa Timur
        $data[] = [
            'id_provinsi' => 4,
            'nama' => 'Surabaya',
        ];

        $data[] = [
            'id_provinsi' => 4,
            'nama' => 'Malang',
        ];

        $data[] = [
            'id_provinsi' => 4,
            'nama' => 'Madiun',
        ];

        // Provinsi Jawa Tengah
        $data[] = [
            'id_provinsi' => 5,
            'nama' => 'Semarang',
        ];

         $data[] = [
            'id_provinsi' => 5,
            'nama' => 'Tegal',
        ];

         $data[] = [
            'id_provinsi' => 5,
            'nama' => 'Magelang',
        ];

        // Provinsi DIY Yogyakarta
        $data[] = [
            'id_provinsi' => 6,
            'nama' => 'Kota gede',
        ];

        $data[] = [
            'id_provinsi' => 6,
            'nama' => 'Wates',
        ];

        $data[] = [
            'id_provinsi' => 6,
            'nama' => 'Bantul',
        ];

        $data[] = [
            'id_provinsi' => 6,
            'nama' => 'Sleman',
        ];

        //  Provinsi Aceh
         $data[] = [
            'id_provinsi' => 7,
            'nama' => 'Banda Aceh',
        ];

        $data[] = [
            'id_provinsi' => 7,
            'nama' => 'Kota Sabang',
        ];

        $data[] = [
            'id_provinsi' => 7,
            'nama' => 'Kota Langsa',
        ];

        // Provinsi Papua
        $data[] = [
            'id_provinsi' => 8,
            'nama' => 'Jayapura',
        ];
        // Lampung
        $data[] = [
            'id_provinsi' => 9,
            'nama' => 'Pringsewu',
        ];
        // Banten
        $data[] = [
            'id_provinsi' => 10,
            'nama' => 'Serang',
        ];
        // Riau
        $data[] = [
            'id_provinsi' => 11,
            'nama' => 'Pekanbaru',
        ];
        // Kalimantan Timur
        $data[] = [
            'id_provinsi' => 12,
            'nama' => 'Samarinda',
        ];
        // Sumatera Utara
        $data[] = [
            'id_provinsi' => 13,
            'nama' => 'Medan',
        ];
        // Nusa Tenggara Timur
        $data[] = [
            'id_provinsi' => 14,
            'nama' => 'Kupang',
        ];
        // Nusa Tenggara Barat
        $data[] = [
            'id_provinsi' => 15,
            'nama' => 'Mataram',
        ];
        // Maluku
        $data[] = [
            'id_provinsi' => 16,
            'nama' => 'Kota',
        ];
        // Kepulauan Riau
        $data[] = [
            'id_provinsi' => 17,
            'nama' => 'Ambon',
        ];
        // Sulawesi Tengah
        $data[] = [
            'id_provinsi' => 18,
            'nama' => 'Batam',
        ];
        // Sumatera Barat
        $data[] = [
            'id_provinsi' => 19,
            'nama' => 'Padang',
        ];
        // Sumatera Selatan
        $data[] = [
            'id_provinsi' => 20,
            'nama' => 'Palembang',
        ];
        // Kalimantan Barat
        $data[] = [
            'id_provinsi' => 21,
            'nama' => 'Pontianak',
        ];
        // Kalimantan Selatan
        $data[] = [
            'id_provinsi' => 22,
            'nama' => 'Banjarmasin',
        ];
        // Jambi
        $data[] = [
            'id_provinsi' => 23,
            'nama' => 'Jambi',
        ];
        // Sulawesi Utara
        $data[] = [
            'id_provinsi' => 24,
            'nama' => 'Manado',
        ];
        // Kalimantan Tengah
        $data[] = [
            'id_provinsi' => 25,
            'nama' => 'Barito',
        ];
        // Bengkulu
        $data[] = [
            'id_provinsi' => 26,
            'nama' => 'Bengkulu',
        ];
        // Kepulauan Bangka Belitung
        $data[] = [
            'id_provinsi' => 27,
            'nama' => 'Pangkal Pinang',
        ];
        // Papua Barat
        $data[] = [
            'id_provinsi' => 28,
            'nama' => 'Kota Waisai,Raja Ampat',
        ];
        // Sulawesi Tenggara
        $data[] = [
            'id_provinsi' => 29,
            'nama' => 'Kendari',
        ];
        // Gorontalo
        $data[] = [
            'id_provinsi' => 30,
            'nama' => 'Gorontalo',
        ];
        // Sulawesi Barat
        $data[] = [
            'id_provinsi' => 31,
            'nama' => 'Makassar',
        ];
        // Maluku Utara
        $data[] = [
            'id_provinsi' => 31,
            'nama' => 'Ternate',
        ];
        $this->insert('kota', $data);

    }
}
