<?php 

namespace App\Models;

class KotaModel extends BaseModel
{
    // property kota model
    protected $table = 'kota';
    protected $column = ['id', 'id_provinsi', 'nama'];

    // Function create data model
    public function createKota(array $data)
    {
        $data = [
            'id_provinsi' => $data['id_provinsi'],
            'nama'        => $data['nama']   
        ];

        $this->createData($data);
        return $this->db->lastInsertId();
    }

    // Function update data model
    public function updateKota(array $data, $id)
    {
        $data = [
            'id_provinsi' => $data['id_provinsi'],
            'nama'        => $data['nama']
        ];

        $this->updateData($data, $id);
        return $this->db->lastInsertId();

    }

    public function getAllKota()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            ->from($this->table);
        $query = $qb->execute();
        return $this;
    }

    public function findAllkota()
    {
        $qb = $this->db->createQueryBuilder();

        $this->query = $qb->select('users.*')
             ->from('users', 'users')
             ->join('users', $this->table, 'guard', 'users.id = guard.user_id')
             ->where('guard.guard_id = :id')
             ->setParameter(':id', $guardId);

             // $result = $qb->execute();
            return $this;

    }
}