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
