<?php 

namespace App\Models;

class NegaraModel extends BaseModel
{
    protected $table = 'negara';
    protected $column = ['id', 'nama'];

    // Method create data model
    public function createNegara(array $data)
    {
        $data = [
            'nama'  =>  $data['nama'],
        ];

        $this->createData($data);
        return $this->db->lastInsertId();
    }

    // Method update data model
    public function updateNegara(array $data, $id)
    {
        $data = [
            'nama' => $data['nama']
        ];

        $this->updateData($data, $id);
        return $this->db->lastInsertId();
        
    }

    public function getAllNegara()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            ->from($this->table);
        $query = $qb->execute();
        return $this;
    }
}