<?php 

namespace App\Models\Users;

use App\Models\BaseModel;

class LatarBelakangModel extends BaseModel
{
    protected $table = 'latar_belakang';
    protected $column = ['id', 'user_id', 'pendidikan', 'penjelasan_pendidikan', 'agama', 'penjelasan_agama', 'muallaf', 'baca_quran', 'hafalan', 'keluarga', 'penjelasan_keluarga', 'shalat', 'create_at', 'updated_at'];

    public function createLatar(array $data, $id)
    {
        $data = [
            'user_id'               => $id,
            'pendidikan'            => $data['pendidikan'],
            'penjelasan_pendidikan' => $data['penjelasan_pendidikan'],
            'agama'                 => $data['agama'],
            'penjelasan_agama'      => $data['penjelasan_agama'],
            'muallaf'               => $data['muallaf'],
            'baca_quran'            => $data['baca_quran'],
            'hafalan'               => $data['hafalan'],
            'keluarga'              => $data['keluarga'],
            'penjelasan_keluarga'   => $data['penjelasan_keluarga'],
            'shalat'                => $data['shalat']
        ];

        $this->createData($data);
        return $this->db->lastInsertId();
    }

    public function updateLatar(array $data, $id)
    {
         $data = [
            'user_id'               => $data['user_id'],
            'pendidikan'            => $data['pendidikan'],
            'penjelasan_pendidikan' => $data['penjelasan_pendidikan'],
            'agama'                 => $data['agama'],
            'penjelasan_agama'      => $data['penjelasan_agama'],
            'muallaf'               => $data['muallaf'],
            'baca_quran'            => $data['baca_quran'],
            'hafalan'               => $data['hafalan'],
            'keluarga'              => $data['keluarga'],
            'penjelasan_keluarga'   => $data['penjelasan_keluarga'],
            'shalat'                => $data['shalat']
        ];

        $this->update($data, 'user_id', $data['user_id']);
        return $this->db->lastInsertId();
    }

}