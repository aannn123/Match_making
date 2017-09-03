<?php 

namespace App\Models\Users\Poligami;

use App\Models\BaseModel;


class DipoligamiModel extends BaseModel
{
    protected $table = 'dipoligami';
    protected $column = ['user_id', 'kesiapan', 'penjelasan_kesiapan', 'updated_at', 'created_at'];

    public function createPoligami(array $data, $id)
    {
        $data = [
            'user_id' => $id,
            'kesiapan' => $data['kesiapan'],
            'penjelasan_kesiapan' => $data['penjelasan_kesiapan'],
            'alasan_poligami' => $data['alasan_poligami'],
            'kondisi_istri' => $data['kondisi_istri'],
        ];
        
        $this->createData($data);
        return $this->db->lastInsertId();
    }

    public function updatePoligami(array $data, $id)
    {
        $data = [
            'user_id' => $data['user_id'],
            'kesiapan' => $data['kesiapan'],
            'penjelasan_kesiapan' => $data['penjelasan_kesiapan'],
            'alasan_poligami' => $data['alasan_poligami'],
            'kondisi_istri' => $data['kondisi_istri'],
        ];
        
        $this->update($data, 'user_id', $data['user_id']);
        return $this->db->lastInsertId();
    }
}