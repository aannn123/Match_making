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

    public function updateRequest(array $data)
    {
        $data = [
            'id_perequest'  =>  $data['id_perequest'],
            'id_terequest'   =>  $data['id_terequest'],
        ];
        $this->update($data, 'id_perequest', $data['id_perequest']);
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

    public function cancelTaaruf($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('blokir', 2)
        ->where('status = 2 && id =' . $id)
        ->execute();
    }

    public function approveUser($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('status', 2)
        ->where('id_perequest = ' . $id)
        ->execute();
    }

    public function blokirUser($id, $column)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('blokir', 1)
        ->where('id_perequest =' . $id)
        ->execute();
    }

    public function allNotification($id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            ->from($this->table)
            ->where('status = 1 && blokir = 0 && id_terequest = '. $id)
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

    public function getAllBlokir($id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            ->from($this->table)
            ->where('blokir = 1 && id_terequest = '. $id)
            ->orderBy('created_at', 'desc');
        $query = $qb->execute();
        return $this;
    }

    public function getTaaruf()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            ->from($this->table)
            ->where('status = 2 && blokir = 0')
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

    public function joinRequest()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('req.id', 'user.username as perequest', 'user1.username as terequest', 'req.status as request_status', 'req.blokir as request_blokir', 'req.created_at', 'req.updated_at')
            ->from($this->table,'req')
            ->join('req','users', 'user', 'req.id_perequest = user.id')
            ->join('req','users', 'user1', 'req.id_terequest = user1.id')
            ->where('req.status = 2 && req.blokir = 0');
        $query = $qb->execute()->fetch();
        return $this;
    }

    public function joinRequestAll()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('req.id', 'user.username as perequest', 'user1.username as terequest', 'req.status as request_status', 'req.blokir', 'req.created_at', 'req.updated_at')
            ->from($this->table,'req')
            ->join('req','users', 'user', 'req.id_perequest = user.id')
            ->join('req','users', 'user1', 'req.id_terequest = user1.id');
        $query = $qb->execute()->fetch();
        return $this;
    }

    public function findTwoRequest($column1, $val1, $column2, $val2)
    {
        $param1 = ':'.$column1;
        $param2 = ':'.$column2;
        $qb = $this->db->createQueryBuilder();
        $qb->select('req.id', 'user.username as perequest', 'user1.username as terequest', 'req.status as request_status', 'req.blokir', 'req.created_at', 'req.updated_at')
            ->from($this->table,'req')
            ->join('req','users', 'user', 'req.id_perequest = user.id')
            ->join('req','users', 'user1', 'req.id_terequest = user1.id')
            ->setParameter($param1, $val1)
            ->setParameter($param2, $val2)
            ->where('user.username = :perequest' .'&&'. 'user1.username = :terequest');
        $result = $qb->execute();
        return $result->fetchAll();
    }
}
