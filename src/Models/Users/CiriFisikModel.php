<?php 

namespace App\Models\Users;

use App\Models\BaseModel;

class CiriFisikModel extends BaseModel
{
    protected $table = 'ciri_fisik';
    protected $column = ['id', 'user_id', 'tinggi', 'berat', 'warna_kulit', 'suku', 'jenggot', 'hijab', 'cadar', 'kaca_mata', 'status_kesehatan', 'ciri_fisik_lain', 'updated_at', 'created_at'];

    public function createFisikPria(array $data, $id)
    {
        $data = [
            'user_id'           => $id,
            'tinggi'            => $data['tinggi'],
            'berat'             => $data['berat'],
            'warna_kulit'       => $data['warna_kulit'],
            'suku'              => $data['suku'],
            'jenggot'           => $data['jenggot'],
            'kaca_mata'         => $data['kaca_mata'],
            'status_kesehatan'  => $data['status_kesehatan'],
            'ciri_fisik_lain'   => $data['ciri_fisik_lain']
        ];

        $this->createData($data);
        return $this->db->lastInsertId();
    }

    public function createFisikWanita(array $data, $id)
    {
        $data = [
            'user_id'           => $id,
            'tinggi'            => $data['tinggi'],
            'berat'             => $data['berat'],
            'warna_kulit'       => $data['warna_kulit'],
            'suku'              => $data['suku'],
            'hijab'             => $data['hijab'],
            'cadar'             => $data['cadar'],
            'kaca_mata'          => $data['kaca_mata'],
            'status_kesehatan'  => $data['status_kesehatan'],
            'ciri_fisik_lain'   => $data['ciri_fisik_lain']
        ];

        $this->createData($data);
        return $this->db->lastInsertId();
    }

    public function updatePria(array $data, $id)
    {
         $data = [
            'user_id'           => $data['user_id'],
            'tinggi'            => $data['tinggi'],
            'berat'             => $data['berat'],
            'warna_kulit'       => $data['warna_kulit'],
            'suku'              => $data['suku'],
            'jenggot'           => $data['jenggot'],
            'kaca_mata'         => $data['kaca_mata'],
            'status_kesehatan'  => $data['status_kesehatan'],
            'ciri_fisik_lain'   => $data['ciri_fisik_lain']
        ];

        $this->update($data, 'user_id', $data['user_id']);
        return $this->db->lastInsertId();
    }

    public function updateWanita(array $data, $id)
    {
        $data = [
            'user_id'           => $data['user_id'],
            'tinggi'            => $data['tinggi'],
            'berat'             => $data['berat'],
            'warna_kulit'       => $data['warna_kulit'],
            'suku'              => $data['suku'],
            'hijab'             => $data['hijab'],
            'cadar'             => $data['cadar'],
            'kaca_mata'         => $data['kaca_mata'],
            'status_kesehatan'  => $data['status_kesehatan'],
            'ciri_fisik_lain'   => $data['ciri_fisik_lain']
        ];

        $this->update($data, 'user_id', $data['user_id']);
        return $this->db->lastInsertId();
    }
}
