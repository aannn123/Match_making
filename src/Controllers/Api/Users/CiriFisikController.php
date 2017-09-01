<?php 

namespace App\Controllers\Api\Users;

use App\Models\Users\UserModel;
use App\Models\Users\UserToken;
use App\Models\Users\CiriFisikModel;
use App\Controllers\Api\BaseController;

class CiriFisikController extends BaseController
{
    public function getAll($request, $response)
    {
        $user = new UserModel($this->db);
        $get = $user->getAllUserMan();
        // $gender = $user->find('gender');
        // var_dump($gender);die();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $getUser = $user->getAllUserMan()->setPaginate($page, 5);

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

    public function createCiriFisikPria($request, $response, $args)
    {
        $fisik = new CiriFisikModel($this->db);
        $user = new UserModel($this->db);
        $userToken = new \App\Models\Users\UserToken($this->container->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        // var_dump($checkUserId > 1);die();
        $input  = $request->getParsedBody();

        $this->validator->rule('required', ['tinggi', 'jenggot', 'berat', 'suku', 'warna_kulit', 'kaca_mata', 'status_kesehatan', 'ciri_fisik_lain']);

        if ($this->validator->validate()) {
                 $createFisik = $fisik->createFisikPria($input, $userId['user_id']);
                $find = $fisik->find('id', $createFisik);
                // var_dump($find);die();
                $data = $this->responseDetail(200, false, 'Berhasil menambahkan ciri fisik', [
                        'data' => $find
                ]);
        } else {
             $data = $this->responseDetail(400, true, $this->validator->errors());
        }
        
         return $data;
    }

    public function createCiriFisikWanita($request, $response, $id)
    {
        $fisik = new CiriFisikModel($this->db);
        $user = new UserModel($this->db);
        $userToken = new \App\Models\Users\UserToken($this->container->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);
        $input  = $request->getParsedBody();

        $this->validator->rule('required', ['tinggi', 'cadar', 'hijab', 'berat', 'suku', 'warna_kulit', 'kaca_mata', 'status_kesehatan', 'ciri_fisik_lain']);

        if ($this->validator->validate()) {
                $createFisik = $fisik->createFisikWanita($input, $userId['user_id']);
                $find = $fisik->find('id', $createFisik);
                // var_dump($find);die();
                $data = $this->responseDetail(200, false, 'Berhasil menambahkan ciri fisik', [
                        'data' => $find
                ]);
        } else {
             $data = $this->responseDetail(400, true, $this->validator->errors());
        }
        
         return $data;
    }

    public function updateFisikPria($request, $response, $args)
    {
        // $this->validator->rule('required', ['tinggi', 'jenggot', 'berat', 'suku', 'warna_kulit', 'kaca_mata', 'status_kesehatan', 'ciri_fisik_lain']);
        $user = new UserModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $user = $userToken->getUserId($token);
        $fisik = new CiriFisikModel($this->db);

        $find  = $fisik->findWithoutDelete('user_id', $user['id']);
        // var_dump($find);die();
        if ($find) {
            $datainput  = $request->getParsedBody();
            $datainput['user_id'] = $user['id'];

            try {
                $fisik->updatePria($datainput);
                $find  = $fisik->findWithoutDelete('user_id', $user['id']);

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

    public function updateFisikWanita($request, $response, $args)
    {

        // $this->validator->rule('required', ['tinggi', 'cadar', 'hijab', 'berat', 'suku', 'warna_kulit', 'kaca_mata', 'status_kesehatan', 'ciri_fisik_lain']);

        $user = new UserModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $user = $userToken->getUserId($token);
        $fisik = new CiriFisikModel($this->db);
        
        $find  = $fisik->findWithoutDelete('user_id', $user['id']);
        // var_dump($find);die();
        if ($find) {
            $datainput  = $request->getParsedBody();
            $datainput['user_id'] = $user['id'];

            try {
                $fisik->updateWanita($datainput);
                $find  = $fisik->findWithoutDelete('user_id', $user['id']);

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
}