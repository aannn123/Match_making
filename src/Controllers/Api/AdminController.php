<?php 

namespace App\Controllers\Api;

use App\Models\Users\UserModel;
use App\Models\Users\UserToken;
use App\Models\Users\ProfilModel;
use App\Models\Users\KeseharianModel;
use App\Models\Users\LatarBelakangModel;
use App\Models\Users\CiriFisikController;

class AdminController extends BaseController
{
    public function showUserPria($request, $response)
    {
        
    }

    public function showUserWanita($request, $response)
    {

    }

    public function showProfilUser($request, $response)
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

    public function showKeseharianUser($request, $response)
    {

    }

    public function showCiriFisikUser($request, $response)
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

    public function showLatarBelakangUser($request, $response)
    {

        $latar = new LatarBelakangModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);
        $get = $latar->getAllData();
        $countLatar = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $getLatar = $latar->getAllData()->setPaginate($page, 5);

            if ($getLatar) {
                $data = $this->responseDetail(200, false,  'Data tersedia', [
                        'data'          =>  $getLatar['data'],
                        'pagination'    =>  $getLatar['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }

    public function setModerator($request, $response, $args)
    {
        $users = new UserModel($this->db);
        $findUser = $users->find('id', $args['id']);
        $user = $users->getUser('id', $args['id']);
        // var_dump($user['role']);die();
        if ($findUser) {
            if ($user['role'] == 2) {
                $data = $this->responseDetail(400, false, 'User sudah menjadi moderator');
                
            } elseif($user['role'] == 0 && $user['status'] == 2) {
                $setModerator = $users->setModerator($args['id']);
                $find = $users->find('id', $setModerator);
                $data = $this->responseDetail(200, false, 'User berhasil dijadikan moderator', [
                        'data'  => $setModerator
                ]);
            } else {
                $data = $this->responseDetail(404, true, 'User tidak bisa dijadikan moderator dikarenakan status user belum complete');
            }
        } else {
            $data = $this->responseDetail(404, true, 'User tidak ditemukan');
        }

            return $data;
    }

    public function approveUser($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $registers = new \App\Models\Users\RegisterModel($this->db);
        $userToken = new UserToken($this->db);
        $mailer = new \App\Extensions\Mailers\Mailer();
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $findUser = $user->find('id', $args['id']);
        // var_dump($findUser);die();
        if ($findUser) {
            $setUser = $user->setApproveUser($args['id']);
            $newUser = $user->getUser('id', $args['id']);
                $token = md5(openssl_random_pseudo_bytes(8));
                $tokenId = $registers->setToken($newUser['id'] , $token);
                $userToken = $registers->find('id', $tokenId);
                // var_dump($userToken);die();

                $keyToken = $userToken['token'];
                // $activateUrl = '< a href = '.$request->getUri()->getBaseUrl()."/activateaccount/".$keyToken.'>;

                 $activateUrl = '<a href ='.$base ."/activateaccount/".$keyToken.'>

                <h3>AKTIFKAN AKUN</h3></a>';
                  $content = '<html><head></head>
                <body style="font-family: Verdana;font-size: 12.0px;">
                <table border="0" cellpadding="0" cellspacing="0" style="max-width: 600.0px;">
                <tbody><tr><td><table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr><td align="left">
                </td></tr></tbody></table></td></tr><tr height="16"></tr><tr><td>
                <table bgcolor="#11A86" border="0" cellpadding="0" cellspacing="0"
                style="min-width: 332.0px;max-width: 600.0px;border: 1.0px solid rgb(224,224,224);
                border-bottom: 0;" width="100%">
                <tbody><tr><td colspan="3" height="42px"></td></tr>
                <tr><td width="32px"></td>
                <td style="font-family: Roboto-Regular , Helvetica , Arial , sans-serif;font-size: 24.0px;
                color: rgb(255,255,255);line-height: 1.25;">Aktivasi Akun Match making</td>
                <td width="32px"></td></tr>
                <tr><td colspan="3" height="18px"></td></tr></tbody></table></td></tr>
                <tr><td><table bgcolor="#FAFAFA" border="0" cellpadding="0" cellspacing="0"
                style="min-width: 332.0px;max-width: 600.0px;border: 1.0px solid rgb(240,240,240);
                border-bottom: 1.0px solid rgb(192,192,192);border-top: 0;" width="100%">
                <tbody><tr height="16px"><td rowspan="3" width="32px"></td><td></td>
                <td rowspan="3" width="32px"></td></tr>
                <tr><td><p>Yang terhormat '.$request->getParsedBody()['username'].',</p>
                <p>Terima kasih telah mendaftar di Match Making.
                Untuk mengaktifkan akun Anda, silakan klik tautan di bawah ini.</p>
                <div style="text-align: center;"><p>
                <strong style="text-align: center;font-size: 24.0px;font-weight: bold;">
                '.$activateUrl.'</strong></p></div>
                <p>Jika tautan tidak bekerja, Anda dapat menyalin atau mengetik kembali
                 tautan di bawah ini.</p>
                '.$base .'/activateaccount/'.$keyToken.'<p><br>
                <p>Terima kasih, <br /><br /> Admin Match Making</p></td></tr>
                <tr height="32px"></tr></tbody></table></td></tr>
                <tr height="16"></tr>
                <tr><td style="max-width: 600.0px;font-family: Roboto-Regular , Helvetica , Arial , sans-serif;
                font-size: 10.0px;color: rgb(188,188,188);line-height: 1.5;"></td>
                </tr><tr><td></td></tr></tbody></table></body></html>';

                $mail = [
                'subject'   =>  'Match Making - Verifikasi Email',
                'from'      =>  'farhan.mustqm@gmail.com',
                'to'        =>  $newUser['email'],
                'sender'    =>  'Match Making',
                'receiver'  =>  $newUser['name'],
                'content'   =>  $content,
                ];

                $mailer->send($mail);
                $data = $this->responseDetail(201, false, 'approve user berhasil', [
                        'data' => $findUser
                    ]);
        } else {
            $data = $this->responseDetail(201, false, 'User tidak ditemukan');
        }
            return $data;
    }

    public function cancelTaaruf($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $findUser = $requests->findTwo('id_perequest', $args['perequest'], 'id_terequest', $args['terequest']);
        
        $find = $requests->getRequest('id_perequest', $args['perequest'], 'id_terequest', $args['terequest']);
        // var_dump($find);die();    

        if ($findUser) {
            if ($find['blokir'] == 2) {
                $data = $this->responseDetail(404, true, 'Taaruf sudah di cancel');
            } else {
            // $sendRequest = $requests->update($data);
            $blokir = $requests->cancelTaaruf($args['perequest'], $args['terequest']);
            $data = $this->responseDetail(200, false, 'Taaruf user berhasil di cancel', [
                    'data' => $blokir
                ]);
        }
        } else {
            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
        }
        return $data;
    }

    public function getTaaruf($request, $response)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $requests->joinRequest();
        // $gender = $user->find('gender');
        $countUser = count($get);
        // var_dump($countUser);die();
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $getNotification = $requests->joinRequest()->setPaginate($page, 10);

            if ($getNotification) {
                $data = $this->responseDetail(200, false,  'Data taaruf user tersedia', [
                        'data'          =>  $getNotification['data'],
                        'pagination'    =>  $getNotification['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data taaruf user tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }

    public function showNewUser($request, $response)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $user->getAllNewuser();
        // $gender = $user->find('gender');
        $countUser = count($get);
        // var_dump($countUser);die();
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $getNotification = $user->getAllNewuser()->setPaginate($page, 5);

            if ($getNotification) {
                $data = $this->responseDetail(200, false,  'Data taaruf user tersedia', [
                        'data'          =>  $getNotification['data'],
                        'pagination'    =>  $getNotification['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data taaruf user tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }

    public function cancelUser($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $mailer = new \App\Extensions\Mailers\Mailer();
        $findUser = $user->find('id', $args['id']);

        if ($findUser) {
            $newUser = $user->getUser('id', $args['id']);
            $deleteUser = $user->hardDelete($args['id']);
            // var_dump($newUser);die();
            '<h3>Mohon maaf</h3></a>';
                  $content = '<html><head></head>
                <body style="font-family: Verdana;font-size: 12.0px;">
                <table border="0" cellpadding="0" cellspacing="0" style="max-width: 600.0px;">
                <tbody><tr><td><table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr><td align="left">
                </td></tr></tbody></table></td></tr><tr height="16"></tr><tr><td>
                <table bgcolor="#11A86" border="0" cellpadding="0" cellspacing="0"
                style="min-width: 332.0px;max-width: 600.0px;border: 1.0px solid rgb(224,224,224);
                border-bottom: 0;" width="100%">
                <tbody><tr><td colspan="3" height="42px"></td></tr>
                <tr><td width="32px"></td>
                <td style="font-family: Roboto-Regular , Helvetica , Arial , sans-serif;font-size: 24.0px;
                color: rgb(255,255,255);line-height: 1.25;"><center>Mohon Maaf Akun Match making</center></td>
                <td width="32px"></td></tr>
                <tr><td colspan="3" height="18px"></td></tr></tbody></table></td></tr>
                <tr><td><table bgcolor="#FAFAFA" border="0" cellpadding="0" cellspacing="0"
                style="min-width: 332.0px;max-width: 600.0px;border: 1.0px solid rgb(240,240,240);
                border-bottom: 1.0px solid rgb(192,192,192);border-top: 0;" width="100%">
                <tbody><tr height="16px"><td rowspan="3" width="32px"></td><td></td>
                <td rowspan="3" width="32px"></td></tr>
                <tr><td><p>Yang terhormat '.$newUser['username'].',</p>
                <p>Mohon maaf, anda tidak diterima atau tidak di setujui oleh admin dikarenakan pendaftaran anda tidak sesuai persetujuan.</p>
                <p>Terima kasih sudah mendaftar di Match Making.</p>
                <p>Terima kasih, <br /><br /> Admin Match Making</p></td></tr>
                <tr height="32px"></tr></tbody></table></td></tr>
                <tr height="16"></tr>
                <tr><td style="max-width: 600.0px;font-family: Roboto-Regular , Helvetica , Arial , sans-serif;
                font-size: 10.0px;color: rgb(188,188,188);line-height: 1.5;"></td>
                </tr><tr><td></td></tr></tbody></table></body></html>';

                $mail = [
                'subject'   =>  'Match Making - Permohonan Maaf',
                'from'      =>  'farhan.mustqm@gmail.com',
                'to'        =>  $newUser['email'],
                'sender'    =>  'Match Making',
                'receiver'  =>  $newUser['username'],
                'content'   =>  $content,
                ];

                $mailer->send($mail);
            $data = $this->responseDetail(200, false, 'User berhasil dihapus', [
                'data' => $findUser
            ]);
        } else {
            $data = $this->responseDetail(404, true, 'User tidak ditemukan');
        }

        return $data;
    }

    public function showRequestAll($request, $response)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $requests->joinRequestAll();
        // $gender = $user->find('gender');
        $countUser = count($get);
        // var_dump($countUser);die();
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $getNotification = $requests->joinRequestAll()->setPaginate($page, 10);

            if ($getNotification) {
                $data = $this->responseDetail(200, false,  'Data semua request tersedia', [
                        'data'          =>  $getNotification['data'],
                        'pagination'    =>  $getNotification['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data request tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }
}

