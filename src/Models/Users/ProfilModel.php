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
    
    public function search($val, $id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
                 ->from($this->table)
                 ->where('nama_lengkap LIKE :val')
                 ->orWhere('umur LIKE :val')
                 // ->orWhere('kota LIKE :val')
                 ->andWhere('user_id != '. $id)
                 // ->andWhere('status != 1')
                 // ->andWhere('deleted = 0')
                 ->setParameter('val', '%'.$val.'%');

        $result = $this->query->execute();

        return $result->fetchAll();
    }

    public function joinSearch($val, $id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('prof.*','kot.nama as kota','prov.nama as provinsi','negara.nama as kewarganegaraan')
            ->from($this->table,'prof')
            ->join('prof','kota', 'kot', 'kot.id = prof.kota')
            ->join('prof','provinsi', 'prov', 'prov.id = prof.provinsi')
            ->join('prof','negara', 'negara', 'negara.id = prof.kewarganegaraan')
            ->where('umur LIKE :val')
                 ->orWhere('kot.nama LIKE :val')
                 ->orWhere('prov.nama LIKE :val')
                 ->orWhere('negara.nama LIKE :val')
                 ->andWhere('user_id != '. $id)
                 // ->andWhere('status != 1')
                 // ->andWhere('deleted = 0')
                 ->setParameter('val', '%'.$val.'%');
        // $query = $qb->execute();
                 $result = $this->query->execute();
        return $result->fetchAll();

    }

   public function joinProfile()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('prof.*','kot.nama as kota','prov.nama as provinsi','negara.nama as kewarganegaraan')
            ->from($this->table,'prof')
            ->join('prof','kota', 'kot', 'kot.id = prof.kota')
            ->join('prof','provinsi', 'prov', 'prov.id = prof.provinsi')
            ->join('prof','negara', 'negara', 'negara.id = prof.kewarganegaraan');
        $query = $qb->execute();
        return $this;
    }
}