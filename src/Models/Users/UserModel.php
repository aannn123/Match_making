<?php 

namespace App\Models\Users;

use App\Models\BaseModel;

class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $column = ['username', 'gender', 'email', 'phone', 'password', 'photo', 'ktp', 'status', 'accepted_by', 'last_online', 'created_at', 'updated_at'];

    public function register(array $data, $images)
    {
        $data = [
            'username' => $data['username'],
            'gender'   => $data['gender'],
            'password' => $data['password'],
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'photo'    => $data['photo'],
            'ktp'      => $data['ktp'],
            'role'     => o,
            'status'   => 0
        ];

        $this->createData($data);
        return $this->db->lastInsertData();
    }

    public function updateUser(array $data, $id)
    {
        
    }

    public function getAllUserMan()
    {

    }

    public function getAllUserWoman()
    {

    }

    public function search($val, $id)
    {
        
    }
}
