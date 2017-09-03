<?php 

namespace App\Controllers\Api\Users;

use App\Models\Users\UserModel;
use App\Models\Users\UserToken;
use App\Models\Users\RegisterModel;
use App\Controllers\Api\BaseController;

class UserController extends BaseController
{
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
        $gender = $user->find('gender');
        // var_dump($gender);die();
        $countUser = count($get);
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
        $mailer = new \App\Extensions\Mailers\Mailer();
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

                $token = md5(openssl_random_pseudo_bytes(8));
                $tokenId = $registers->setToken($userId, $token);
                $userToken = $registers->find('id', $tokenId);
                // var_dump($userToken);die();

                $keyToken = $userToken['token'];
                // $activateUrl = '< a href = '.$request->getUri()->getBaseUrl()."/activateaccount/".$keyToken.'>;

                 $activateUrl = '<a href ='.$base ."/activateaccount/".$keyToken.'>

                // <h3>AKTIFKAN AKUN</h3></a>';
                // $content = "Terima kasih telah mendaftar di Match making.
                // Untuk mengaktifkan akun Anda, silakan klik link di bawah ini.
                // <br /> <br />" .$activateUrl."<br /> <br />
                // Jika link tidak bekerja, Anda dapat menyalin atau mengetik kembali
                // link di bawah ini. <br /><br /> " .$base ."/activateaccount/".$keyToken.
                // " <br /><br /> Terima kasih, <br /><br /> Admin Match making";
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

                $data = $this->responseDetail(201, false, 'Pendaftaran berhasil.
                silakan cek email anda untuk mengaktifkan akun', [
                    'data' => $newUser
                ]);
            }
        } else {
            $errors = $this->validator->errors();
            $data = $this->responseDetail(400, true, $errors);
        }
            return $data;
    }

    public function activateaccount($request, $response)
    {
        $user = new UserModel($this->db);
        $registers = new \App\Models\RegisterModel($this->db);

        $userToken = $registers->find('token', $args['token']);
        $base = $request->getUri()->getBaseUrl();
        $now = date('Y-m-d H:i:s');

        if ($userToken && $userToken['expired_date'] > $now) {

            $user = $user->setActive($userToken['user_id']);
            $registers->hardDelete($userToken['id']);

            return  $this->view->render($response, 'response/activation.twig', [
                'message' => 'Akun telah berhasil diaktivasi'
            ]);

        } elseif ($userToken['expired_date'] > $now) {

            return  $this->view->render($response, 'response/activation.twig', [
                'message' => 'Token telah kadaluarsa'
            ]);
            // return $this->responseDetail(400, true, 'Token telah kadaluarsa');

        } else{

            return  $this->view->render($response, 'response/activation.twig', [
                'message' => 'Token salah atau anda belum mendaftar'
            ]);
            // return $this->responseDetail(400, true, 'Anda belum mendaftar');
        }
    }
    // Method Login
    public function login($request, $response)
    {
        $users = new UserModel($this->db);

        $login = $users->find('username', $request->getParam('username'));
        $user = $users->getUser('username', $request->getParam('username'));

        if (empty($login)) {
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

                $data = $this->responseDetail(200, false, 'Login berhasil', [
                    'data'   => $user,
                    'key'     => $key
                ]);
            } else {
                $data = $this->responseDetail(401, true, 'Password salah');
            }
        }
        return $data;
    }

    //  Method forgot password
    public function forgotPassword($request, $response)
    {
        $users = new UserModel($this->db);
        $mailer = new \App\Extensions\Mailers\Mailer();
        $registers = new RegisterModel($this->db);

        $findUser = $users->find('email', $request->getParam('email'));
        $base = $request->getUri()->getBaseUrl();

        if (!$findUser) {
            return $this->responseDetail(404, true, 'Email tidak terdaftar');
        } elseif($findUser) {

            $token = str_shuffle('r3c0Ve12y').substr(md5(microtime()),rand(0,26),37);
            $tokenId = $registers->setToken($findUser['id'], $token);
            // $data['new_password'] = substr(md5(microtime()),rand(0,26),17);
            // $users->changePassword($data, $findUser['id']);

            $resetUrl = '<a href ='.$base ."/password/reset/".$token.'>
            <h3>RESET PASSWORD</h3></a>';
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
              Untuk mengubah kata sandi akun Anda, silakan ikuti tautan di bawah ini.</p>
              <div style="text-align: center;"><p>'.$resetUrl.'</p></div>
             <p>Jika tautan tidak bekerja, Anda dapat menyalin atau mengetik kembali
            tautan berikut.</p>
            <p>'.$base."/password/reset/".$token.'</p>
            <p>Jika Anda tidak seharusnya menerima email ini, mungkin pengguna lain
            memasukkan alamat email Anda secara tidak sengaja saat mencoba menyetel
            ulang sandi. Jika Anda tidak memulai permintaan ini, Anda tidak perlu
            melakukan tindakan lebih lanjut dan dapat mengabaikan email ini dengan aman.</p>
            <p> <br />Terima kasih, <br /><br /> Admin Match Making</p></td></tr>
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
            return $this->responseDetail(404, true, 'Akun tidak ditemukan');
        }
        if ($this->validator->validate()) {

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
                $data['image'] = $image->getNameWithExtension();

                $user->updateData($data, $args['id']);
                $newUser = $user->getUser('id', $args['id']);
                if (file_exists('assets/images/'.$findUser['image'])) {
                    unlink('assets/images/'.$findUser['image']);die();
                }
                return  $this->responseDetail(200, false, 'Foto berhasil diunggah', [
                    'result' => $newUser
                ]);

            } else {
                return $this->responseDetail(400, true, 'File foto belum dipilih');

            }
        } else {
            $errors = $this->validator->errors();

            return  $this->responseDetail(400, true, $errors);
        }

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

        $data['user'] = $profil->search($search, $userId);
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

}
