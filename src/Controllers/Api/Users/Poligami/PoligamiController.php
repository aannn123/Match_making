<?php 

namespace App\Controllers\Api\Users\Poligami;

use App\Models\Users\UserModel;
use App\Models\Users\UserToken;
use App\Models\Users\Poligami\PoligamiModel;
use App\Controllers\Api\BaseController;


class PoligamiController extends BaseController
{
    public function getAll($request, $response)
    {
        $poligami = new PoligamiModel($this->db);
        $get = $poligami->getAllData();
        $count = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $getData = $poligami->getAllData()->setPaginate($page, 5);

            if ($getData) {
                $data = $this->responseDetail(200, false,  'Data tersedia', [
                        'data'          =>  $getData['data'],
                        'pagination'    =>  $getData['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }

    public function createPoligami($request, $response)
    {
        $user = new UserModel($this->db);
        $poligami = new PoligamiModel($this->db);
        $UserToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $UserToken->getUserId($token);;
        // var_dump($userId);die();
        $find = $user->getUser('id', $userId);
        // var_dump($find);die();
        
        $this->validator->rule('required', ['kesiapan', 'penjelasan_kesiapan']);

        if ($this->validator->validate()) {
            if ($find['gender'] == 'perempuan') {
                $data = $this->responseDetail(400, true, 'Anda tidak mempunyai akses kesini');
            } else {    
                $create = $poligami->createPoligami($request->getParsedBody(), $userId);
                // var_dump($create);die();
                $find = $poligami->find('id', $create);
                $data = $this->responseDetail(201, false, 'Data poligami berhasil dibuat', [
                        'data' => $find,
                    ]);
            }
        } else {
            $data = $this->responseDetail(400, true, $this->validator->errors());
        }   
            return $data;
    }

    public function updatePoligami($request, $response, $args)
    {

        $user = new UserModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);
        $poligami = new PoligamiModel($this->db);

        $find = $poligami->find('user_id', $userId);
        $query = $request->getQueryParams();
        $findUser = $user->getUser('id', $userId);
// var_dump($findUser);die;
        if ($find) {
            if ($findUser['gender'] == 'laki-laki') {
                $poligami->updatePoligami($request->getParsedBody(),$userId);
                $afterUpdate = $poligami->find('user_id', $userId);

                $data = $this->responseDetail(200, false, 'Data berhasil di perbaharui', [
                        'data'  =>  $afterUpdate
                    ]);
            } else {
                $data = $this->responseDetail(500, true, 'Anda tidak dapat mengakses halaman ini');
            }
        } else {
            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
        }

        return $data;
        // $user = new UserModel($this->db);
        // $userToken = new UserToken($this->db);
        // $token = $request->getHeader('Authorization')[0];
        // $userId = $userToken->getUserId($token);
        // $poligami = new PoligamiModel($this->db);

        // $find = $poligami->find('user_id', $userId);
        // // var_dump($find);die;
        // if ($find) {
        //     $datainput  = $request->getParsedBody();
        //     $datainput['user_id'] = $userId['id'];

        //     try {
        //         $poligami->updatePoligami($datainput);
        //         $find       = $poligami->findWithoutDelete('user_id', $userId);

        //         $data = $this->responseDetail(201, false, 'Data telah terupdate', [
        //                 'data'  => $find
        //             ]);

        //     } catch (Exception $e) {
        //         $data = $this->responseDetail(500, true, $e->getMessage);
        //     }

        // } else {
        //     $data = $this->responseDetail(400, true, 'update data gagal');
        // }
        // return $data;
    }


    public function findData($request, $response, $args)
    {
        $poligami = new PoligamiModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $find = $poligami->find('user_id', $args['id']);

        if ($find) {
            $data = $this->responseDetail(200, false, 'Data poligami user tersedia', [
                    'data' => $find
                ]);
        } else {
            $data = $this->responseDetail(200, false, 'Data poligami user tidak ditemukan');
        }

        return $data;
    }
}