<?php

namespace App\Models\Users;

use App\Models\BaseModel;

class UserToken extends BaseModel
{
    protected $table = 'tokens';
    protected $column = ['user_id', 'token', 'login_at', 'expired_date'];

    public function setToken($id)
    {
        $data = [
            'user_id' => $id,
            'token' => md5(openssl_random_pseudo_bytes(8)),
            'login_at' => date('Y-m-d H:i:s'),
            'expired_date' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ];

        $findUserId = $this->find('user_id', $id);

        if ($findUserId && $findUserId['expired_date'] < strtotime("now")) {
            $data = array_reverse($data);
            $pop = array_pop($data);

            $this->update($data, 'user_id', $id);
        } else {
            $this->createData($data);
        }
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

    public function getUserId($token)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
            ->from($this->table)
            ->setParameter(':token', $token)
            ->where( 'token = :token');
        $result = $qb->execute();
        return $result->fetch()['user_id'];
    }

    // public function geFindImage($)

}
