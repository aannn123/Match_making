<?php 

namespace App\Controllers\Api\Users;

use App\Models\Users\UserModel;
use App\Models\Users\UserToken;
use App\Models\Users\LatarBelakangModel;
use App\Controllers\Api\BaseController;

class LatarBelakangController extends BaseController
{
    public function createLatarBelakang($request, $response)
    {
        $latar = new LatarBelakangModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);
        // var_dump($userId);die();

        $this->validator->rule('required', ['pendidikan', 'penjelasan_pendidikan', 'agama', 'penjelasan_agama', 'muallaf', 'baca_quran', 'hafalan', 'keluarga', 'penjelasan_keluarga', 'shalat']);

        if ($this->validator->validate()) {
            $createData = $latar->createLatar($request->getParsedBody(), $userId['user_id']);
            $finds = $latar->find('id', $createData);
            $data = $this->responseDetail(200, false, 'Berhasil menambahkan data profil', [
                    'data' => $finds
                ]); 
        } else {
            $data = $this->responseDetail(400, true, $this->validator->errors());
        }
            return $data;

    }

    public function updateLatarBelakang($request, $response, $args)
    {
        $user      = new UserModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $user = $userToken->getUserId($token);
        $latar = new LatarBelakangModel($this->db);

        $find       = $latar->findWithoutDelete('user_id', $user['id']);

        if ($find) {
            $datainput  = $request->getParsedBody();
            $datainput['user_id'] = $user['id'];

            try {
                $latar->updateLatar($datainput);
                $find  = $latar->findWithoutDelete('user_id', $user['id']);

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

    public function findData($request, $response, $args)
    {
        $latar = new LatarBelakangModel($this->db);
        $users = new UserModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $find = $latar->find('user_id', $args['id']);

        if ($find) {
            $data = $this->responseDetail(200, false, 'Data Latar belakang user tersedia', [
                    'data' => $find
                ]);
        } else {
            $data = $this->responseDetail(200, false, 'Data Latar belakang user tidak ditemukan');
        }

        return $data;
    }
}