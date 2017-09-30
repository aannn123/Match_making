<?php 

namespace App\Models;

class ProvinsiModel extends BaseModel
{
    protected $table = 'provinsi';
    protected $column = ['id', 'id_negara', 'nama'];

    // Method create data model
    public function createProvinsi(array $data)
    {
        $data = [
            'id_negara' => $data['id_negara'],
            'nama'  =>  $data['nama'],
        ];

        $this->createData($data);
        return $this->db->lastInsertId();
    }

     // Method update data model
    public function updateProvinsi(array $data, $id)
    {
        $data = [
            'id_negara' => $data['id_negara'],
            'nama'  =>  $data['nama'],
        ];

        $this->updateData($data, $id);
        return $this->db->lastInsertId();
    }

    public function select($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('id_negara')
           ->from($this->table)
           ->where('id_negara ='.$id )
           ->execute();
    }

    public function getAllProvinsi()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            ->from($this->table);
        $query = $qb->execute();
        return $this;
    }

    public function joinProvinsi()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('prov.id', 'negara.nama as negara','prov.nama')
            ->from($this->table,'prov')
            ->join('prov','negara', 'negara', 'prov.id_negara = negara.id');
            // ->join('prof','provinsi', 'prov', 'prov.id = prof.provinsi')
            // ->join('prof','negara', 'negara', 'negara.id = prof.kewarganegaraan');
        $query = $qb->execute();
        return $this;
    }


}
