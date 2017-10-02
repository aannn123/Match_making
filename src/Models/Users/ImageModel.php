<?php

namespace App\Models\Users;

use App\Models\BaseModel;

class ImageModel extends BaseModel
{
    protected $table = 'images';
    protected $column = ['id', 'user_id', 'images', 'created_at', 'updated_at'];

    public function postImage(array $data, $images)
    {
        $data = [
            'user_id' => $data['user_id'],
            'images'   => $data['images'],
        ];

        $this->createData($data);
        return $this->db->lastInsertId();        
    }

    public function getImage($id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('id', 'user_id', 'images', 'created_at', 'updated_at')
           ->from($this->table)
           ->where('user_id ='. $id)
           ->orderBy('images', 'asc');
        $query = $qb->execute();
        return $this;
    }

     public function deleteImage($id, $user)
    {
        $qb = $this->db->createQueryBuilder();

         $qb->delete($this->table)
            ->where('id = ' . $id)
            ->andWhere('user_id =' . $user)
            ->execute();
    }

     public function getImages($column, $val)
    {
        $param = ':'.$column;

        $qb = $this->db->createQueryBuilder();
        $qb->select('id', 'user_id', 'images')
        ->from($this->table)
        ->where($column.' = '. $param)
        ->setParameter($param, $val);

        $query = $qb->execute();
        return $query->fetch();
    }

}
