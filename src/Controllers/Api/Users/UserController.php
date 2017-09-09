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
            $getUser = $user->getAllData()->setPaginate($page, 10);

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
            $getUser = $user->getAllNewUser()->setPaginate($page, 10);

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
        $get = $user->getAllUserMan();
        $gender = $user->find('gender');
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
            $getUser = $user->getAllUserWoman()->setPaginate($page, 5);

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
    // Method register
    public function register($request, $response)
    {
        $user = new UserModel($this->db);
        $registers = new RegisterModel($this->db);

        $this->validator
        ->rule('required', ['username', 'gender', 'phone', 'email', 'photo', 'ktp', 'password'])
        ->message('{field} harus diisi')
        ->label('Username', 'gender', 'Nomor Telepon', 'Email', 'Foto', 'Foto ktp', 'password');
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
                $userId = $user->register($request->getParsedBody());
                $newUser = $user->getUser('id', $userId);

                $data = $this->responseDetail(201, false, 'Pendaftaran berhasil. silakan menunggu persetujuan admin', [
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
            $data = $this->responseDetail(200, false, 'Akun berhasil diverifikasi');
        } elseif ($userToken['expired_date'] > $now) {

            $data = $this->responseDetail(400, true, 'Token telah kadaluarsa atau sudah tidak dapat digunakan');

        } else{

            $data = $this->responseDetail(400, true, 'Token salah atau anda belum mendaftar');
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
        // var_dump($user['status == 1']);die();
        if (empty($user)) {
            $data = $this->responseDetail(401, true, 'Username tidak terdaftar');
        } else {
            $check = password_verify($request->getParam('password'), $login['password']);
            if ($check) {
                if ($user['status'] == 0) {
                    $data = $this->responseDetail(400, true, 'Silahkan menunggu persetujuan admin');
                } elseif ($user['status'] == 1) {
                    $data = $this->responseDetail(400, true, 'Akun sudah di setujui oleh admin, silahkan verifikasi email anda');
                } else {    
                $token = new UserToken($this->db);

                $token->setToken($login['id']);
                $getToken = $token->find('user_id', $login['id']);

                $key = [
                'key_token' => $getToken['token'],
                ];

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

    public function postImage($request, $response, $args)
    {
        $user = new UserModel($this->db);

        $findUser = $user->getUser('id', $args['id']);

        if (!$findUser) {
            $data = $this->responseDetail(404, true, 'Akun tidak ditemukan');
        }
        if ($this->validator->validate()) {

            if (!empty($request->getUploadedFiles()['photo'])) {
                $storage = new \Upload\Storage\FileSystem('assets/images');
                $image = new \Upload\File('photo',$storage);

                $image->setName(uniqid('img-'.date('Ymd').'-'));
                $image->addValidations(array(
                    new \Upload\Validation\Mimetype(array('image/png', 'image/gif',
                    'image/jpg', 'image/jpeg')),
                    new \Upload\Validation\Size('5M')
                ));

                $image->upload();
                $data['photo'] = $image->getNameWithExtension();

                $user->updateData($data, $args['id']);
                $newUser = $user->getUser('id', $args['id']);
                if (file_exists('assets/images/'.$findUser['photo']['ktp'])) {
                    unlink('assets/images/'.$findUser['photo']);die();
                }
                $data =  $this->responseDetail(200, false, 'Foto berhasil diunggah', [
                    'data' => $newUser
                ]);

            } else {
                $data = $this->responseDetail(400, true, 'File foto belum dipilih');

            }
        } else {
            $errors = $this->validator->errors();

            $data =  $this->responseDetail(400, true, $errors);
        }
            return $data;   
    }

    public function searchUser($request, $response)
    {
        $user = new UserModel($this->db);
        $profil = new \App\Models\Users\ProfilModel($this->db);
        $token = $request->getHeader('Authorization')[0];
        $userToken = new UserToken($this->db);
        $userId = $userToken->getUserId($token);
        $query = $request->getQueryParams();

        $search = $request->getParams()['search'];

        $data['user'] = $profil->joinSearch($search, $userId);
        $data['count'] = count($data['user']);

        if ($data['count']) {
            $data = $this->responseDetail(200, false, 'Berhasil menampilkan data search '.$search, [
                    'query'     =>  $query,
                    'data'    =>  $data
                ]);
        } else {
            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
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
        $find = $user->getUser('id', $args['id']);
        // var_dump($find['role']);die();
        $data = [
            'id_terequest'  =>  $args['id'],
            'id_perequest' => $userId,  
        ];
        
        if ($findUser) {
            $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
        } else {
            $sendRequest = $requests->createRequest($data);
            $requests->sendRequest($sendRequest);
            $data = $this->responseDetail(200, false, 'Berhasilkan mengirimkan request', [
                    'data' => $data
                ]);
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
        // var_dump($find['blokir']);die();
        if ($findUser) {
            if ($find['status'] == 2) {
                $data = $this->responseDetail(200, false, 'Request sudah diterima');  
            } elseif ($find['blokir'] == 1) {
                $data = $this->responseDetail(200, false, 'Request tidak bisa di approve');  
            } else {
                $approve = $requests->approveUser($args['id'], $args['id']);
                $finds = $requests->find('id_perequest', $approve);

                $data = $this->responseDetail(200, false, 'Berhasil menerima request', [
                        'data' => $approve
                    ]);
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
        // $gender = $user->find('gender');
        // var_dump($userId);die();
        $countUser = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $getNotification = $requests->allNotification($userId)->setPaginate($page, 5);

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
            $getNotification = $requests->getAllRequest($userId)->setPaginate($page, 5);

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
            $getNotification = $requests->getAllBlokir($userId)->setPaginate($page, 5);

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

}
// 