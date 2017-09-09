<?php 

namespace App\Controllers\Api\Users;

use App\Models\Users\ProfilModel;
use App\Models\Users\UserToken;
use App\Models\Users\UserModel;
use App\Controllers\Api\BaseController;

class ProfilController extends BaseController
{
    public function showProfileUser($request, $response)
    {
        $profil = new ProfilModel($this->db);
        $get = $profil->joinProfile();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $getUser = $profil->joinProfile()->setPaginate($page, 5);

            if ($getUser) {
                $data = $this->responseDetail(200, false,  'Data tersedia', [
                        'data'          =>  $getUser['data'],
                        'pagination'    =>  $getUser['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }

    public function createProfile($request, $response)
    {
        $profile = new ProfilModel($this->db);
        $UserToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $UserToken->getUserId($token);;
        // var_dump($userId);die();
        $this->validator->rule('required', ['nama_lengkap', 'tanggal_lahir', 'tempat_lahir', 'umur', 'alamat', 'kota', 'provinsi', 'kewarganegaraan', 'target_menikah', 'tentang_saya', 'pasangan_harapan']);

        if ($this->validator->validate()) {
            $create = $profile->createProfil($request->getParsedBody(), $userId['Id']);
            $find = $profile->find('id', $create);
            $data = $this->responseDetail(201, false, 'Profile berhasil dibuat', [
                    'data' => $find,
                ]);
        } else {
            $data = $this->responseDetail(400, true, $this->validator->errors());
        }   

            return $data;
    }


    public function updateProfile($request, $response, $args)
    {
        $user   = new UserModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $user = $userToken->getUserId($token);
        $profil = new ProfilModel($this->db);

        $find   = $profil->findWithoutDelete('user_id', $user['id']);

        if ($find) {
            $datainput  = $request->getParsedBody();
            $datainput['user_id'] = $user['id'];

            try {
                $profil->updateProfil($datainput);
                $find  = $profil->findWithoutDelete('user_id', $user['id']);

                $data = $this->responseDetail(200, false, 'Data telah terupdate', [
                        'data'  => $find
                    ]);

            } catch (Exception $e) {
                $data = $this->responseDetail(500, true, $e->getMessage);
            }

        } else {
            $data = $this->responseDetail(400, true, 'update data gagal');
        }
        return $data;
    }

    public function findProfil($request, $response, $args)
    {
        $profil = new ProfilModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $findProfil = $profil->findProfile('user_id', $args['id']);

        if ($findProfil) {
            // $profil->findProfile($args['id']);
            $data = $this->responseDetail(200, false, 'Data profile user id '."". $args['id']." ".'tersedia', [
                    'data' => $findProfil
                ]);
        } else {
            $data = $this->responseDetail(404, true, 'Data profil tidak ditemukan');
        }

            return $data;
    }
}
                