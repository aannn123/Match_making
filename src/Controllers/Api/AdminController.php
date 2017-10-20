<?php

namespace App\Controllers\Api;

use App\Models\Users\UserModel;
use App\Models\Users\UserToken;
use App\Models\Users\ProfilModel;
use App\Models\Users\RegisterModel;
use App\Models\Users\KeseharianModel;
use App\Models\Users\LatarBelakangModel;
use App\Models\Users\CiriFisikController;

class AdminController extends BaseController
{

    public function showProfilUser($request, $response)
    {
        $profil = new ProfilModel($this->db);
        $get = $profil->joinProfile();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getUser = $profil->joinProfile()->setPaginate($page, $perPage);

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
            $perPage = $request->getQueryParam('perpage');
            $getUser = $user->getAllUserMan()->setPaginate($page, $perPage);

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
            $perPage = $request->getQueryParam('perpage');
            $getLatar = $latar->getAllData()->setPaginate($page, $perPage);

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
                $data = $this->responseDetail(400, true, 'User sudah menjadi moderator');

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
        $users = $user->getUser('id', $args['id']);
        // var_dump($findUser);die();
        if ($findUser) {
            if ($users['status'] == 2) {
                $data = $this->responseDetail(404, true, 'User sudah di approve');
            } elseif ($users['role'] == 1 || $users['role'] == 2 ) {
                $data = $this->responseDetail(404, true, 'Dia bukan member');
            } else {
            $setUser = $user->setApproveUser($args['id']);
            $responseUser = $user->find('id', $args['id']);
            
            $base = $request->getUri()->getBaseUrl();
            // var_dump($acceptBy);die();
            $newUser = $user->getUser('id', $args['id']);
                  $content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: rgba(9, 157, 255, 0.96); color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
    <style>
        @media  only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media  only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: rgba(9, 157, 255, 0.96); margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;"><tr>
<td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
<tr>
<td class="header" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;">
        <a href="'.$request->getUri()->getBaseUrl().'" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
            Match Making
        </a>
    </td>
</tr>
<!-- Email Body --><tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; border-bottom: 1px solid #EDEFF2; border-top: 1px solid #EDEFF2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
<!-- Body content --><tr>
<td class="content-cell" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                        <h1 style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #2F3133; font-size: 19px; font-weight: bold; margin-top: 0; text-align: left;">Hello '.$newUser["username"].'!</h1>
<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Selamat, anda diterima sebagai member match making, silahkan anda login kembali untuk bisa mengakses halaman user.</p>
<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;"><tr>
<td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;"><tr>
<td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;"><tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                    <a href="'.$request->getUri()->getBaseUrl().'" disabled="disabled" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097D1; border-top: 10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom: 10px solid #3097D1; border-left: 18px solid #3097D1;">Login</a>
                                </td>
                            </tr></table>
</td>
                </tr></table>
</td>
    </tr></table>
<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Terima kasih sudah mendaftar di Match Making.</p>
<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Regards admin,<br>Match Making</p>
<table class="subcopy" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-top: 1px solid #EDEFF2; margin-top: 25px; padding-top: 25px;"><tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
        </td>
    </tr></table>
</td>
                                </tr>
</table>
</td>
                    </tr>
<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;"><tr>
<td class="content-cell" align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #AEAEAE; font-size: 12px; text-align: center;">© 2017 Match Making. All rights reserved.</p>
                </td>
            </tr></table>
</td>
</tr>
</table>
</td>
        </tr></table>
</body>
</html>';

                $mail = [
                'subject'   =>  'Match Making - Notification',
                'from'      =>  'farhan.mustqm@gmail.com',
                'to'        =>  $newUser['email'],
                'sender'    =>  'Match Making',
                'receiver'  =>  $newUser['username'],
                'content'   =>  $content,
                ];

                $mailer->send($mail);
                $data = $this->responseDetail(200, false, 'approve user berhasil', [
                        'data' => $responseUser
                    ]);
                }
        } else {
            $data = $this->responseDetail(404, true, 'User tidak ditemukan');
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

        $findUser = $requests->find('id', $args['id']);

        $find = $requests->getRequest('id_perequest', $args['perequest'], 'id_terequest', $args['terequest']);

        if ($findUser) {
            if ($find['blokir'] == 2) {
                $data = $this->responseDetail(404, true, 'Taaruf sudah di cancel');
            } else {    
            $blokir = $requests->cancelTaaruf($args['id']);
            $findUser = $requests->findTwoRequest('perequest', $args['perequest'], 'terequest', $args['terequest']);

            $data = $this->responseDetail(200, false, 'Taaruf user berhasil di cancel', [
                    'data' => $findUser
                ]);
        }
        } else {
            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
        }
        return $data;
    }

    public function findTaaruf($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $findUser = $requests->findTwoRequest('perequest', $args['perequest'], 'terequest', $args['terequest']);

        if ($findUser) {
            $data = $this->responseDetail(200, false, 'User Taaruf tersedia' ,
                [
                   'data' => $findUser 
            ]);           
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
            $perPage = $request->getQueryParam('perpage');
            $getNotification = $requests->joinRequest()->setPaginate($page, $perPage);

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
            $perPage = $request->getQueryParam('perpage');
            $getNotification = $user->getAllNewuser()->setPaginate($page, $perPage);

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
        $register = new \App\Models\Users\RegisterModel($db);
        $mailer = new \App\Extensions\Mailers\Mailer();
        $findUser = $user->find('id', $args['id']);

        if ($findUser) {
            $newUser = $user->getUser('id', $args['id']);
            $deleteUser = $user->hardDelete($args['id']);
            // var_dump($newUser);die();

            $content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: rgba(9, 157, 255, 0.96); color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
    <style>
        @media  only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media  only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: rgba(9, 157, 255, 0.96); margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;"><tr>
<td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
<tr>
<td class="header" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;">
        <a href="'.$request->getUri()->getBaseUrl().'" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
            Match Making
        </a>
    </td>
</tr>
<!-- Email Body --><tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; border-bottom: 1px solid #EDEFF2; border-top: 1px solid #EDEFF2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
<!-- Body content --><tr>
<td class="content-cell" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                        <h1 style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #2F3133; font-size: 19px; font-weight: bold; margin-top: 0; text-align: left;">Hello '.$newUser["username"].'!</h1>
<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Mohon maaf, anda tidak diterima atau tidak di setujui oleh admin dikarenakan pendaftaran anda tidak sesuai persetujuan, silahkan register kembali dan mengklik tautan dibawah ini, dan isi sesuai persetujuan admin.</p>
<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;"><tr>
<td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;"><tr>
<td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;"><tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                    <a href="'.$request->getUri()->getBaseUrl().'/register'.'" disabled="disabled" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097D1; border-top: 10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom: 10px solid #3097D1; border-left: 18px solid #3097D1;">Register</a>
                                </td>
                            </tr></table>
</td>
                </tr></table>
</td>
    </tr></table>
<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Terima kasih sudah mendaftar di Match Making.</p>
<p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Regards admin,<br>Match Making</p>
<table class="subcopy" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-top: 1px solid #EDEFF2; margin-top: 25px; padding-top: 25px;"><tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
     <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; line-height: 1.5em; margin-top: 0; text-align: left; font-size: 12px;">Persetujuan admin adalah dengan mengisi foto profil asli anda dan foto ktp asli anda, disertai mengisi form data yang sudah disediakan. <br>terima kasih</p>
        </td>
    </tr></table>
</td>
                                </tr>
</table>
</td>
                    </tr>
<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;"><tr>
<td class="content-cell" align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #AEAEAE; font-size: 12px; text-align: center;">© 2017 Match Making. All rights reserved.</p>
                </td>
            </tr></table>
</td>
</tr>
</table>
</td>
        </tr></table>
</body>
</html>';

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
            $perPage = $request->getQueryParam('perpage');
            $getNotification = $requests->joinRequestAll()->setPaginate($page, $perPage);

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

     public function getAllNotification($request, $response)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $requests->getAllNotification($userId);
        // $gender = $user->find('gender');
        // var_dump($userId);die();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getNotification = $requests->getAllNotification($userId)->setPaginate($page, $perPage);

            if ($getNotification) {
                $data = $this->responseDetail(200, false,  'Data notification tersedia', [
                        'data'          =>  $getNotification['data'],
                        'pagination'    =>  $getNotification['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Notification tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }

   public function setMemberPremium($request, $response, $args)
   {
       $users = new UserModel($this->db);
       $userToken = new UserToken($this->db);
       $token = $request->getHeader('Authorization');
       $userId = $userToken->getUserId($token);

       $findUser = $users->find('id', $args['id']);
       $user = $users->getUser('id', $args['id']);
        // var_dump($user['role']);die();
        if ($findUser) {
            if ($user['role'] == 3) {
                $data = $this->responseDetail(400, true, 'Member sudah menjadi premium');

            } elseif($user['role'] == 0 && $user['status'] == 2) {
                $setPremium = $users->setUserPremium($args['id']);
                $find = $users->find('id', $args['id']);
                $data = $this->responseDetail(200, false, 'Member berhasil dijadikan premium', [
                        'data'  => $find
                ]);
            } elseif ($user['role'] == 2 && $user['status'] == 2) {
                $data = $this->responseDetail(404, true, 'Dia bukan user');
            } elseif ($user['role'] == 1) {
                $data = $this->responseDetail(404, true, 'Dia bukan user');    
            } else {
                $data = $this->responseDetail(404, true, 'Member tidak bisa dijadikan premium dikarenakan status user belum complete');
            }
        } else {
            $data = $this->responseDetail(404, true, 'Member tidak ditemukan');
        }

            return $data;
   }


}
