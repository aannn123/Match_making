<?php 

namespace App\Models\Users;

use App\Models\BaseModel;

class ProfilModel extends BaseModel
{
    protected $table  = 'profil';
    protected $column = ['user_id', 'nama_lengkap', 'tanggal_lahir', 'tempat_lahir', 'umur', 'alamat', 'kota', 'provinsi', 'kewarganegaraan', 'target_menikah', 'tentang_saya', 'pasangan_harapan', 'created_at', 'updated_at'];

    public function createProfil(array $data, $id)
    {
        $data = [
            'user_id'   => $id,
            'nama_lengkap' => $data['nama_lengkap'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'tempat_lahir'  => $data['tempat_lahir'],
            'umur'  => $data['umur'],
            'alamat'    => $data['alamat'],
            'kota'  => $data['kota'],
            'provinsi'  => $data['provinsi'],
            'kewarganegaraan'   => $data['kewarganegaraan'],
            'target_menikah'    => $data['target_menikah'],
            'tentang_saya'  => $data['tentang_saya'],
            'pasangan_harapan'  => $data['pasangan_harapan']
        ];

        $this->createData($data);
        return $this->db->lastInsertId();
    }

    public function updateProfil(array $data, $id)
    {
         $data = [
            'user_id'   => $data['user_id'],
            'nama_lengkap' => $data['nama_lengkap'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'tempat_lahir'  => $data['tempat_lahir'],
            'umur'  => $data['umur'],
            'alamat'    => $data['alamat'],
            'kota'  => $data['kota'],
            'provinsi'  => $data['provinsi'],
            'kewarganegaraan'   => $data['kewarganegaraan'],
            'target_menikah'    => $data['target_menikah'],
            'tentang_saya'  => $data['tentang_saya'],
            'pasangan_harapan'  => $data['pasangan_harapan']
        ];

        $this->update($data, 'user_id', $data['user_id']);
        return $this->db->lastInsertId();
    }

    public function getAllProfilUser()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            ->from($this->table);
        $query = $qb->execute();
        return $this;
    }
}