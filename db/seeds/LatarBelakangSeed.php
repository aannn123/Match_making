<?php

use Phinx\Seed\AbstractSeed;

class LatarBelakangSeed extends AbstractSeed
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
            'pendidikan'        => 'magister',
            'penjelasan_pendidikan'         => 'bagus',
            'agama'   => 'ngaji sunnah',
            'penjelasan_agama'          => 'bagsu',
            'muallaf'       => 'tidak',
            'baca_quran'       => 'setiap hari',
            'hafalan'     => '1-3 juz',
            'keluarga'  => 'sedang proses hijrah',
            'penjelasan_keluarga'  => 'baik',
            'shalat'  => '5 waktu di masjid',
        ];

         $data[] = [
            'user_id'       => '4',
            'pendidikan'        => 'magister',
            'penjelasan_pendidikan'         => 'bagus',
            'agama'   => 'ngaji sunnah',
            'penjelasan_agama'          => 'bagsu',
            'muallaf'       => 'tidak',
            'baca_quran'       => 'setiap hari',
            'hafalan'     => '1-3 juz',
            'keluarga'  => 'sedang proses hijrah',
            'penjelasan_keluarga'  => 'baik',
            'shalat'  => '5 waktu di masjid',
        ];

         $data[] = [
            'user_id'       => '5',
            'pendidikan'        => 'magister',
            'penjelasan_pendidikan'         => 'bagus',
            'agama'   => 'ngaji sunnah',
            'penjelasan_agama'          => 'bagsu',
            'muallaf'       => 'tidak',
            'baca_quran'       => 'setiap hari',
            'hafalan'     => '1-3 juz',
            'keluarga'  => 'sedang proses hijrah',
            'penjelasan_keluarga'  => 'baik',
            'shalat'  => '5 waktu di masjid',
        ];

         $data[] = [
            'user_id'       => '6',
            'pendidikan'        => 'magister',
            'penjelasan_pendidikan'         => 'bagus',
            'agama'   => 'ngaji sunnah',
            'penjelasan_agama'          => 'bagsu',
            'muallaf'       => 'tidak',
            'baca_quran'       => 'setiap hari',
            'hafalan'     => '1-3 juz',
            'keluarga'  => 'sedang proses hijrah',
            'penjelasan_keluarga'  => 'baik',
            'shalat'  => '5 waktu di masjid',
        ];

         $data[] = [
            'user_id'       => '7',
            'pendidikan'        => 'magister',
            'penjelasan_pendidikan'         => 'bagus',
            'agama'   => 'ngaji sunnah',
            'penjelasan_agama'          => 'bagsu',
            'muallaf'       => 'tidak',
            'baca_quran'       => 'setiap hari',
            'hafalan'     => '1-3 juz',
            'keluarga'  => 'sedang proses hijrah',
            'penjelasan_keluarga'  => 'baik',
            'shalat'  => '5 waktu di masjid',
        ];

         $data[] = [
            'user_id'       => '8',
            'pendidikan'        => 'magister',
            'penjelasan_pendidikan'         => 'bagus',
            'agama'   => 'ngaji sunnah',
            'penjelasan_agama'          => 'bagsu',
            'muallaf'       => 'tidak',
            'baca_quran'       => 'setiap hari',
            'hafalan'     => '1-3 juz',
            'keluarga'  => 'sedang proses hijrah',
            'penjelasan_keluarga'  => 'baik',
            'shalat'  => '5 waktu di masjid',
        ];

         $data[] = [
            'user_id'       => '9',
            'pendidikan'        => 'magister',
            'penjelasan_pendidikan'         => 'bagus',
            'agama'   => 'ngaji sunnah',
            'penjelasan_agama'          => 'bagsu',
            'muallaf'       => 'tidak',
            'baca_quran'       => 'setiap hari',
            'hafalan'     => '1-3 juz',
            'keluarga'  => 'sedang proses hijrah',
            'penjelasan_keluarga'  => 'baik',
            'shalat'  => '5 waktu di masjid',
        ];

         $data[] = [
            'user_id'       => '10',
            'pendidikan'        => 'magister',
            'penjelasan_pendidikan'         => 'bagus',
            'agama'   => 'ngaji sunnah',
            'penjelasan_agama'          => 'bagsu',
            'muallaf'       => 'tidak',
            'baca_quran'       => 'setiap hari',
            'hafalan'     => '1-3 juz',
            'keluarga'  => 'sedang proses hijrah',
            'penjelasan_keluarga'  => 'baik',
            'shalat'  => '5 waktu di masjid',
        ];

        $this->insert('latar-belakang', $data);

    }
}
