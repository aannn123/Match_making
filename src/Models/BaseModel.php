<?php

namespace App\Models;

abstract class BaseModel
{
    protected $table;
    protected $column;
    protected $db;
    protected $qb;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Get All
    public function getAll()
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
            ->from($this->table)
            ->where('deleted = 0');
        $query = $qb->execute();
        return $query->fetchAll();
    }

    // Trash
    public function getAllTrash()
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
                 ->from($this->table)
                 ->where('deleted = 1');
        $query = $qb->execute();
        return $query->fetchAll();
    }

    //get In aktif
    public function getInactive()
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
                 ->from($this->table)
                 ->where('deleted = 1');
        $query = $qb->execute();
        return $query->fetchAll();
    }

    //Get trash
    public function trash()
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
            ->from($this->table)
            ->where('deleted = 1');
        $query = $qb->execute();
        return $query->fetchAll();
    }

    // Find
    public function find($column, $value)
    {
        $param = ':'.$column;
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
            ->from($this->table)
            ->setParameter($param, $value)
            ->where($column . ' = '. $param);
        $result = $qb->execute();
        return $result->fetch();
    }

    // Craete Data
    public function createData(array $data)
    {
        $valuesColumn = [];
        $valuesData = [];

        foreach ($data as $dataKey => $dataValue) {
            $valuesColumn[$dataKey] = ':' . $dataKey;
            $valuesData[$dataKey] = $dataValue;
        }

        $qb = $this->db->createQueryBuilder();

        $qb->insert($this->table)
            ->values($valuesColumn)
            ->setParameters($valuesData)
            ->execute();
    }

    // Update Data
     public function updateData(array $data, $id)
         {
         $valuesColumn = [];
         $valuesData = [];
         $qb = $this->db->createQueryBuilder();

         $qb->update($this->table);

         foreach ($data as $dataKey => $dataValue) {
             $valuesColumn[$dataKey] = ':' . $dataKey;
             $valuesData[$dataKey] = $dataValue;

             $qb->set($dataKey, $valuesColumn[$dataKey]);
         }

         $qb->setParameters($valuesData)
            ->where('id = ' . $id)
            ->execute();
     }

     // SoftDelete
    public function softDelete($id)
    {
        $qb = $this->db->createQueryBuilder();

        $qb->update($this->table)
            ->set('deleted', 1)
            ->where('id = ' . $id)
            ->execute();
    }

    //HardDelete
    public function hardDelete($id)
    {
        $qb = $this->db->createQueryBuilder();

        $qb->delete($this->table)
            ->where('id = ' . $id)
            ->execute();
    }

    // Restore
    public function restoreData($id)
    {
        $qb = $this->db->createQueryBuilder();

        $qb->update($this->table)
            ->set('deleted', 0)
            ->where('id = ' . $id)
            ->execute();
    }

    //Pagination
    public function setPaginate(int $page, int $limit)
    {
        //count total custom query
        $total = count($this->fetchAll());
        //count total pages
        $pages = (int) ceil($total / $limit);
        // $number = (int) $page;
        $range = $limit * ($page - 1);
        $data = $this->query->setFirstResult($range)->setMaxResults($limit);
        $data = $this->fetchAll();
        $result = [
            'data'        => $data,
            'pagination'  =>[
                'total_data'=> $total,
                'perpage'   => $limit,
                'current'   => $page,
                'total_page'=> $pages,
                'first_page'=> 1,
            ]
        ];
        return $result;
    }

    public function fetchAll()
    {
        return $this->query->execute()->fetchAll();
    }

    public function fetch()
    {
        return $this->query->execute()->fetch();
    }

    public function findTwo($column1, $val1, $column2, $val2)
    {
        $param1 = ':'.$column1;
        $param2 = ':'.$column2;
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
            ->from($this->table)
            ->setParameter($param1, $val1)
            ->setParameter($param2, $val2)
            ->where($column1 . ' = '. $param1 .'&&'. $column2 . ' = '. $param2);
        $result = $qb->execute();
        return $result->fetchAll();
    }

    public function findThree($col1, $val1, $col2, $val2, $col3, $val3)
    {
        $param1 = ':'.$col1;
        $param2 = ':'.$col2;
        $param3 = ':'.$col3;
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
            ->from($this->table)
            ->setParameter($param1, $val1)
            ->setParameter($param2, $val2)
            ->setParameter($param3, $val3)
            ->where($col1.'='.$param1.'&&'.$col2.'='.$param2.'&&'.$col3.'='.$param3);
        $result = $qb->execute();
        return $result->fetchAll();
    }

    public function getUserByToken($token)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('user_id')
            ->from('tokens')
            ->setParameter(':token', $token)
            ->where( 'token = :token');
        $result = $qb->execute();

        $qb1 = $this->db->createQueryBuilder();
        $qb1->select('id', 'username','email', 'name', 'image', 'status' )
             ->from('users')
             ->where('id = '. $result->fetch()['user_id']);
         $result1 = $qb1->execute();
         return $result1->fetch();
     }
}
