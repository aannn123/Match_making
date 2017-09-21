<?php 

namespace App\Controllers\Web;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\BadResponseException as GuzzleException;
use GuzzleHttp;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class UserController extends BaseController
{
    public function home(Request $request, Response $response)
    {
        $users = new \App\Models\Users\UserModel($this->db);

        $allUser = count($users->getAllData()->fetchAll());
          
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.show.profile'), [
                    'query' => [
                        'perpage' => 9,
                        'page'    => $request->getQueryParam('page')
                    ]
                ]);


            } catch (GuzzleException $e) {
                $result = $e->getResponse();
            }

            $data = json_decode($result->getBody()->getContents(), true);
    // var_dump($data);die();
     
    return $this->view->render($response, 'user/user.twig', [
        'data'          =>  $data['data'] ,
        'counts' => [
            'allUser' => $allUser
        ],
        'pagination'    =>  $data['pagination']
    ]);    //
    }
    public function getRegister(Request $request, Response $response)
    {
        return $this->view->render($response, 'auth/register.twig');
    }

    public function register(Request $request, Response $response)
    {
        $this->validator->rule('required', ['username', 'email', 'password', 'phone', 'gender', 'photo', 'ktp'])
        ->labels(array(
            'username' => 'Username', 
            'email' => 'Email', 
            'password' => 'Password', 
            'phone' => 'Nomor Telepon', 
            'gender' => 'Jenis Kelamin', 
            'photo' => 'Foto', 
            'ktp' => 'Foto ktp'
        ));
        $this->validator->rule('email', 'email');
        $this->validator->rule('numeric', 'phone');
        $this->validator->rule('alphaNum', 'username');
        $this->validator->rule('lengthMin', ['username', 'password'], 5);
        $this->validator->rule('lengthMax', ['username', 'password'], 20);
        try {
               $result = $this->client->request('POST',
               $this->router->pathFor('register'),
                   ['form_params' => [
                       'username' => $request->getParam('username'),
                       'email' => $request->getParam('email'),
                       'phone' => $request->getParam('phone'),
                       'password' => $request->getParam('password'),
                       'gender' => $request->getParam('gender'),
                       'photo' => $request->getParam('photo'),
                       'ktp' => $request->getParam('ktp'),
                   ]
               ]);
           } catch (GuzzleException $e) {
               $result = $e->getResponse();
           }
           $data = json_decode($result->getBody()->getContents(), true);
           
            // var_dump($data['message']);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 201 ) {
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.login'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.register'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.register'));
       }
    }

    public function getLogin(Request $request, Response $response)
    {
        return $this->view->render($response, 'auth/login-user.twig');
    }

    public function login(Request $request, Response $response)
    {
         try {
               $result = $this->client->request('POST',
               $this->router->pathFor('api.user.login'),
                   ['form_params' => [
                       'username' => $request->getParam('username'),
                       'password' => $request->getParam('password')
                   ]
               ]);
           } catch (GuzzleException $e) {
               $result = $e->getResponse();
           }
           $data = json_decode($result->getBody()->getContents(), true);
// var_dump($data);die;
           if ($data['code'] == true ) {
                $_SESSION['key'] = $data['key'];
                $_SESSION['login'] = $data['data'];
                // var_dump($_SESSION['login']['role'] == 1);die();
               if ($_SESSION['login']['role'] == 0 && $_SESSION['login']['status'] == 2 ) {
                   return $response->withRedirect($this->router->pathFor('user.home'));
               } elseif ($_SESSION['login']['role'] == 2 && $_SESSION['login']['status'] == 2) {
                   return $response->withRedirect($this->router->pathFor('admin.home'));
               } elseif($_SESSION['login']['role'] == 0 && $_SESSION['login']['status'] == 0) {
                   $this->flash->addMessage('error_material', $data['message']);
                   return $response->withRedirect($this->router->pathFor('user.login'));
               } elseif($_SESSION['login']['role'] == 0 && $_SESSION['login']['status'] == 1) {
                $this->flash->addMessage('error_material', $data['message']);
                   return $response->withRedirect($this->router->pathFor('user.login'));
                } else {
                    $this->flash->addMessage('warning_material', 'Anda bukan user');
                   return $response->withRedirect($this->router->pathFor('user.login'));
                }
           } else {
               $this->flash->addMessage('error_material', 'Username atau password tidak cocok');
               return $response->withRedirect($this->router->pathFor('user.login'));
           }
    }

    public function getForgotPassword(Request $request, Response $response)
    {
        return $this->view->render($response, 'auth/forgot-password.twig');
    }

    public function forgotPassword(Request $request, Response $response)
    {
         try {
               $result = $this->client->request('POST',
               $this->router->pathFor('api.forgot.password'),
                   ['form_params' => [
                       'email' => $request->getParam('email'),
                   ]
               ]);
           } catch (GuzzleException $e) {
               $result = $e->getResponse();
           }
           $data = json_decode($result->getBody()->getContents(), true);
           // var_dump($data['data']);die();

           if ($data['code'] == 200 ) {
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('forgot.password'));
                } else {
                   $this->flash->addMessage('error_material', $data['message']);
                   return $response->withRedirect($this->router->pathFor('forgot.password'));
                }
    }

    public function getAllUserPria(Request $request,Response $response)
    {
        try {
                $result = $this->client->request('GET',
                $this->router->pathFor('api.show.profile'), [
                        'query' => [
                            'perpage' => 9,
                            'page'    => $request->getQueryParam('page')
                        ]
                    ]);


                } catch (GuzzleException $e) {
                    $result = $e->getResponse();
                }

                $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data);die();
         
        return $this->view->render($response, 'user/user.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    //
    }

    public function getCreateProfil(Request $request, Response $response)
    {   
        try {
                $result2 = $this->client->request('GET',
                $this->router->pathFor('admin.negara'), [
                        'query' => [
                            'perpage' => 9,
                            'page'    => $request->getQueryParam('page')
                        ]
                    ]);


                } catch (GuzzleException $e) {
                    $result2 = $e->getResponse();
                }

                $negara = json_decode($result2->getBody()->getContents(), true);

                    try {
                    $result3 = $this->client->request('GET',
                    $this->router->pathFor('admin.provinsi'), [
                            'query' => [
                                'perpage' => 9,
                                'page'    => $request->getQueryParam('page')
                            ]
                        ]);


                    } catch (GuzzleException $e) {
                        $result3 = $e->getResponse();
                    }

                    $provinsi = json_decode($result3->getBody()->getContents(), true);

                        try {
                        $result3 = $this->client->request('GET',
                        $this->router->pathFor('api.admin.kota'), [
                                'query' => [
                                    'perpage' => 9,
                                    'page'    => $request->getQueryParam('page')
                                ]
                            ]);


                        } catch (GuzzleException $e) {
                            $result3 = $e->getResponse();
                        }

                        $kota = json_decode($result3->getBody()->getContents(), true);
                        // var_dump($kota);die;
        return $this->view->render($response, 'user/data/form/profil.twig', [
            'negara'          =>  $negara['data'] ,
            'provinsi'          =>  $provinsi['data'] ,
            'kota'          =>  $kota['data'] ,
        ]);    
    }

    public function createProfil(Request $request, Response $response)
    {   
        $this->validator->rule('required', ['nama_lengkap', 'tanggal_lahir', 'tempat_lahir', 'alamat', 'umur', 'kota', 'provinsi', 'kewarganegaraan', 'target_menikah', 'tentang_saya', 'pasangan_harapan']);
        // ->labels(array(
        //     'username' => 'Username', 
        //     'email' => 'Email', 
        //     'password' => 'Password', 
        //     'phone' => 'Nomor Telepon', 
        //     'gender' => 'Jenis Kelamin', 
        //     'photo' => 'Foto', 
        //     'ktp' => 'Foto ktp'
        // ));
    $id = $_SESSION['login']['id'];
    // var_dump($_SESSION['login']['id']);die;
        try {
               $result = $this->client->request('POST',
               $this->router->pathFor('api.user.create.profil'),
                   ['form_params' => [
                       'user_id'     => $_SESSION['login']['id'],
                       'nama_lengkap' => $request->getParam('nama_lengkap'),
                       'tanggal_lahir' => $request->getParam('tanggal_lahir'),
                       'tempat_lahir' => $request->getParam('tempat_lahir'),
                       'alamat' => $request->getParam('alamat'),
                       'umur' => $request->getParam('umur'),
                       'kota' => $request->getParam('kota'),
                       'provinsi' => $request->getParam('provinsi'),
                       'kewarganegaraan' => $request->getParam('kewarganegaraan'),
                       'target_menikah' => $request->getParam('target_menikah'),
                       'tentang_saya' => $request->getParam('tentang_saya'),
                       'pasangan_harapan' => $request->getParam('pasangan_harapan'),
                       // 'user_id' => 4,
                       // 'nama_lengkap' => 'Farhan ' ,
                       // 'tanggal_lahir' =>  '2017-09-05',
                       // 'tempat_lahir' => 'dasdas',
                       // 'alamat' =>  'dasdsa',
                       // 'umur' => 2,
                       // 'kota' => 2,
                       // 'provinsi' => 2 ,
                       // 'kewarganegaraan' => 2,
                       // 'target_menikah' => '2017-09-05' ,
                       // 'tentang_saya' =>  'asdsad',
                       // 'pasangan_harapan' => 'dasdas' ,
                   ],
               ]);
           } catch (GuzzleException $e) {
               $result = $e->getResponse();
           }
           $data = json_decode($result->getBody()->getContents(), true);
           
            // var_dump($data['message']);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 201 ) {
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.profil'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.profil'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.create.profil'));
       }
    }

    public function getCreateKeseharian(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/data/form/keseharian.twig');
    }

    public function createKeseharian(Request $request, Response $response)
    {
        $this->validator->rule('required', ['pekerjaan', 'merokok', 'status_pekerjaan', 'penghasilan_per_bulan', 'status', 'jumlah_anak', 'status_tinggal', 'memiliki_cicilan', 'bersedia_pindah_tinggal']);
        // ->labels(array(
        //     'username' => 'Username', 
        //     'email' => 'Email', 
        //     'password' => 'Password', 
        //     'phone' => 'Nomor Telepon', 
        //     'gender' => 'Jenis Kelamin', 
        //     'photo' => 'Foto', 
        //     'ktp' => 'Foto ktp'
        // ));
    $id = $_SESSION['login']['id'];
    // var_dump($_SESSION['login']['id']);die;
        try {
               $result = $this->client->request('POST',
               $this->router->pathFor('api.user.create.keseharian'),
                   ['form_params' => [
                       'user_id'     => $_SESSION['login']['id'],
                       'pekerjaan' => $request->getParam('pekerjaan'),
                       'merokok' => $request->getParam('merokok'),
                       'status_pekerjaan' => $request->getParam('status_pekerjaan'),
                       'penghasilan_per_bulan' => $request->getParam('penghasilan_per_bulan'),
                       'status' => $request->getParam('status'),
                       'jumlah_anak' => $request->getParam('jumlah_anak'),
                       'status_tinggal' => $request->getParam('status_tinggal'),
                       'memiliki_cicilan' => $request->getParam('memiliki_cicilan'),
                       'bersedia_pindah_tinggal' => $request->getParam('bersedia_pindah_tinggal'),
                   ],
               ]);
           } catch (GuzzleException $e) {
               $result = $e->getResponse();
           }
           $data = json_decode($result->getBody()->getContents(), true);
           
            var_dump($data['message']);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 201 ) {
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.keseharian'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.keseharian'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.create.keseharian'));
       }
    }

    public function getCreateLatarBelakang(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/data/form/latar-belakang.twig');
    }

    public function createLatarBelakang(Request $request, Response $response)
    {
          $this->validator->rule('required', ['pendidikan', 'penjelasan_pendidikan', 'agama', 'penjelasan_agama', 'muallaf', 'baca_quran', 'hafalan', 'keluarga', 'penjelasan_keluarga', 'shalat']);
        // ->labels(array(
        //     'username' => 'Username', 
        //     'email' => 'Email', 
        //     'password' => 'Password', 
        //     'phone' => 'Nomor Telepon', 
        //     'gender' => 'Jenis Kelamin', 
        //     'photo' => 'Foto', 
        //     'ktp' => 'Foto ktp'
        // ));
    $id = $_SESSION['login']['id'];
    // var_dump($_SESSION['login']['id']);die;
        try {
               $result = $this->client->request('POST',
               $this->router->pathFor('api.user.create.latar-belakang'),
                   ['form_params' => [
                       'user_id'     => $_SESSION['login']['id'],
                       'pendidikan' => $request->getParam('pendidikan'),
                       'penjelasan_pendidikan' => $request->getParam('penjelasan_pendidikan'),
                       'agama' => $request->getParam('agama'),
                       'penjelasan_agama' => $request->getParam('penjelasan_agama'),
                       'muallaf' => $request->getParam('muallaf'),
                       'baca_quran' => $request->getParam('baca_quran'),
                       'hafalan' => $request->getParam('hafalan'),
                       'keluarga' => $request->getParam('keluarga'),
                       'penjelasan_keluarga' => $request->getParam('penjelasan_keluarga'),
                       'shalat' => $request->getParam('shalat'),
                   ],
               ]);
           } catch (GuzzleException $e) {
               $result = $e->getResponse();
           }
           $data = json_decode($result->getBody()->getContents(), true);
           
            // var_dump($data['message']);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 201 ) {
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.latar-belakang'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.latar-belakang'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.create.latar-belakang'));
       }
    }

    public function getCreateCiriFisik(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/data/form/ciri-fisik.twig');
    }

    public function createCiriFisik(Request $request, Response $response)
    {
         $this->validator->rule('required', ['tinggi', 'berat', 'warna_kulit', 'suku', 'kaca_mata', 'status_kesehatan', 'ciri_fisik_lain', 'jenggot', 'hijab', 'cadar']);
        // ->labels(array(
        //     'username' => 'Username', 
        //     'email' => 'Email', 
        //     'password' => 'Password', 
        //     'phone' => 'Nomor Telepon', 
        //     'gender' => 'Jenis Kelamin', 
        //     'photo' => 'Foto', 
        //     'ktp' => 'Foto ktp'
        // ));
    // $id = $_SESSION['login']['id'];
    // var_dump($_SESSION['login']['id']);die;
        try {
               $result = $this->client->request('POST',
               $this->router->pathFor('api.user.create.ciri.fisik.pria'),
                   ['form_params' => [
                       'user_id'     => $_SESSION['login']['id'],
                       'tinggi' => $request->getParam('tinggi'),
                       'berat' => $request->getParam('berat'),
                       'warna_kulit' => $request->getParam('warna_kulit'),
                       'suku' => $request->getParam('suku'),
                       'kaca_mata' => $request->getParam('kaca_mata'),
                       'status_kesehatan' => $request->getParam('status_kesehatan'),
                       'ciri_fisik_lain' => $request->getParam('ciri_fisik_lain'),
                       'jenggot' => $request->getParam('jenggot'),
                       'cadar' => $request->getParam('cadar'),
                       'hijab' => $request->getParam('hijab'),
                   ],
               ]);
           } catch (GuzzleException $e) {
               $result = $e->getResponse();
           }
           $data = json_decode($result->getBody()->getContents(), true);
           
            // var_dump($data['message']);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 201 ) {
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.ciri-fisik'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.ciri-fisik'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.create.ciri-fisik'));
       }

    }

    public function getCreatePoligami(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/data/form/poligami.twig');
    }

    public function createPoligami(Request $request, Response $response)
    {
         $this->validator->rule('required', ['kesiapan', 'penjelasan_kesiapan', 'alasan_poligami', 'kondisi_istri']);

        try {
               $result = $this->client->request('POST',
               $this->router->pathFor('api.user.create.poligami'),
                   ['form_params' => [
                       'user_id'     => $_SESSION['login']['id'],
                       'kesiapan' => $request->getParam('kesiapan'),
                       'penjelasan_kesiapan' => $request->getParam('penjelasan_kesiapan'),
                       'alasan_poligami' => $request->getParam('alasan_poligami'),
                       'kondisi_istri' => $request->getParam('kondisi_istri'),
                   ],
               ]);
           } catch (GuzzleException $e) {
               $result = $e->getResponse();
           }
           $data = json_decode($result->getBody()->getContents(), true);
           
            // var_dump($data['message']);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 201 ) {
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.ciri-fisik'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.ciri-fisik'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.create.ciri-fisik'));
       }
    }

    public function myProfil(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/data/my-profil.twig');
    }

    public function statistikRequest(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/data/statistik-request.twig');
    }

    public function getNotification(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/data/notification/notification.twig');
    }
}
