<?php

use Phinx\Seed\AbstractSeed;

class NegaraSeed extends AbstractSeed
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
            'nama' => 'Indonesia',
        ];

         $data[] = [
            'nama' => 'Malaysia',
        ];

         $data[] = [
            'nama' => 'Arab',
        ];

         $data[] = [
            'nama' => 'Amerka',
        ];

         $data[] = [
            'nama' => 'Inggris',
        ];

         $data[] = [
            'nama' => 'German',
        ];

         $data[] = [
            'nama' => 'Jepang',
        ];

         $data[] = [
            'nama' => 'Korea',
        ];

         $data[] = [
            'nama' => 'Belanda',
        ];

        $this->insert('negara', $data);

    }
}
