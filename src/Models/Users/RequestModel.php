<?php 

namespace App\Models\Users;

use App\Models\BaseModel;

class RequestModel extends BaseModel
{
    protected $table = 'request_taaruf';
    protected $column = ['id', 'id_perequest', 'id_terequest', 'status', 'blokir', 'updated_at', 'created_at'];

    public function createRequest(array $data)
    {
        $data = [
            'id_perequest'  =>  $data['id_perequest'],
            'id_terequest'   =>  $data['id_terequest'],
        ];
        $this->createData($data);
        return $this->db->lastInsertId();
    }

    public function sendRequest($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('status', 1)
        ->where('id = ' . $id)
        ->execute();
    }

    public function approveUser($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('status', 2)
        ->where('id = ' . $id)
        ->execute();
    }

    public function blokirUser($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('blokir', 1)
        ->where('id = ' . $id)
        ->execute();
    }

    public function allNotification($id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            ->from($this->table)
            ->where('status = 1 && id_terequest = '. $id)
            ->orderBy('created_at', 'desc');
        $query = $qb->execute();
        return $this;
    }

    public function getAllRequest($id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            ->from($this->table)
            ->where('status = 1 && id_perequest = '. $id)
            ->orderBy('created_at', 'desc');
        $query = $qb->execute();
        return $this;
    }

    public function getRequest($column, $val)
    {
       $param = ':'.$column;

        $qb = $this->db->createQueryBuilder();
        $qb->select('id', 'id_perequest', 'id_terequest', 'status', 'blokir', 'updated_at', 'created_at')
        ->from($this->table)
        ->where($column.' = '. $param)
        ->setParameter($param, $val);

        $query = $qb->execute();
        return $query->fetch();
    }
}
