<?php

namespace App\Models\Users;

use App\Models\BaseModel;

class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $column = ['id','username', 'gender', 'email', 'phone', 'password', 'photo', 'ktp', 'status', 'accepted_by', 'last_online', 'created_at', 'updated_at'];

    public function createMember(array $data, $images)
    {
        $data = [
            'username' => $data['username'],
            'gender'   => $data['gender'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'photo'    => 'avatar.png' ,
            'ktp'      => 'avatar.png' ,
            'role'     => $data['role'],
        ];

        $this->createData($data);
        return $this->db->lastInsertId();        
    }

    public function register(array $data, $images)
    {
        $data = [
            'username' => $data['username'],
            'gender'   => $data['gender'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'photo'    => 'avatar.png' ,
            'ktp'      => 'avatar.png' ,
            'role'     => 0,
        ];

        $this->createData($data);
        return $this->db->lastInsertId();
    }

    // public function updateImage(array $data, $id)
    // {
    //     $data = [
    //         'photo' => $data['photo'],
    //     ];
    //     $this->updateData($data, $id);
    //     return $this->db->lastInsertId();
    // }

    public function updateUser(array $data, $images, $id)
    {
        $data = [
            'username' => $data['username'],
            'gender'   => $data['gender'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'photo'     => $images,
            'ktp'      => $images,
        ];
        $this->updateData($data, $id);
    }

    public function getImage($id)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('photo')
           ->from($this->table)
           ->where('id ='. $id)
           ->orderBy('photo', 'asc');
        $query = $qb->execute();
        return $this;
    }

    public function getUser($column, $val)
    {
        $param = ':'.$column;

        $qb = $this->db->createQueryBuilder();
        $qb->select('id', 'username', 'email', 'gender', 'phone', 'password',
                    'status', 'photo', 'ktp', 'role', 'created_at')
        ->from($this->table)
        ->where($column.' = '. $param)
        ->setParameter($param, $val);

        $query = $qb->execute();
        return $query->fetch();
    }

    public function getAllUserMan()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            ->from($this->table)
            ->where('gender = 1')
            ->orderBy('created_at', 'desc');
        $query = $qb->execute();
        return $this;
    }

    public function getAllNewuser()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            ->from($this->table)
            ->where('status = 1 && role = 0')
            ->orderBy('created_at', 'desc');
        $query = $qb->execute();
        return $this;
    }

    public function getAllUserWoman()
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
            ->from($this->table)
            ->where('gender = 2 ')
            ->orderBy('created_at', 'desc');
        $query = $qb->execute();
        return $this;
    }

    public function checkDuplicate($username, $email)
    {
        $checkUsername = $this->find('username', $username);
        $checkEmail = $this->find('email', $email);
        if ($checkUsername && $checkEmail) {
            return 3;
        } elseif ($checkUsername) {
            return 1;
        } elseif ($checkEmail) {
            return 2;
        }
        return false;
    }

    public function setModerator($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
           ->set('role', 2)
           ->where('role = 0 && status = 2 && id = '. $id)
           ->execute();
    }

    public function setUserPremium($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
           ->set('role', 3)
           ->where('role = 0')
           ->andWhere('status = 2')
           ->andWhere('id ='. $id)
           ->execute();
    }

    public function changePassword(array $data, $id)
    {
        $dataPassword = [
            'password'  => password_hash($data['new_password'], PASSWORD_BCRYPT),
        ];

        $this->updateData($dataPassword, $id);
    }

    public function joinUser()
    {
        $qb = $this->db->createQueryBuilder();

        $qb->select('profil.*')
           ->from('profil')
           ->join('profil', 'user_id', 'users', 'users.id = profil.user_id')
           ->execute();
    }

    public function setApproveUser($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('status', 2)
        ->where('id = ' . $id)
        ->execute();

        return $this->db->lastInsertId();
    }

    public function setActive($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table)
        ->set('status', 1)
        ->where('id = ' . $id)
        ->execute();
    }

     // $qb = $this->db->createQueryBuilder();
     //    $this->query = $qb->select('prof.*','kot.nama as kota','prov.nama as provinsi','negara.nama as kewarganegaraan', 'user.gender as jenis_kelamin')
     //        ->from($this->table,'prof')
     //        ->join('prof','kota', 'kot', 'kot.id = prof.kota')
     //        ->join('prof','provinsi', 'prov', 'prov.id = prof.provinsi')
     //        ->join('prof','users', 'user', 'user.id = prof.user_id')
     //        ->join('prof','negara', 'negara', 'negara.id = prof.kewarganegaraan');
     //    $query = $qb->execute();
     //    return $this;

    public function joinUserAll()
    {
          $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('user.*','kot.nama as kota','prov.nama as provinsi','negara.nama as kewarganegaraan')
            ->from($this->table,'user')
            // ->join('user','profil', 'prof', 'prof.umur = user.id')
            ->join('user','kota', 'kot', 'kot.id = kot.id')
            ->join('user','provinsi', 'prov', 'prov.id = user.id')
            ->join('user','negara', 'negara', 'negara.id = user.id');
        $query = $qb->execute();
        return $this;
    }


    public function searchUser($val)
    {
        $qb = $this->db->createQueryBuilder();
        $this->query = $qb->select('*')
                 ->from($this->table)
                 ->where('username LIKE :val')
                 ->orWhere('email LIKE :val')
                 ->orWhere('phone LIKE :val')
                 ->andWhere('deleted = 0')
                 ->orderBy('created_at', 'desc')
                 ->setParameter('val', '%'.$val.'%');

        // $result = $this->query->execute();

        // return $result->fetchAll();

        $query = $qb->execute();
        return $this;    }

    // public function acceptedBy($id, $user)
    // {
    //     var_dump($id);die;
    //     $qb = $this->db->createQueryBuilder();
    //     $qb->update($this->table)
    //     ->set('accepted_by', 7)
    //     ->where('id = ' . $user);
    //     $qbb = $qb->execute();

    //     return $qbb;
    //     // var_dump($qbb);die();
    // }
}
