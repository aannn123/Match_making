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
                <table bgcolor="#337AB7" border="0" cellpadding="0" cellspacing="0"
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
}

