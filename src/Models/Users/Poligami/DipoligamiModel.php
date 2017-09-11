<?php 

namespace App\Models\Users\Poligami;

use App\Models\BaseModel;


class DipoligamiModel extends BaseModel
{
    protected $table = 'dipoligami';
    protected $column = ['user_id', 'kesiapan', 'penjelasan_kesiapan', 'updated_at', 'created_at'];

    public function createDiPoligami(array $data, $id)
    {
        $data = [
            'user_id' => $id,
            'kesiapan' => $data['kesiapan'],
            'penjelasan_kesiapan' => $data['penjelasan_kesiapan'],
        ];
        
        $this->createData($data);
        return $this->db->lastInsertId();
    }

    public function updateDiPoligami(array $data, $id)
    {
        $data = [
            'user_id' => $data['user_id'],
            'kesiapan' => $data['kesiapan'],
            'penjelasan_kesiapan' => $data['penjelasan_kesiapan'],
        ];
        
        $this->update($data, 'user_id', $data['user_id']);
        return $this->db->lastInsertId();
    }
}