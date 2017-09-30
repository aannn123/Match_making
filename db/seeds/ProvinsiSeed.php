
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
            'nama' => 'DKI Jakarta',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Bali',
        ];

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
            'nama' => 'DIY Jogyakarta',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Aceh',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Papua',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Lampung',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Banten',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Riau',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Kalimantan Timur',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Sumatera Utara',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Nusa Tenggara Timur',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Nusa Tenggara Barat',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Maluku',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Kepulauan Riau',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Sulawesi Tengah',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Sumatera Barat',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Sumatera Selatan',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Kalimantan Barat',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Kalimantan Selatan',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Jambi',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Sulawesi Utara',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Kalimantan Tengah',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Bengkulu',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Kepulauan Bangka Belitung',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Papua Barat',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Sulawesi Tenggara',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Gorontalo',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Sulawesi Barat',
        ];

        $data[] = [
            'id_negara' => 1,
            'nama' => 'Maluku Utara',
        ];




        $this->insert('provinsi', $data);

    }
}
