<?php

use Phinx\Seed\AbstractSeed;

class ProfilSeed extends AbstractSeed
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
            'nama_lengkap'        => 'Farhan Mustaqiem',
            'tanggal_lahir'         => '2001-01-26',
            'tempat_lahir'   => 'Bekasi',
            'alamat'          => 'Bekasi',
            'umur'       => '16',
            'kota'       => '32',
            'provinsi'     => '1',
            'kewarganegaraan'  => '1',
            'target_menikah'  => '1025-10-01',
            'tentang_saya'  => 'Baik',
            'pasangan_harapan'  => 'Cantik',
        ];

         $data[] = [
            'user_id'       => '4',
            'nama_lengkap'        => 'Yazid',
            'tanggal_lahir'         => '2001-01-26',
            'tempat_lahir'   => 'Bekasi',
            'alamat'          => 'Bekasi',
            'umur'       => '16',
            'kota'       => '32',
            'provinsi'     => '1',
            'kewarganegaraan'  => '1',
            'target_menikah'  => '1025-10-01',
            'tentang_saya'  => 'Baik',
            'pasangan_harapan'  => 'Cantik',
        ];

         $data[] = [
            'user_id'       => '5',
            'nama_lengkap'        => 'Farhan Mustaqiem',
            'tanggal_lahir'         => '2001-01-26',
            'tempat_lahir'   => 'Bekasi',
            'alamat'          => 'Bekasi',
            'umur'       => '16',
            'kota'       => '32',
            'provinsi'     => '1',
            'kewarganegaraan'  => '1',
            'target_menikah'  => '1025-10-01',
            'tentang_saya'  => 'Baik',
            'pasangan_harapan'  => 'Cantik',
        ];

         $data[] = [
            'user_id'       => '6',
            'nama_lengkap'        => 'Yazid',
            'tanggal_lahir'         => '2001-01-26',
            'tempat_lahir'   => 'Bekasi',
            'alamat'          => 'Bekasi',
            'umur'       => '16',
            'kota'       => '32',
            'provinsi'     => '1',
            'kewarganegaraan'  => '1',
            'target_menikah'  => '1025-10-01',
            'tentang_saya'  => 'Baik',
            'pasangan_harapan'  => 'Cantik',
        ];

         $data[] = [
            'user_id'       => '7',
            'nama_lengkap'        => 'Alya',
            'tanggal_lahir'         => '2001-01-26',
            'tempat_lahir'   => 'Bekasi',
            'alamat'          => 'Bekasi',
            'umur'       => '16',
            'kota'       => '32',
            'provinsi'     => '1',
            'kewarganegaraan'  => '1',
            'target_menikah'  => '1025-10-01',
            'tentang_saya'  => 'Baik',
            'pasangan_harapan'  => 'Ganteng',
        ];

         $data[] = [
            'user_id'       => '8',
            'nama_lengkap'        => 'Nadia',
            'tanggal_lahir'         => '2001-01-26',
            'tempat_lahir'   => 'Bekasi',
            'alamat'          => 'Bekasi',
            'umur'       => '16',
            'kota'       => '32',
            'provinsi'     => '1',
            'kewarganegaraan'  => '1',
            'target_menikah'  => '1025-10-01',
            'tentang_saya'  => 'Baik',
            'pasangan_harapan'  => 'Ganteng',
        ];

         $data[] = [
            'user_id'       => '9',
            'nama_lengkap'        => 'Alya ya',
            'tanggal_lahir'         => '2001-01-26',
            'tempat_lahir'   => 'Bekasi',
            'alamat'          => 'Bekasi',
            'umur'       => '16',
            'kota'       => '32',
            'provinsi'     => '1',
            'kewarganegaraan'  => '1',
            'target_menikah'  => '1025-10-01',
            'tentang_saya'  => 'Baik',
            'pasangan_harapan'  => 'Ganteng',
        ];

         $data[] = [
            'user_id'       => '10',
            'nama_lengkap'        => 'Nadia ya',
            'tanggal_lahir'         => '2001-01-26',
            'tempat_lahir'   => 'Bekasi',
            'alamat'          => 'Bekasi',
            'umur'       => '16',
            'kota'       => '32',
            'provinsi'     => '1',
            'kewarganegaraan'  => '1',
            'target_menikah'  => '1025-10-01',
            'tentang_saya'  => 'Baik',
            'pasangan_harapan'  => 'Ganteng',
        ];

        $this->insert('profil', $data);

    }
}
