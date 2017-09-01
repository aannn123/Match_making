<?php

use Phinx\Seed\AbstractSeed;

class ProvinsiSeed extends AbstractSeed
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
            'id_negara' => 1,
            'nama' => 'Jawa Barat',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Jawa Timur',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Jawa Tengah',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Sulawesi',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'DKI Jakarta',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'DIY Jogyakarta',
        ];

        $this->insert('provinsi', $data);

    }
}
