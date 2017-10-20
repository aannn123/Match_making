<?php 

namespace App\Models\Users;

use App\Models\BaseModel;

class RequestModel extends BaseModel
{
    protected $table = 'request_taaruf';
    protected $column = ['id', 'id_perequest', 'id_terequest', 'status', 'blokir', 'updated_at', 'created_at'];

    public function createRequest(array $data, $date)
    {
        $data = [
            'id_perequest'  =>  $data['id_perequest'],
            'id_terequest'   =>  $data['id_terequest'],
            'created_at' => date('Y-m-d H:i:s', strtotime('+30 minutes')),
        ];
        $this->createData($data);
        return $this->db->lastInsertId();
    }

    public function updateRequest(array $data, $id)
     {
        $data = [
            'id_perequest'  =>   $data['id_perequest'],
            'id_terequest'   =>  $data['id_terequest'],
            'created_at' => date('Y-m-d H:i:s', strtotime('+30 minutes')),
        ];
        $this->update($data, 'id_perequest', $data['id_perequest']);
        return $this->db->lastInsertId();
    }

    public function sendRequest($id, $user)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('status', 1)
        ->where('id_perequest = ' . $id)
        ->andWhere('id_terequest = '. $user)
        ->execute();
    }

    public function sendRequestTwo($id, $user)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('blokir', 0)
        ->where('id_perequest = ' . $id)
        ->andWhere('id_terequest = '. $user)
        ->execute();
    }

     public function sendRequestThree($id, $user)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('blokir', 0)
        ->set('status', 1)
        ->where('id_perequest = ' . $id)
        ->andWhere('id_terequest = '. $user)
        ->execute();
    }

     //HardDelete
    public function deleteNotification($id)
    {
        $qb = $this->db->createQueryBuilder();

        $qb->update($this->table)
            ->set('blokir', 3)
            ->where('status = 1')
            ->andWhere('blokir = 1')
            ->orWhere('status = 2')
            ->orWhere('blokir = 2')
            ->andWhere('id_terequest = ' . $id)
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

    public function approveUser($id, $user)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('status', 2)
        ->where('id_perequest = ' . $id)
        ->andWhere('id_terequest = '. $user)
        ->execute();
    }

    public function blokirUser($id, $user)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('blokir', 1)
        ->where('id_perequest = ' . $id)
        ->andWhere('id_terequest = '. $user)
        ->execute();
    }

    public function cancelRequest($id)
    {
        $qb = $this->db->createQueryBuilder();

        $qb->delete($this->table)
            ->where('id = ' . $id)
            // ->andWhere('id_perequest = '. $user)
            ->execute();
    }

    // public function allNotification($id)
    // {
    //     $qb = $this->db->createQueryBuilder();
    //     $this->query = $qb->select('*')
    //         ->from($this->table)
    //         ->where('status = 1 && blokir = 0 && id_terequest = '. $id)
    //         ->orderBy('created_at', 'desc');
    //     $query = $qb->execute();
    //     return $this;
    // }

    public function allNotification($id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('req.id', 'id_perequest', 'prof.nama_lengkap as perequest', 'id_terequest', 'req.status as request_status', 'req.blokir as request_blokir', 'req.created_at', 'req.updated_at')
            ->from($this->table,'req')
            ->join('req','profil', 'prof', 'req.id_perequest = prof.user_id')
            // ->join('req','users', 'user1', 'req.id_terequest = user1.id')
            ->where('req.status = 1')
            ->andWhere(' req.blokir = 0')
            ->andWhere('id_terequest = '. $id);

        $query = $qb->execute()->fetch();
        return $this;
    }

    public function getAllNotification($id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('req.id', 'id_perequest', 'user.nama_lengkap as perequest', 'user1.nama_lengkap as terequest', 'id_terequest', 'req.status as request_status', 'req.blokir as request_blokir', 'req.created_at', 'req.updated_at')
            ->from($this->table,'req')
            ->join('req','profil', 'user', 'req.id_perequest = user.user_id')
            ->join('req','profil', 'user1', 'req.id_terequest = user1.user_id')
            ->where('req.status = 1')
            ->andWhere('req.blokir = 0');

        $query = $qb->execute()->fetch();
        return $this;
    }

    public function getTaarufUser($id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('req.id', 'id_terequest', 'id_perequest' , 'prof.nama_lengkap as terequest','prof1.nama_lengkap as perequest', 'id_terequest', 'req.status as request_status', 'req.blokir as request_blokir', 'req.created_at', 'req.updated_at')
            ->from($this->table,'req')
            ->join('req','profil', 'prof', 'req.id_terequest = prof.user_id')
            ->join('req','profil', 'prof1', 'req.id_perequest = prof1.user_id')
            ->where('req.status = 2')
            ->andWhere('req.blokir = 0')
            ->andWhere('(req.id_terequest = '.$id.' or req.id_perequest = '.$id.') and (req.id_terequest = '.$id.' or req.id_perequest = '.$id.'    )' );
            // ->andWhere('req.id_terequest ='. $id)
            // ->orWhere('req.id_perequest ='. $id);

        $query = $qb->execute()->fetch();
        return $this;
    }

    public function getAllRequestReject($id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('req.id', 'id_perequest', 'id_terequest', 'user.nama_lengkap as perequest', 'user1.nama_lengkap as terequest', 'id_terequest', 'req.status as request_status', 'req.blokir as request_blokir', 'req.created_at', 'req.updated_at')
            ->from($this->table,'req')
            ->join('req','profil', 'user', 'req.id_perequest = user.user_id')
            ->join('req','profil', 'user1', 'req.id_terequest = user1.user_id')
            ->where('req.blokir = 1')
            ->andWhere('id_perequest = '. $id);

        $query = $qb->execute()->fetch();
        return $this;
    }

    // public function getAllRequest($id)
    // {
    //     $qb = $this->db->createQueryBuilder();
    //     $this->query = $qb->select('*')
    //         ->from($this->table)
    //         ->where('status = 1 && id_perequest = '. $id)
    //         ->orderBy('created_at', 'desc');
    //     $query = $qb->execute();
    //     return $this;
    // }

      public function getAllRequest($id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('req.id', 'id_terequest', 'id_perequest' , 'prof.nama_lengkap as terequest','prof1.nama_lengkap as perequest', 'id_terequest', 'req.status as request_status', 'req.blokir as request_blokir', 'req.created_at', 'req.updated_at')
            ->from($this->table,'req')
            ->join('req','profil', 'prof', 'req.id_terequest = prof.user_id')
            ->join('req','profil', 'prof1', 'req.id_perequest = prof1.user_id')
            ->where('req.blokir = 0')
            ->andWhere('req.status = 1 && id_perequest = '. $id);

        $query = $qb->execute()->fetch();
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

     public function getAllBlokirRequest()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('req.id', 'id_terequest', 'id_perequest', 'user.nama_lengkap as perequest', 'user1.nama_lengkap as terequest', 'req.status as request_status', 'req.blokir as request_blokir', 'req.created_at', 'req.updated_at')
            ->from($this->table,'req')
            ->join('req','profil', 'user', 'req.id_perequest = user.user_id')
            ->join('req','profil', 'user1', 'req.id_terequest = user1.user_id')
            ->where('req.status = 1')
            ->andWhere('req.blokir = 1');
        $query = $qb->execute()->fetch();
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


    public function findRequestMe($id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('id', 'id_perequest', 'id_terequest', 'status', 'blokir', 'updated_at', 'created_at')
            ->from($this->table)
            ->where('id_perequest ='. $id)
            ->orWhere('id_terequest ='. $id)
            // ->whereNotIn('role = 1')
            ->orderBy('created_at', 'desc');
        $query = $qb->execute();
        
        return $this;
    }

    public function getRequestTwo()
    {
        $param = ':'.$column;

        $qb = $this->db->createQueryBuilder();
        $qb->select('id', 'id_perequest', 'id_terequest', 'status', 'blokir', 'updated_at', 'created_at')
        ->from($this->table)
        ->where('status = 2');
        // ->setParameter($param, $val);

        $query = $qb->execute();
        return $query->fetch();
    }

    public function joinRequest()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('req.id', 'user.nama_lengkap as perequest', 'user1.nama_lengkap as terequest', 'req.status as request_status', 'req.blokir as request_blokir', 'req.created_at', 'req.updated_at')
            ->from($this->table,'req')
            ->join('req','profil', 'user', 'req.id_perequest = user.user_id')
            ->join('req','profil', 'user1', 'req.id_terequest = user1.user_id')
            ->where('req.status = 2')
            ->andWhere('req.blokir = 0');
        $query = $qb->execute()->fetch();
        return $this;
    }

    public function joinRequestAll()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('req.id', 'req.id_perequest', 'req.id_terequest', 'user.username as perequest', 'user1.username as terequest', 'req.status as request_status', 'req.blokir', 'req.created_at', 'req.updated_at')
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
            ->where('id_perequest = :id_perequest' .'&&'. 'id_terequest = :id_terequest');
        $result = $qb->execute();
        return $result->fetchAll();
    }
}
