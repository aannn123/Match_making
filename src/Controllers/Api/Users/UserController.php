<?php

namespace App\Controllers\Api\Users;

use App\Models\Users\UserModel;
use App\Models\Users\UserToken;
use App\Models\Users\RegisterModel;
use App\Controllers\Api\BaseController;

class UserController extends BaseController
{
    public function getAllData($request, $response)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $user->getAllData();
        $gender = $user->find('gender');
        // var_dump($gender);die();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getUser = $user->getAllData()->setPaginate($page, $perPage);

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

     public function allJoinUser($request, $response)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $user->joinUserAll();
        $gender = $user->find('gender');
        // var_dump($gender);die();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getUser = $user->joinUserAll()->setPaginate($page, $perPage);

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

     public function getAllNewUser($request, $response)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $user->getAllNewUser();
        // var_dump($gender);die();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getUser = $user->getAllNewUser()->setPaginate($page, $perPage);

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

    public function findByUser($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $finduser = $user->find('id', $args['id']);

        if ($finduser) {
            $data = $this->responseDetail(200, false, 'Berhasil menampilkan user berdasarkan id', [
                'data' => $finduser
            ]);
        } else {
            $data = $this->responseDetail(404, true, 'User tidak ditemukan');
        }

        return $data;
    }

    // Method show user man
    public function getAllUserMan($request, $response)
    {
        $user = new UserModel($this->db);
        $get = $user->getAllUserMan()->fetchAll();
        $gender = $user->find('gender');
        // var_dump($gender);die();
        $count = count($get);
        // var_dump($count);die;
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
    // Method show user woman
    public function getAllUserWoman($request, $response)
    {
        $user = new UserModel($this->db);
        $get = $user->getAllUserWoman();

        $countUser = count($get);
        // var_dump($countUser);die();
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getUser = $user->getAllUserWoman()->setPaginate($page, $perPage);

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
    // Method create Member
    public function createMember($request, $response)
    {
        $user = new UserModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

         $this->validator
        ->rule('required', ['username', 'gender', 'phone', 'email','password', 'role'])
        ->message('{field} harus diisi')
        ->label('Username', 'gender', 'Nomor Telepon', 'Email','password');
        $this->validator->rule('email', 'email');
        $this->validator->rule('alphaNum', 'username');
        $this->validator->rule('lengthMin', ['username', 'password'], 5);
        $this->validator->rule('lengthMax', ['username', 'password'], 50);

        if ($this->validator->validate()) {
            $register = $user->checkDuplicate($request->getParsedBody()['username'], $request->getParsedBody()['email']);
            if ($register == 3) {
                $data = $this->responseDetail(409, true, 'Username dan Email sudah digunakan');
            } elseif ($register == 1) {
                $data = $this->responseDetail(409, true, 'Username sudah digunakan');
            } elseif ($register == 2) {
                $data = $this->responseDetail(409, true, 'Email sudah digunakan');
            } else {
                if ($request->getParsedBody()['role'] == 0) {

                    $createMember = $user->createMember($request->getParsedBody());
                    $user->setActive($createMember);
                    $findUser = $user->find('id', $createMember);
                    $data = $this->responseDetail(201, false, 'User Berhasil Di Tambahkan', [
                            'data' => $findUser,
                        ]);
                } elseif ($request->getParsedBody()['role'] == 4) {
                    $createUserPremium = $user->createMember($request->getParsedBody());
                    $user->setActive($createUserPremium);
                    $findUser = $user->find('id', $createModerator);
                    $data = $this->responseDetail(201, false, 'User Premium Berhasil Di Tambahkan', [
                            'data' => $findUser,
                        ]);
                    
                } elseif ($request->getParsedBody()['role'] == 2) {
                    $createModerator = $user->createMember($request->getParsedBody());
                    $user->setApproveUser($createModerator);
                    $findUser = $user->find('id', $createModerator);
                    $data = $this->responseDetail(201, false, 'Moderator Berhasil Di Tambahkan', [
                            'data' => $findUser,
                        ]);
                } else {
                    $createAdmin = $user->createMember($request->getParsedBody());
                    $findUser = $user->find('id', $createAdmin);
                    $data = $this->responseDetail(201, false, 'Admin Berhasil Di Tambahkan', [
                            'data' => $findUser,
                        ]);
                }
        } 
    } else {
        $data = $this->responseDetail(400, true, $this->validator->errors());
    }
        return $data;
}

    // Method register
    public function register($request, $response)
    {
        $user = new UserModel($this->db);
        $mailer = new \App\Extensions\Mailers\Mailer();
        $registers = new RegisterModel($this->db);

        $this->validator
        ->rule('required', ['username', 'gender', 'phone', 'email','password'])
        ->message('{field} harus diisi')
        ->label('Username', 'gender', 'Nomor Telepon', 'Email','password');
        $this->validator->rule('email', 'email');
        $this->validator->rule('alphaNum', 'username');
        $this->validator->rule('numeric', 'phone');
        $this->validator->rule('lengthMin', ['username', 'password'], 5);
        $this->validator->rule('lengthMax', ['username', 'password'], 50);

        if ($this->validator->validate()) {
            $register = $user->checkDuplicate($request->getParsedBody()['username'], $request->getParsedBody()['email']);
            if ($register == 3) {
                $data = $this->responseDetail(409, true, 'Username dan Email sudah digunakan');
            } elseif ($register == 1) {
                $data = $this->responseDetail(409, true, 'Username sudah digunakan');
            } elseif ($register == 2) {
                $data = $this->responseDetail(409, true, 'Email sudah digunakan');
            } else {
                $userId = $user->register($request->getParsedBody());
                $newUser = $user->getUser('id', $userId);
                 $token = md5(openssl_random_pseudo_bytes(8));
                $tokenId = $registers->setToken($newUser['id'] , $token);
                $userToken = $registers->find('id', $tokenId);
                // var_dump($userToken);die();

                $keyToken = $userToken['token'];

                // $activateUrl = '< a href = '.$request->getUri()->getBaseUrl()."/activateaccount/".$keyToken.'>;
                $base = $request->getUri()->getBaseUrl();
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
            
                $data = $this->responseDetail(201, false, 'Pendaftaran berhasil. silakan verifikasi email anda', [
                    'data' => $newUser
                ]);
            }
        } else {
            $errors = $this->validator->errors();
            $data = $this->responseDetail(400, true, $errors);
        }
            return $data;
    }

    public function activateaccount($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $registers = new RegisterModel($this->db);

        $userToken = $registers->find('token', $args['token']);
        $base = $request->getUri()->getBaseUrl();
        $now = date('Y-m-d H:i:s');

        if ($userToken && $userToken['expired_date'] > $now) {

            $user = $user->setActive($userToken['user_id']);
            $registers->hardDelete($userToken['id']);
            // var_dump($user);die();
            // return $this->view->render($response, 'response/activation.twig');
            
            return  $this->view->render($response, 'response/activation.twig', [
                'message' => 'Akun telah berhasil diaktivasi, silahkan login'
            ]);
        } elseif ($userToken['expired_date'] > $now) {

            $data = $this->responseDetail(400, true, 'Token telah kadaluarsa atau sudah tidak dapat digunakan');

        } else{

            return  $this->view->render($response, 'response/activation.twig', [
                'message' => 'Token salah atau anda belum mendaftar atau akun anda sudah teraktivasi'
            ]);
        }
            return $data;
    }
    // Method Login
    public function login($request, $response)
    {
        $users = new UserModel($this->db);

        $login = $users->find('username', $request->getParam('username'));
        $user = $users->getUser('username', $request->getParam('username'));

        // $findStatus = $users->find('status', 0);
        // var_dump($user);die();
        if (empty($user)) {
            $data = $this->responseDetail(401, true, 'Username tidak terdaftar');
        } else {
            $check = password_verify($request->getParam('password'), $login['password']);
            if ($check) {
                $token = new UserToken($this->db);

                $token->setToken($login['id']);
                $getToken = $token->find('user_id', $login['id']);

                $key = [
                'key_token' => $getToken['token'],
                ];
                if ($user['role'] == 1) {
                    $data = $this->responseDetail(200, false, 'Admin Berhasi Login', [
                        'data'   => $user,
                        'key'     => $key
                    ]);
                } elseif ($user['role'] == 2 && $user['status'] == 2) {
                    $data = $this->responseDetail(200, false, 'Moderator Berhasil Login', [
                        'data'   => $user,
                        'key'     => $key
                    ]);
                } elseif ($user['status'] == 1 && $user['role'] == 0) {
                    $data = $this->responseDetail(200, false, 'Selamat Datang, silahkan isi data diri anda', [
                            'data' => $user,
                            'key' => $key
                        ]);
                //  Login Admin
                } elseif ($user['status'] == 0 ) {
                    $data = $this->responseDetail(400, true, 'Email belum diverifikasi, silahkan verifikasi email anda');
                } else {


                $data = $this->responseDetail(200, false, 'Login berhasil', [
                    'data'   => $user,
                    'key'     => $key
                ]);
                    }
                } else {
                    $data = $this->responseDetail(401, true, 'Password salah');
                }
        }
        return $data;
    }

    // public function login($request, $response)
    // {
    //     $users = new UserModel($this->db);
    //
    //     $login = $users->find('username', $request->getParam('username'));
    //     $user = $users->getUser('username', $request->getParam('username'));
    //
    //     // $findStatus = $users->find('status', 0);
    //     // var_dump($user['status == 1']);die();
    //     if (empty($user)) {
    //         $data = $this->responseDetail(401, true, 'Username tidak terdaftar');
    //     } else {
    //         $check = password_verify($request->getParam('password'), $login['password']);
    //         if ($check) {
    //             if ($user['status'] == 0) {
    //                 $data = $this->responseDetail(400, true, 'Silahkan menunggu persetujuan admin');
    //             } elseif ($user['status'] == 1) {
    //                 $data = $this->responseDetail(400, true, 'Akun sudah di setujui oleh admin, silahkan verifikasi email anda');
    //             } else {
    //             $token = new UserToken($this->db);
    //
    //             $token->setToken($login['id']);
    //             $getToken = $token->find('user_id', $login['id']);
    //
    //             $key = [
    //             'key_token' => $getToken['token'],
    //             ];
    //
    //             $data = $this->responseDetail(200, false, 'Login berhasil', [
    //                 'data'   => $user,
    //                 'key'     => $key
    //             ]);
    //                 }
    //             } else {
    //                 $data = $this->responseDetail(401, true, 'Password salah');
    //             }
    //     }
    //     return $data;
    // }

    public function forgotPassword($request, $response)
    {
        $users = new UserModel($this->db);
        $mailer = new \App\Extensions\Mailers\Mailer();
        $registers = new RegisterModel($this->db);

        $findUser = $users->find('email', $request->getParam('email'));

        if (!$findUser) {
            return $this->responseDetail(404, true, 'Email tidak terdaftar');

        } elseif ($findUser) {
            $data['new_password'] = substr(md5(microtime()),rand(0,26),7);
            $users->changePassword($data, $findUser['id']);

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
            color: rgb(255,255,255);line-height: 1.25;">Setel Ulang Sandi Match Making</td>
            <td width="32px"></td></tr>
            <tr><td colspan="3" height="18px"></td></tr></tbody></table></td></tr>
            <tr><td><table bgcolor="#FAFAFA" border="0" cellpadding="0" cellspacing="0"
             style="min-width: 332.0px;max-width: 600.0px;border: 1.0px solid rgb(240,240,240);
             border-bottom: 1.0px solid rgb(192,192,192);border-top: 0;" width="100%">
            <tbody><tr height="16px"><td rowspan="3" width="32px"></td><td></td>
            <td rowspan="3" width="32px"></td></tr>
            <tr><td><p>Yang terhormat '.$findUser["name"].',</p>
            <p>Baru-baru ini Anda meminta untuk menyetel ulang kata sandi akun Match Making Anda.
            Berikut ini adalah password sementara yang dapat Anda gunakan untuk login
            ke akun Match Making.</p>
            <p>Jika Anda tidak seharusnya menerima email ini, mungkin pengguna lain
            memasukkan alamat email Anda secara tidak sengaja saat mencoba menyetel
            ulang sandi. Jika Anda tidak memulai permintaan ini, silakan login dengan password
            berikut ini lalu ubahlah password Anda untuk keamanan akun.</p>
            <div style="text-align: center;"><p>
            <strong style="text-align: center;font-size: 24.0px;font-weight: bold;">
            '.$data["new_password"].'</strong></p></div>
            <p>Terima kasih, <br /><br /> Admin Match Making</p></td></tr>
            <tr height="32px"></tr></tbody></table></td></tr>
            <tr height="16"></tr>
            <tr><td style="max-width: 600.0px;font-family: Roboto-Regular , Helvetica , Arial , sans-serif;
            font-size: 10.0px;color: rgb(188,188,188);line-height: 1.5;"></td>
            </tr><tr><td></td></tr></tbody></table></body></html>';

            $mail = [
            'subject'   =>  'Setel Ulang Sandi',
            'from'      =>  'farhan.mustqm@gmail.com',
            'to'        =>  $findUser['email'],
            'sender'    =>  'Match Making Account Recovery',
            'receiver'  =>  $findUser['name'],
            'content'   =>  $content,
            ];

            $mailer->send($mail);

            return $this->responseDetail(200, false, 'Silakan cek email anda untuk mengubah password');
        }

    }

    public function getResetPassword($request, $response, $args)
    {
        $users = new UserModel($this->db);
        $registers = new RegisterModel($this->db);

        $findToken = $registers->find('token', $args['token']);

        if ($findToken) {
            $data = $this->responseDetail(200, false, 'Token diterima', [
                    'token' => $request->getParam('token')
                ]);
        } else {
            $data =  $this->responseDetail(404, true, 'Token salah');
        }
            return $data;
    }
    // Method change password from forgot password
    public function resetPassword($request, $response, $args)
    {
       $users = new UserModel($this->db);
        $registers = new RegisterModel($this->db);

        $this->validator->rule('required', ['email', 'password']);
        $this->validator->rule('equals', 'password2', 'password');
        $this->validator->rule('email', 'email');
        $this->validator->rule('lengthMin', ['password'], 5);

        if ($this->validator->validate()) {
            $findUser = $users->getUser('email', $request->getParam('email'));
            $findToken = $registers->find('token', $request->getParam('token'));
            // var_dump($findToken);die();
            if ($findUser['id'] == $findToken['user_id']) {
                $data['new_password'] = $request->getParam('password');
                $users->changePassword($data, $findUser['id']);
                $registers->hardDelete($findToken['id']);
                return $this->responseDetail(200, false, 'Password berhasil diperbarui', [
                    'data'  => $findUser
                ]);
            } else {
                return $this->responseDetail(404, true, 'Data tidak ditemukan', [
                    'data'  => [
                        'token' => $request->getParam('token')
                    ]
                ]);
            }
        } else {
            return $this->responseDetail(400, true, $this->validator->errors(), [
                'data'  => [
                    'token' => $request->getParam('token')
                ]
            ]);
        }
                return $data;
    }
    // Method Find User
    public function find($request, $response, $args)
    {

    }
    // Method soft delete user
    public function softDelete($request, $response, $args)
    {

    }
    // Method hard delete user
    public function hardDelete($request, $response, $args)
    {

    }
    // Method restore user
    public function restore($requst, $response, $args)
    {

    }

    public function postImage($request, $response)
    {
        $user = new UserModel($this->db);
// return $this->responseDetail(200, false, 'test', [
//                     'data' => 'ddd'
//                 ]);
        $id = $request->getParsedBody()['id'];
        $findUser = $user->getUser('id', $id);

        if (!$findUser) {
            $data = $this->responseDetail(404, true, 'Akun tidak ditemukan');
        }
            if (!empty($request->getUploadedFiles()['image'])) {
                $storage = new \Upload\Storage\FileSystem('assets/images');
                $image = new \Upload\File('image',$storage);

                $image->setName(uniqid('img-'.date('Ymd').'-'));
                $image->addValidations(array(
                    new \Upload\Validation\Mimetype(array('image/png', 'image/gif',
                    'image/jpg', 'image/jpeg')),
                    new \Upload\Validation\Size('5M')
                ));

                $image->upload();
                $data['photo'] = $image->getNameWithExtension();

                $user->updateData($data, $id);
                $newUser = $user->getUser('id', $id);
                if (file_exists('assets/images/'.$findUser['photo'])) {
                    unlink('assets/images/'.$findUser['photo']);
                }

            // } elseif (!empty($request->getUploadedFiles()['ktp'])) {
            //     $storage = new \Upload\Storage\FileSystem('assets/images');
            //     $image = new \Upload\File('ktp',$storage);

            //     $image->setName(uniqid('img-'.date('Ymd').'-'));
            //     $image->addValidations(array(
            //         new \Upload\Validation\Mimetype(array('image/png', 'image/gif',
            //         'image/jpg', 'image/jpeg')),
            //         new \Upload\Validation\Size('5M')
            //     ));

            //     $image->upload();
            //     $data['ktp'] = $image->getNameWithExtension();

            //     $user->updateData($data, $id);
            //     $newUser = $user->getUser('id', $id);
            //     if (file_exists('assets/images/'.$findUser['ktp']['ktp'])) {
            //         unlink('assets/images/'.$findUser['ktp']);
            //     }
            //     $data =  $this->responseDetail(200, false, 'Foto berhasil diunggah', [
            //         'data' => $newUser
            //     ]);


           
            }

            if (!empty($request->getUploadedFiles()['ktp'])) {
                $storage = new \Upload\Storage\FileSystem('assets/images');
                $image = new \Upload\File('ktp',$storage);

                $image->setName(uniqid('img-'.date('Ymd').'-'));
                $image->addValidations(array(
                    new \Upload\Validation\Mimetype(array('image/png', 'image/gif',
                    'image/jpg', 'image/jpeg')),
                    new \Upload\Validation\Size('5M')
                ));

                $image->upload();
                $data['ktp'] = $image->getNameWithExtension();

                $user->updateData($data, $id);
                $newUser = $user->getUser('id', $id);
                if (file_exists('assets/images/'.$findUser['ktp'])) {
                    unlink('assets/images/'.$findUser['ktp']);
                }
                return $this->responseDetail(200, false, 'File berhasil diunggah', [
                    'data' => $newUser
                ]);
            } elseif (empty($request->getUploadedFiles()['ktp']) 
                        && empty($request->getUploadedFiles()['image'])) {
                
                return $this->responseDetail(400, true, 'File belum dipilih');
                
            }
    }

    public function searchUserPria($request, $response)
    {
        $profil = new \App\Models\Users\ProfilModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userToken = new UserToken($this->db);
        $userId = $userToken->getUserId($token);
        $query = $request->getQueryParams();

        $search = $request->getParams()['search'];
        $data = $profil->joinSearchPria($search, $userId)->fetchAll();
        $get = count($data);

        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getUser = $profil->joinSearchPria($search, $userId)->setPaginate($page, $perPage);

            if ($getUser) {
                $data = $this->responseDetail(200, false,  'Berhasil menampilkan data search '.$search, [
                        'data'          =>  $getUser['data'],
                        'pagination'    =>  $getUser['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(404, false, 'Data search '.$search . ' ' . 'tidak ada');
        }

        return $data;
    }

     public function searchUserWanita($request, $response)
    {
        $profil = new \App\Models\Users\ProfilModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userToken = new UserToken($this->db);
        $userId = $userToken->getUserId($token);
        $query = $request->getQueryParams();

        $search = $request->getParams()['search'];
        $data = $profil->joinSearchWanita($search, $userId)->fetchAll();
        $get = count($data);

        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getUser = $profil->joinSearchWanita($search, $userId)->setPaginate($page, $perPage);

            if ($getUser) {
                $data = $this->responseDetail(200, false,  'Berhasil menampilkan data search '.$search, [
                        'data'          =>  $getUser['data'],
                        'pagination'    =>  $getUser['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(404, false, 'Data search '.$search . ' ' . 'tidak ada');
        }

        return $data;
    }

    public function sendRequest($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);
        $findUser = $requests->findTwo('id_terequest', $args['id'], 'id_perequest', $userId);
        $finds = $user->getUser('id', $userId);
        // var_dump();die;
        $find = $requests->getRequest('id_terequest', $args['id']);
        $getRequest = $requests->getRequest('id_terequest', $args['id']);
        // var_dump($getRequest['created_at']);die();
        $data = [
            'id_terequest'  =>  $args['id'],
            'id_perequest' => $userId,
        ];

        $update = [
            'created_at' => date('Y-m-d H:i:s', strtotime('+1 minutes')),
        ];
        // var_dump($req);die;
        if ($findUser) {
            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
            if ($find['id_perequest'] && $find['id_terequest'] && $find['blokir'] == 1 && $find['status'] == 1) {

                $send = $requests->sendRequestTwo($userId, $args['id']);
                $requests->updateData($update, $getRequest['id']);
                $data = $this->responseDetail(200, false, 'Berhasilkan mengirimkan request', [
                        'data' => $data
                    ]);
            } elseif ($find['id_perequest'] && $find['id_terequest'] && $find['blokir'] == 2 && $find['status'] == 2) {
                $requests->sendRequestThree($userId, $args['id']);
                $requests->updateData($update, $getRequest['id']);
                $data = $this->responseDetail(200, false, 'Berhasilkan mengirimkan request', [
                        'data' => $data
                    ]);
            } elseif ($find['id_perequest'] && $find['id_terequest'] && $find['status'] == 1 && $find['blokir'] == 0) {
                $data = $this->responseDetail(404, true, 'User sudah direquest');
            } elseif ($find['id_perequest'] && $find['id_terequest'] && $find['status'] == 2 && $find['blokir'] == 0) {
                $data = $this->responseDetail(404, true, 'User sedang proses dengan anda');   
            }
        } else {
            if ($finds['role'] == 0 && $finds['status'] == 1) {
                $data = $this->responseDetail(404, true, 'Anda belum bisa mengirimkan request, silahkan  lengkapi data diri anda dan tunggu disetujui oleh admin');
            } else {
                $sendRequest = $requests->createRequest($data);
                $requests->sendRequest($userId, $args['id']);
                $data = $this->responseDetail(200, false, 'Berhasilkan mengirimkan request', [
                        'data' => $data
                    ]);
            }

        }
        return $data;
    }

    public function approveRequest($request, $response, $args)
    {
        $users = new UserModel($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $findUser = $requests->findTwo('id_terequest', $userId, 'id_perequest', $args['id']);
        $find = $requests->getRequest('id_perequest', $args['id']);
        $count = count($requests->getTaarufUser($userId)->fetchAll());
        $finduserId = $users->find('id', $userId);
        // var_dump($finduserId);die();
        if ($findUser) {
            if ($find['status'] == 2) {
                $data = $this->responseDetail(200, true, 'Request sudah diterima', [
                        'data' => $find
                    ]);
            } elseif ($find['blokir'] == 1) {
                $data = $this->responseDetail(200, true, 'Request tidak bisa di approve');
            } else {
                if ($finduserId['role'] == 0 && $count == 1) {
                    $data = $this->responseDetail(404, true, 'Anda tidak bisa menerima request lebih dari satu, karena anda bukan member premium');  
                } else {
                    $approve = $requests->approveUser($args['id'], $userId);
                    $finds = $requests->find('id_perequest', $approve);

                    $data = $this->responseDetail(200, false, 'Berhasil menerima request', [
                            'data' => $finds
                        ]);
                }

        }
        } else {
            $data = $this->responseDetail(200, false, 'Data tidak ditemukan');
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

        $get = $requests->allNotification($userId);
        $find = $requests->getRequest('id_terequest', $userId);
        $findUser = $user->getUser('id', $userId);
        // var_dump($find['id_perequest']);die;
        // $gender = $user->find('gender');
        // var_dump(date('Y-m-d H:i:s'));die;
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getNotification = $requests->allNotification($userId)->setPaginate($page, $perPage);
            // $date = date('Y-m-d H:i:s');
            // var_dump($date);die;
            if ($getNotification) {
                if ($find['created_at'] <= date('Y-m-d H:i:s')) {
                    $data = $this->responseDetail(200, false,  'Data notification tersedia', [
                        'data'          =>  $getNotification['data'],
                        'pagination'    =>  $getNotification['pagination'],
                    ]);
                }
            } else {
                $data = $this->responseDetail(404, true, 'Notification tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }

     public function getAllRequestReject($request, $response)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $requests->getAllRequestReject($userId);
        // $gender = $user->find('gender');
        // var_dump($userId);die();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getNotification = $requests->getAllRequestReject($userId)->setPaginate($page, $perPage);

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

    public function getAllRequest($request, $response)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $requests->getAllRequest($userId);
        // $gender = $user->find('gender');
        // var_dump($userId);die();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getNotification = $requests->getAllRequest($userId)->setPaginate($page, $perPage);

            if ($getNotification) {
                $data = $this->responseDetail(200, false,  'Data notification request', [
                        'data'          =>  $getNotification['data'],
                        'pagination'    =>  $getNotification['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }

    public function blokirRequestUser($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $findUser = $requests->findTwo('id_terequest', $userId, 'id_perequest', $args['id']);
        $find = $requests->getRequest('id_perequest', $args['id']);

        // var_dump($find['blokir']);die();
        if ($findUser) {
            if ($find['blokir'] == 1) {
                $data = $this->responseDetail(404, true, 'Request sudah di tolak');
            } else {
            // $sendRequest = $requests->update($data);
            $blokir = $requests->blokirUser($args['id'], $userId);
            $data = $this->responseDetail(200, false, 'Request berhasil ditolak', [
                    'data' => $blokir
                ]);
        }
        } else {
            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
        }
        return $data;
    }

    public function getAllBlokirRequest($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $requests->getAllBlokir($userId);
        // $gender = $user->find('gender');
        $countUser = count($get);
        // var_dump($countUser);die();
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getNotification = $requests->getAllBlokir($userId)->setPaginate($page, $perPage);

            if ($getNotification) {
                $data = $this->responseDetail(200, false,  'Data request yang di tolak tersedia', [
                        'data'          =>  $getNotification['data'],
                        'pagination'    =>  $getNotification['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data request yang di tolak tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }

    public function logOut($request, $response)
    {
        $token = $request->getHeader('Authorization')[0];

        $userToken = new UserToken($this->db);
        $findUser = $userToken->find('token', $token);

        $userToken->delete('user_id', $findUser['user_id']);
        return $this->responseDetail(200, false, 'Logout berhasil');
    }

   public function searchUserAll($request, $response)
    {
        $user = new UserModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userToken = new UserToken($this->db);
        $userId = $userToken->getUserId($token);
        $query = $request->getQueryParams();

        $search = $request->getParams()['search'];
        $data = $user->searchUser($search, $userId)->fetchAll();
        $get = count($data);

        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getUser = $user->searchUser($search, $userId)->setPaginate($page, $perPage);

            if ($getUser) {
                $data = $this->responseDetail(200, false,  'Berhasil menampilkan data search '.$search, [
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

    public function changePassword($request, $response, $args)
    {
        $users = new UserModel($this->db);
        $userToken = new \App\Models\Users\UserToken($this->container->db);

        $token = $request->getHeader('Authorization')[0];
        $findUser = $userToken->find('token', $token);
        $user = $users->find('id', $findUser['user_id']);

        $password = password_verify($request->getParam('password'), $user['password']);
        // var_dump($request->getParams());die();

        if ($password) {
            $this->validator->rule('required', ['new_password', 'password']);
            $this->validator->rule('lengthMin', ['new_password'], 5);

            if ($this->validator->validate()) {
                $newData = [
                'password'  => password_hash($request->getParam('new_password'), PASSWORD_BCRYPT)
                ];
                $users->updateData($newData, $user['id']);
                $data = $findUser;

                return $this->responseDetail(200, false, 'Password berhasil diubah', [
                    'data'  => $data
                    ]);
            } else {
                return $this->responseDetail(400, true, 'Password minimal 5 karakter');
            }
        } else {
            return $this->responseDetail(400, true, 'Password lama tidak sesuai');
        }
    }

    public function cancelRequest($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $userToken = new UserToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $findUser = $requests->find('id', $args['id']);
        // var_dump($userId);die;
        if ($findUser) {
            $cancel = $requests->cancelRequest($args['id']);
            // var_dump($cancel);die;
            $findUser = $requests->find('id', $args['id']);

            $data = $this->responseDetail(201, false, 'Request Berhasil Di cancel', [
                    'data' => $finduser,
                ]);

        } else {
            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
        }

        return $data;
    }

     public function getAllBlokirRequestUser($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $requests->getAllBlokirRequest();
        // $gender = $user->find('gender');
        $countUser = count($get);
        // var_dump($countUser);die();
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getNotification = $requests->getAllBlokirRequest()->setPaginate($page, $perPage);

            if ($getNotification) {
                $data = $this->responseDetail(200, false,  'Data request yang di tolak tersedia', [
                        'data'          =>  $getNotification['data'],
                        'pagination'    =>  $getNotification['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data request yang di tolak tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }


    public function deleteNotification($request, $response, $args)
    {
      $requests = new \App\Models\Users\RequestModel($this->db);
      $userToken = new UserToken($this->db);
      $token = $request->getHeader('Authorization')[0];
      $userId = $userToken->getUserId($token);

      $findUser = $requests->findTwo('id_terequest', $args['id'], 'id_perequest', $userId);
      // var_dump($findUser);die;
      if ($findUser) {
          $requests->deleteNotification($args['id']);
          $findUsers = $requests->findTwo('id_terequest', $args['id'], 'id_perequest', $userId);
          $data = $this->responseDetail(200, false, 'Notification berhasil dihapus', [
                'data' => $findUsers,
            ]);
      } else {
          $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
      }
        return $data;
      
    }


    public function findRequest($request, $response, $args)
    {
          $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $findUser = $requests->findTwoRequest('id_perequest', $userId, 'id_terequest', $args['id']);
        // var_dump($findUser);die;

        if ($findRequest) {
            return $data = $this->responseDetail(200, false, 'Data tersedia');
        } else {
            return $data = $this->responseDetail(404, false, 'Data tidak ditemukan');
        }
    }

     public function getTaarufUser($request, $response)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $requests->getTaarufUser($userId);
        // $gender = $user->find('gender');
        // var_dump($userId);die();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getNotification = $requests->getTaarufUser($userId)->setPaginate($page, $perPage);

            if ($getNotification) {
                $data = $this->responseDetail(200, false,  'Data taaruf tersedia', [
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

    public function changeImage($request, $response)
    {
        $user = new UserModel($this->db);
        $userToken = new userToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);
        $img = new \App\Models\Users\ImageModel($this->db);

       $findUser = $user->getUser('id', $userId);
       $findImage = $img->getImages('user_id', $userId);

       // var_dump($findUser);die;
        if (!$findUser) {
            return $this->responseDetail(404, true, 'Akun tidak ditemukan');
        }
        if ($this->validator->validate()) {

            if (!empty($request->getUploadedFiles()['images'])) {
                $storage = new \Upload\Storage\FileSystem('assets/images');
                $image = new \Upload\File('images',$storage);

                $image->setName(uniqid('img-'.date('Ymd').'-'));
                $image->addValidations(array(
                    new \Upload\Validation\Mimetype(array('image/png', 'image/gif',
                    'image/jpg', 'image/jpeg')),
                    new \Upload\Validation\Size('2M')
                ));

                $image->upload();
                $data['user_id'] = $userId;
                $data['images'] = $image->getNameWithExtension();
                $photo['photo'] = $image->getNameWithExtension();
                // var_dump($data);die;
                $img->postImage($data);
                $user->updateData($photo, $userId);
                // $newImg = $img->find('id', $userId);
                if (file_exists('assets/images/'.$findImage['images'])) {
                    // unlink('assets/images/'.$findImage['images']);die();
                }
                return  $this->responseDetail(200, false, 'Foto berhasil diunggah', [
                    'data' => $findImage
                ]);

            } else {
                return $this->responseDetail(400, true, 'File foto belum dipilih');

            }
        } else {
            $errors = $this->validator->errors();

            return  $this->responseDetail(400, true, $errors);
        }      
    }

    public function getImageUser($request, $response)
    {
        $user = new UserModel($this->db);
        $img = new \App\Models\Users\ImageModel($this->db);
        $userToken = new userToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        $get = $img->getImage($userId);
        $gender = $user->find('gender');
        // var_dump($gender);die();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getUser = $img->getImage($userId)->setPaginate($page, $perPage);

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

    public function postChangeImage($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $img = new \App\Models\Users\ImageModel($this->db);
        $userToken = new userToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        // $findImage = $img->find('images', $args['images']);
        $images = $img->getImages('images', $args['images']);
        // var_dump($images['images']);die;
        $data['photo'] = $images['images'];
        // var_dump($userId);die;
        if ($images) {
            $update = $user->updateData($data, $userId);
            $images = $user->find('photo', $args['images']);
            $data = $this->responseDetail(200, false, 'Foto berhasil di perbarui', [
                    'data' => $images
                ]);
        } else {
            $data = $this->responseDetail(404, true, 'Foto tidak ditemukan');
        }
            return $data;
    }

     public function deleteImageGalery($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $img = new \App\Models\Users\ImageModel($this->db);
        $userToken = new userToken($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userId = $userToken->getUserId($token);

        // $findImage = $img->find('images', $args['images']);
        $findImage = $img->find('id', $args['id']);
        // var_dump($images['images']);die;
        // $data['photo'] = $images['images'];
        // var_dump($userId);die;
        if ($findImage) {
            $delete = $img->deleteImage($args['id'], $userId);
            $images = $img->find('id', $args['id']);
            $data = $this->responseDetail(200, false, 'Foto berhasil di hapus', [
                    'data' => $images
                ]);
        } else {
            $data = $this->responseDetail(404, true, 'Foto tidak ditemukan');
        }
            return $data;
    }

    //  public function findImage($request, $response, $args)
    // {
    //     $img = new ImageModel($this->db);
    //     $userToken = new userToken($this->db);
    //     $token = $request->getHeader('Authorization')[0];
    //     $userId = $userToken->getUserId($token);
    //     $finduser = $img->find('user_id', $args['id']);
    //     var_dump($find['blokir']);die;
    //     // if ($finduser) {
    //     //     $data = $this->responseDetail(200, false, 'Berhasil menampilkan user berdasarkan id', [
    //     //         'data' => $finduser
    //     //     ]);
    //     // } else {
    //     //     $data = $this->responseDetail(404, true, 'User tidak ditemukan');
    //     // }

    //     // return $data;
    // }

}
