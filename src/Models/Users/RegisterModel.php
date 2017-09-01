<?php 

namespace App\Models\Users;

use App\Models\BaseModel;

class RegisterModel extends BaseModel
{
    protected $table = 'registers';
    protected $column = ['user_id', 'token', 'expired_date'];

    public function setToken($id, $token)
    {
        $data = [
            'user_id' => $id,
            'token' => $token,
            'expired_date' => date('Y-m-d H:i:s', strtotime('+1 day'))
        ];

            $this->createData($data);

            return $this->db->lastInsertId();
    }


    public function update(array $data, $column, $value)
    {
        $columns = [];
        $paramData = [];
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table);
        foreach ($data as $key => $values) {
            $columns[$key] = ':'.$key;
            $paramData[$key] = $values;
            $qb->set($key, $columns[$key]);
        }
        $qb->where( $column.'='. $value)
           ->setParameters($paramData)
           ->execute();
    }

    public function delete($columnId, $id)
    {
        $param = ':'.$columnId;

        $qb = $this->db->createQueryBuilder();
        $qb->delete($this->table)
           ->where($columnId.' = '. $param)
           ->setParameter($param, $id)
           ->execute();
    }

}

