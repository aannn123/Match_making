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
         $data[] = [
            'id_provinsi' => 1,
            'nama' => 'Bandung',
        ];

        $data[] = [
            'id_provinsi' => 2,
            'nama' => 'Surabaya',
        ];

        $data[] = [
            'id_provinsi' => 3,
            'nama' => 'Wonogiri',
        ];

        $data[] = [
            'id_provinsi' => 4,
            'nama' => 'Palu',
        ];

        $data[] = [
            'id_provinsi' => 5,
            'nama' => 'Jakarta',
        ];

        $data[] = [
            'id_provinsi' => 6,
            'nama' => 'Kota gede',
        ];

         $data[] = [
            'id_provinsi' => 1,
            'nama' => 'Bekasi',
        ];
        $this->insert('kota', $data);

    }
}
