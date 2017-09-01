<?php 

namespace App\Controllers\Api;

use App\Models\Users\UserModel;
use App\Models\Users\UserToken;

class AdminController extends BaseController
{
    public function showUserPria($request, $response)
    {
        
    }

    public function showUserWanita($request, $response)
    {

    }

    public function showUserDetailPria($request, $response)
    {
        
    }

    public function showUserDetailWanita($request, $response)
    {
        
    }

    public function setModerator($request, $response, $args)
    {
        $users = new UserModel($this->db);
        $findUser = $users->find('id', $args['id']);

        if ($findUser) {
            $setModerator = $users->setModerator('id', $args['id']);
            $find = $users->find('id', $setModerator);
            $data = $this->responseDetail(200, false, 'User berhasil dijadikan moderator', [
                    'data'  => $setModerator
                ]);
        } else {
            $data = $this->responseDetail(404, true, 'User tidak ditemukan');
        }

            return $data;
    }
}

