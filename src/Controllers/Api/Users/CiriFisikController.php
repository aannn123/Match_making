<?php 

namespace App\Controllers\Api\Users;

use App\Models\Users\UserModel;
use App\Models\Users\UserToken;
use App\Models\Users\CiriFisikModel;
use App\Controllers\Api\BaseController;

class CiriFisikController extends BaseController
{
    public function getAllFisikPria($request, $response)
    {
        $user = new CiriFisikModel($this->db);
        $get = $user->getAllData();
        // $gender = $user->find('gender');
        // var_dump($gender);die();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $getUser = $user->getAllData()->setPaginate($page, 5);

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

    public function getAllFisikWanita($request, $response)
    {
        $user = new CiriFisikModel($this->db);
        $get = $user->showFisikPria();
        // $gender = $user->find('gender');
        // var_dump($gender);die();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $getUser = $user->showFisikPria()->setPaginate($page, 5);

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

        // var_dump($userId);die();
        $input  = $request->getParsedBody();
        $findUser = $user->getUser('id', $userId);
        // var_dump($findUser['gender']);die();

        $this->validator->rule('required', ['tinggi', 'jenggot', 'berat', 'suku', 'warna_kulit', 'kaca_mata', 'status_kesehatan', 'ciri_fisik_lain']);

        if ($this->validator->validate()) {
            if ($findUser['gender'] == 'perempuan') {
                $data = $this->responseDetail(400, true, 'Maaf anda tidak mempunyai akses untuk mengcreate data ini');
            } else {
                 $createFisik = $fisik->createFisikPria($input, $userId['user_id']);
                 // var_dump($createFisik);die();
                $find = $fisik->find('id', $createFisik);
                var_dump($find);die();
                $data = $this->responseDetail(200, false, 'Berhasil menambahkan ciri fisik', [
                        'data' => $find
                ]);
            }
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

        $findUser = $user->getUser('id', $userId);
        // var_dump($findUser['gender']);die();
        if ($this->validator->validate()) {
            if ($findUser['gender'] == 'laki-laki') {
                $data = $this->responseDetail(400, true, 'Maaf anda tidak mempunyai akses untuk mengcreate data ini');
            } else {
                $createFisik = $fisik->createFisikWanita($input, $userId['user_id']);
                $find = $fisik->find('id', $createFisik);
                // var_dump($find);die();
                $data = $this->responseDetail(200, false, 'Berhasil menambahkan ciri fisik', [
                        'data' => $find
                ]);
            }
        } else {
             $data = $this->responseDetail(400, true, $this->validator->errors());
        }
        
         return $data;
    }

    public function updateFisikPria($request, $response, $args)
    {
        $users = new UserModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $user = $userToken->getUserId($token);
        $fisik = new CiriFisikModel($this->db);


        $find  = $fisik->findWithoutDelete('user_id', $user['id']);
        $findUser = $users->getUser('id', $user);

        if ($find) {
            if ($findUser['gender'] == 'perempuan') {
                $data = $this->responseDetail(400, true, 'Maaf anda tidak mempunyai akses untuk mengupate data ini');
            } else {
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
            }
        } else {
            $data = $this->responseDetail(400, true, 'update data gagal');
        }
            return $data;
    }

    public function updateFisikWanita($request, $response, $args)
    {
        $users = new UserModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $user = $userToken->getUserId($token);
        $fisik = new CiriFisikModel($this->db);
        
        $find  = $fisik->findWithoutDelete('user_id', $user['id']);
        $findUser = $users->getUser('id', $user); 
        // var_dump($find);die();
        if ($find) {
            if ($findUser['gender'] == 'laki-laki') {
                $data = $this->responseDetail(400, true, 'Maaf anda tidak mempunyai akses untuk mengupate data ini');
            } else {
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
            }
            } else {
                $data = $this->responseDetail(400, true, 'update data gagal');
            }
            return $data;
    }

    public function findData($request, $response, $args)
    {
        $fisik = new CiriFisikModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $findData = $fisik->find('user_id', $args['id']);

        if ($findData) {
            $data = $this->responseDetail(200, false, 'Data ciri fisik user tersedia', [
                'data' => $findData
            ]);
        } else {
            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
        }
            return $data;
    }
}