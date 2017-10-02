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
            $this->router->pathFor('api.show.profile.pria'), [
                    'query' => [
                        'perpage' => 9,
                        'page'    => $request->getQueryParam('page')
                    ]
                ]);


            } catch (GuzzleException $e) {
                $result = $e->getResponse();
            }

            $data = json_decode($result->getBody()->getContents(), true);
        
         try {
            $result1 = $this->client->request('GET',
            $this->router->pathFor('api.show.profile.wanita'), [
                    'query' => [
                        'perpage' => 9,
                        'page'    => $request->getQueryParam('page')
                    ]
                ]);


            } catch (GuzzleException $e) {
                $result1 = $e->getResponse();
            }

            $profil = json_decode($result1->getBody()->getContents(), true);
          
    return $this->view->render($response, 'user/user.twig', [
        'data'          =>  $data['data'] ,
        'user'          =>  $profil['data'] ,
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

    public function register(Request $request, Response $response, $args)
    {
        $this->validator->rule('required', ['username', 'email', 'password', 'phone', 'gender'])
        ->labels(array(
            'username' => 'Username', 
            'email' => 'Email', 
            'password' => 'Password', 
            'phone' => 'Nomor Telepon', 
            'gender' => 'Jenis Kelamin', 

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
                       'photo' => 'avatar.png',
                       'ktp' => 'avatar.png',
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
                return $response->withRedirect($this->router->pathFor('user.register'));
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
                $this->flash->addMessage('success_material', $data['message']);
                   return $response->withRedirect($this->router->pathFor('user.change.image'));
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
                            'perpage' => 100,
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
                                'perpage' => 100,
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
                                    'perpage' => 100,
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
        $this->validator->rule('required', ['nama_lengkap', 'tanggal_lahir', 'tempat_lahir', 'alamat', 'umur', 'kota', 'kewarganegaraan', 'target_menikah', 'tentang_saya', 'pasangan_harapan']);

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
                return $response->withRedirect($this->router->pathFor('user.create.keseharian'));
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
           
            // var_dump($data['message']);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 201 ) {
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.latar-belakang'));
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
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.latar-belakang'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.ciri-fisik'));
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
         $this->validator->rule('required', ['tinggi', 'berat', 'warna_kulit', 'suku', 'kaca_mata', 'status_kesehatan', 'ciri_fisik_lain', 'jenggot']);

    // $id = $_SESSION['login']['id'];
    // var_dump($_SESSION['login']['id']);die;
        try {
               $result = $this->client->request('POST',
               $this->router->pathFor('api.user.create.ciri.fisik.pria'),
                   ['form_params' => [
                       // 'user_id'     => $_SESSION['login']['id'],
                       'tinggi' => $request->getParam('tinggi'),
                       'berat' => $request->getParam('berat'),
                       'warna_kulit' => $request->getParam('warna_kulit'),
                       'suku' => $request->getParam('suku'),
                       'kaca_mata' => $request->getParam('kaca_mata'),
                       'status_kesehatan' => $request->getParam('status_kesehatan'),
                       'ciri_fisik_lain' => $request->getParam('ciri_fisik_lain'),
                       'jenggot' => $request->getParam('jenggot'),
                       'cadar' => NULL,
                       'hijab' => NULL,
                   ],
               ]);
           } catch (GuzzleException $e) {
               $result = $e->getResponse();
           }
           $data = json_decode($result->getBody()->getContents(), true);
           
            // var_dump($data);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 201 ) {
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.poligami'));
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

     public function createCiriFisikWanita(Request $request, Response $response)
    {
         $this->validator->rule('required', ['tinggi', 'berat', 'warna_kulit', 'suku', 'kaca_mata', 'status_kesehatan', 'ciri_fisik_lain', 'cadar', 'hijab']);

    // $id = $_SESSION['login']['id'];
    // var_dump($_SESSION['login']['id']);die;
        try {
               $result = $this->client->request('POST',
               $this->router->pathFor('api.user.create.ciri.fisik.wanita'),
                   ['form_params' => [
                       // 'user_id'     => $_SESSION['login']['id'],
                       'tinggi' => $request->getParam('tinggi'),
                       'berat' => $request->getParam('berat'),
                       'warna_kulit' => $request->getParam('warna_kulit'),
                       'suku' => $request->getParam('suku'),
                       'kaca_mata' => $request->getParam('kaca_mata'),
                       'status_kesehatan' => $request->getParam('status_kesehatan'),
                       'ciri_fisik_lain' => $request->getParam('ciri_fisik_lain'),
                       'jenggot' => NULL,
                       'cadar' =>  $request->getParam('cadar'),
                       'hijab' =>  $request->getParam('hijab'),
                   ],
               ]);
           } catch (GuzzleException $e) {
               $result = $e->getResponse();
           }
           $data = json_decode($result->getBody()->getContents(), tru);
           
            // var_dump($data['message']);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 201 ) {
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.dipoligami'));
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
         $this->validator->rule('required', ['kesiapan', 'penjelasan_kesiapan']);

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
                 $this->flash->addMessage('success_material', "tambah data diri user dah semua, silahkan tunggu persetujuan dari admin");
                return $response->withRedirect($this->router->pathFor('user.my.profil'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.poligami'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.create.poligami'));
       }
    }

    public function getCreateDipoligami(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/data/form/dipoligami.twig');
    }


    public function createDipoligami(Request $request, Response $response)
    {
         $this->validator->rule('required', ['kesiapan', 'penjelasan_kesiapan']);

        try {
               $result = $this->client->request('POST',
               $this->router->pathFor('api.user.create.dipoligami'),
                   ['form_params' => [
                       'user_id'     => $_SESSION['login']['id'],
                       'kesiapan' => $request->getParam('kesiapan'),
                       'penjelasan_kesiapan' => $request->getParam('penjelasan_kesiapan'),
                   ],
               ]);
           } catch (GuzzleException $e) {
               $result = $e->getResponse();
           }
           $data = json_decode($result->getBody()->getContents(), true);
           
            // var_dump($data['message']);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 201 ) {
                $this->flash->addMessage('success_material', "tambah data diri user dah semua, silahkan tunggu persetujuan dari admin");
                return $response->withRedirect($this->router->pathFor('user.my.profil'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.create.dipoligami'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.create.dipoligami'));
       }
    }

    public function myProfil(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/data/my-profil.twig');
    }

    // public function statistikRequest(Request $request, Response $response)
    // {
    //     return $this->view->render($response, 'user/data/statistik-request.twig');
    // }

    // public function getNotification(Request $request, Response $response)
    // {
    //     return $this->view->render($response, 'user/data/notification/notification.twig');
    // }

    public function viewDetailUser(Request $request, Response $response, $args )
    {
      try {
            $result1 = $this->client->request('GET',
            $this->router->pathFor('api.find.user', ['id' => $args['id']]), [
                'query' => [
                    // 'page'    => $request->getQueryparam('page'),
                    'perpage' => 5,
                    'id' => $args['id']
                    ]
                ]);
        try {
                $result2 = $this->client->request('GET',
                $this->router->pathFor('user.find.profil', ['id' => $args['id']]), [
                        'query' => [
                            'perpage' => 5,
                            'page'    => $request->getQueryParam('page')
                        ]
                    ]);


                } catch (GuzzleException $e) {
                    $result2 = $e->getResponse();
                }

                $profil = json_decode($result2->getBody()->getContents(), true);

                    try {
                    $result3 = $this->client->request('GET',
                    $this->router->pathFor('user.find.keseharian', ['id' => $args['id']]), [
                            'query' => [
                                'perpage' => 5,
                                'page'    => $request->getQueryParam('page')
                            ]
                        ]);


                    } catch (GuzzleException $e) {
                        $result3 = $e->getResponse();
                    }

                    $keseharian = json_decode($result3->getBody()->getContents(), true);

                        try {
                        $result3 = $this->client->request('GET',
                        $this->router->pathFor('user.find.latar-belakang', ['id' => $args['id']]), [
                                'query' => [
                                    'perpage' => 5,
                                    'page'    => $request->getQueryParam('page')
                                ]
                            ]);


                        } catch (GuzzleException $e) {
                            $result3 = $e->getResponse();
                        }

                        $latar = json_decode($result3->getBody()->getContents(), true);
// var_dump($latar);die;
                            try {
                            $result4 = $this->client->request('GET',
                            $this->router->pathFor('user.find.ciri-fisik', ['id' => $args['id']]), [
                                    'query' => [
                                        'perpage' => 5,
                                        'page'    => $request->getQueryParam('page')
                                    ]
                                ]);


                            } catch (GuzzleException $e) {
                                $result4 = $e->getResponse();
                            }

                            $fisik = json_decode($result4->getBody()->getContents(), true);

                                try {
                                $result5 = $this->client->request('GET',
                                $this->router->pathFor('user.find.poligami', ['id' => $args['id']]), [
                                        'query' => [
                                            'perpage' => 9,
                                            'page'    => $request->getQueryParam('page')
                                        ]
                                    ]);


                                } catch (GuzzleException $e) {
                                    $result5 = $e->getResponse();
                                }

                                $poligami = json_decode($result5->getBody()->getContents(), true);

                                    try {
                                    $result6 = $this->client->request('GET',
                                    $this->router->pathFor('user.find.dipoligami', ['id' => $args['id']]), [
                                            'query' => [
                                                'perpage' => 5,
                                                'page'    => $request->getQueryParam('page')
                                            ]
                                        ]);


                                    } catch (GuzzleException $e) {
                                        $result6 = $e->getResponse();
                                    }

                                    $dipoligami = json_decode($result6->getBody()->getContents(), true);
                                    // var_dump($dipoligami);die();
        } catch (GuzzleException $e) {
              $result = $e->getResponse();
             }
         $user = json_decode($result1->getBody()->getContents(), true);

        // echo "<br />";
        // var_dump($profil['data']);die();
        return $this->view->render($response, 'user/data/view-detail.twig', [
            'user' => $user['data'],
            'profil'    => $profil['data'],
            'keseharian' => $keseharian['data'],
            'latar' => $latar['data'],
            'fisik' => $fisik['data'],
            'poligami' => $poligami['data'],
            'dipoligami' => $dipoligami['data'],
            'pagination'    => $data['pagination'],
        ]);
    }

   public function viewProfile(Request $request, Response $response, $args )
    {
      $id = $_SESSION['login']['id'];
      try {
            $result1 = $this->client->request('GET',
            $this->router->pathFor('api.find.user', ['id' => $id]), [
                'query' => [
                    // 'page'    => $request->getQueryparam('page'),
                    'perpage' => 5,
                    'id' => $args['id']
                    ]
                ]);
        try {
                $result2 = $this->client->request('GET',
                $this->router->pathFor('user.find.profil', ['id' => $id]), [
                        'query' => [
                            'perpage' => 5,
                            'page'    => $request->getQueryParam('page')
                        ]
                    ]);


                } catch (GuzzleException $e) {
                    $result2 = $e->getResponse();
                }

                $profil = json_decode($result2->getBody()->getContents(), true);

                    try {
                    $result3 = $this->client->request('GET',
                    $this->router->pathFor('user.find.keseharian', ['id' => $id]), [
                            'query' => [
                                'perpage' => 5,
                                'page'    => $request->getQueryParam('page')
                            ]
                        ]);


                    } catch (GuzzleException $e) {
                        $result3 = $e->getResponse();
                    }

                    $keseharian = json_decode($result3->getBody()->getContents(), true);

                        try {
                        $result3 = $this->client->request('GET',
                        $this->router->pathFor('user.find.latar-belakang', ['id' => $id]), [
                                'query' => [
                                    'perpage' => 5,
                                    'page'    => $request->getQueryParam('page')
                                ]
                            ]);


                        } catch (GuzzleException $e) {
                            $result3 = $e->getResponse();
                        }

                        $latar = json_decode($result3->getBody()->getContents(), true);
// var_dump($latar);die;
                            try {
                            $result4 = $this->client->request('GET',
                            $this->router->pathFor('user.find.ciri-fisik', ['id' => $id]), [
                                    'query' => [
                                        'perpage' => 5,
                                        'page'    => $request->getQueryParam('page')
                                    ]
                                ]);


                            } catch (GuzzleException $e) {
                                $result4 = $e->getResponse();
                            }

                            $fisik = json_decode($result4->getBody()->getContents(), true);

                                try {
                                $result5 = $this->client->request('GET',
                                $this->router->pathFor('user.find.poligami', ['id' => $id]), [
                                        'query' => [
                                            'perpage' => 9,
                                            'page'    => $request->getQueryParam('page')
                                        ]
                                    ]);


                                } catch (GuzzleException $e) {
                                    $result5 = $e->getResponse();
                                }

                                $poligami = json_decode($result5->getBody()->getContents(), true);

                                    try {
                                    $result6 = $this->client->request('GET',
                                    $this->router->pathFor('user.find.dipoligami', ['id' => $id]), [
                                            'query' => [
                                                'perpage' => 5,
                                                'page'    => $request->getQueryParam('page')
                                            ]
                                        ]);


                                    } catch (GuzzleException $e) {
                                        $result6 = $e->getResponse();
                                    }

                                    $dipoligami = json_decode($result6->getBody()->getContents(), true);
                                    // var_dump($dipoligami);die();
        } catch (GuzzleException $e) {
              $result = $e->getResponse();
             }
         $user = json_decode($result1->getBody()->getContents(), true);
          // try {
          //       $req = $this->client->request('GET',
          //       $this->router->pathFor('api.show.find.request', ['id' => $id]), [
          //               'query' => [
          //                   'perpage' => 5,
          //                   'page'    => $request->getQueryParam('page')
          //               ]
          //           ]);


          //       } catch (GuzzleException $e) {
          //           $req = $e->getResponse();
          //       }

          //       $requst = json_decode($req->getBody()->getContents(), true);
          //       var_dump($request);die;
        // echo "<br />";
        // var_dump($profil['data']);die();
        return $this->view->render($response, 'user/data/my-profil.twig', [
            'user' => $user['data'],
            'profil'    => $profil['data'],
            'keseharian' => $keseharian['data'],
            'latar' => $latar['data'],
            'fisik' => $fisik['data'],
            'poligami' => $poligami['data'],
            'dipoligami' => $dipoligami['data'],
            'pagination'    => $data['pagination'],
        ]);
    }

    public function updateProfil(Request $request, Response $response, $args)
    {
       try {
                $result2 = $this->client->request('GET',
                $this->router->pathFor('admin.negara'), [
                        'query' => [
                            'perpage' => 100,
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
                                'perpage' => 100,
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
                                    'perpage' => 100,
                                    'page'    => $request->getQueryParam('page')
                                ]
                            ]);


                        } catch (GuzzleException $e) {
                            $result3 = $e->getResponse();
                        }

                        $kota = json_decode($result3->getBody()->getContents(), true);
       try {
                $result2 = $this->client->request('GET',
                $this->router->pathFor('user.find.profil', ['id' => $_SESSION['login']['id']]), [
                        'query' => [
                            'perpage' => 5,
                            'page'    => $request->getQueryParam('page')
                        ]
                    ]);


                } catch (GuzzleException $e) {
                    $result2 = $e->getResponse();
                }

                $profil = json_decode($result2->getBody()->getContents(), true);
                // var_dump($profil);die;
      return $this->view->render($response, 'user/data/form/update/profil.twig',[
            'data'     => $profil['data'],
            'negara'   =>  $negara['data'] ,
            'provinsi' =>  $provinsi['data'] ,
            'kota'     =>  $kota['data'] 
        ]);
    }

    public function postUpdateProfil(Request $request, Response $response)
    {
       $this->validator->rule('required', ['nama_lengkap', 'tanggal_lahir', 'tempat_lahir', 'alamat', 'umur', 'kota', 'kewarganegaraan', 'target_menikah', 'tentang_saya', 'pasangan_harapan']);

    $id = $_SESSION['login']['id'];
    // var_dump($_SESSION['login']['id']);die;
        try {
               $result = $this->client->request('PUT',
               $this->router->pathFor('api.user.update.profil'),
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
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.update.profil'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.update.profil'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.update.profil'));
       }
    }

    public function updateLatarBelakang(Request $request, Response $response)
    {
       try {
          $result3 = $this->client->request('GET',
          $this->router->pathFor('user.find.latar-belakang', ['id' => $_SESSION['login']['id']]), [
                  'query' => [
                      'perpage' => 5,
                      'page'    => $request->getQueryParam('page')
                  ]
              ]);


          } catch (GuzzleException $e) {
              $result3 = $e->getResponse();
          }

        $latar = json_decode($result3->getBody()->getContents(), true);
        
        return $this->view->render($response, 'user/data/form/update/latar-belakang.twig',[ 
          'data' => $latar['data'],
        ]);
    }

    public function postUpdateLatarBelakang(Request $request, Response $response)
    {
        $this->validator->rule('required', ['pendidikan', 'penjelasan_pendidikan', 'agama', 'penjelasan_agama', 'muallaf', 'baca_quran', 'hafalan', 'keluarga', 'penjelasan_keluarga', 'shalat']);

    $id = $_SESSION['login']['id'];
    // var_dump($_SESSION['login']['id']);die;
        try {
               $result = $this->client->request('PUT',
               $this->router->pathFor('api.user.update.latar-belakang'),
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
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.update.latar-belakang'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.update.latar-belakang'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.update.latar-belakang'));
       }
    }

    public function updateCiriFisik(Request $request, Response $response, $args)
    {
       try {
          $result4 = $this->client->request('GET',
          $this->router->pathFor('user.find.ciri-fisik', ['id' => $_SESSION['login']['id']]), [
                  'query' => [
                      'perpage' => 5,
                      'page'    => $request->getQueryParam('page')
                  ]
              ]);


          } catch (GuzzleException $e) {
              $result4 = $e->getResponse();
          }

        $fisik = json_decode($result4->getBody()->getContents(), true);
        
        return $this->view->render($response, 'user/data/form/update/ciri-fisik.twig', [
              'data' => $fisik['data']
          ]);
    }

    public function postUpdateCiriFisikPria(Request $request, Response $response)
    {
       $this->validator->rule('required', ['tinggi', 'berat', 'warna_kulit', 'suku', 'kaca_mata', 'status_kesehatan', 'ciri_fisik_lain', 'jenggot']);

        try {
               $result = $this->client->request('PUT',
               $this->router->pathFor('api.user.update.ciri.fisik.pria'),
                   ['form_params' => [
                       // 'user_id'     => $_SESSION['login']['id'],
                       'tinggi' => $request->getParam('tinggi'),
                       'berat' => $request->getParam('berat'),
                       'warna_kulit' => $request->getParam('warna_kulit'),
                       'suku' => $request->getParam('suku'),
                       'kaca_mata' => $request->getParam('kaca_mata'),
                       'status_kesehatan' => $request->getParam('status_kesehatan'),
                       'ciri_fisik_lain' => $request->getParam('ciri_fisik_lain'),
                       'jenggot' => $request->getParam('jenggot'),
                       'cadar' => NULL,
                       'hijab' => NULL,
                   ],
               ]);
           } catch (GuzzleException $e) {
               $result = $e->getResponse();
           }
           $data = json_decode($result->getBody()->getContents(), true);
           
            // var_dump($data['message']);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 201 ) {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.update.ciri-fisik'));
           } else {
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.update.ciri-fisik'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.update.ciri-fisik'));
       }
    }

    public function postUpdateCiriFisikWanita(Request $request, Response $response)
    {
         $this->validator->rule('required', ['tinggi', 'berat', 'warna_kulit', 'suku', 'kaca_mata', 'status_kesehatan', 'ciri_fisik_lain', 'cadar', 'hijab']);

    // $id = $_SESSION['login']['id'];
    // var_dump($_SESSION['login']['id']);die;
        try {
               $result = $this->client->request('PUT',
               $this->router->pathFor('api.user.update.ciri.fisik.wanita'),
                   ['form_params' => [
                       // 'user_id'     => $_SESSION['login']['id'],
                       'tinggi' => $request->getParam('tinggi'),
                       'berat' => $request->getParam('berat'),
                       'warna_kulit' => $request->getParam('warna_kulit'),
                       'suku' => $request->getParam('suku'),
                       'kaca_mata' => $request->getParam('kaca_mata'),
                       'status_kesehatan' => $request->getParam('status_kesehatan'),
                       'ciri_fisik_lain' => $request->getParam('ciri_fisik_lain'),
                       'jenggot' => NULL,
                       'cadar' =>  $request->getParam('cadar'),
                       'hijab' =>  $request->getParam('hijab'),
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
                return $response->withRedirect($this->router->pathFor('user.update.ciri-fisik'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.update.ciri-fisik'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.update.ciri-fisik'));
       }
    }

    public function updateKeseharian(Request $request, Response $response, $args)
    {
       try {
          $result4 = $this->client->request('GET',
          $this->router->pathFor('user.find.keseharian', ['id' => $_SESSION['login']['id']]), [
                  'query' => [
                      'perpage' => 5,
                      'page'    => $request->getQueryParam('page')
                  ]
              ]);


          } catch (GuzzleException $e) {
              $result4 = $e->getResponse();
          }

        $keseharian = json_decode($result4->getBody()->getContents(), true);
        return $this->view->render($response, 'user/data/form/update/keseharian.twig', [
            'data' => $keseharian['data'],
        ]);
    }

    public function postUpdateKeseharian(Request $request, Response $response, $args)
    {
        $this->validator->rule('required', ['pekerjaan', 'merokok', 'status_pekerjaan', 'penghasilan_per_bulan', 'status', 'jumlah_anak', 'status_tinggal', 'memiliki_cicilan', 'bersedia_pindah_tinggal']);

    $id = $_SESSION['login']['id'];
    // var_dump($_SESSION['login']['id']);die;
        try {
               $result = $this->client->request('PUT',
               $this->router->pathFor('api.user.update.keseharian'),
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
           
            // var_dump($data['message']);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 201 ) {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.update.keseharian'));
           } else {
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.update.keseharian'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.update.keseharian'));
      }
    }

    public function updatePoligami(Request $request, Response $response, $args)
    {

      try {
        $result5 = $this->client->request('GET',
        $this->router->pathFor('user.find.poligami', ['id' => $_SESSION['login']['id']]), [
                'query' => [
                    'perpage' => 9,
                    'page'    => $request->getQueryParam('page')
                ]
            ]);


        } catch (GuzzleException $e) {
            $result5 = $e->getResponse();
        }

        $poligami = json_decode($result5->getBody()->getContents(), true);

            try {
            $result6 = $this->client->request('GET',
            $this->router->pathFor('user.find.dipoligami', ['id' => $_SESSION['login']['id']]), [
                    'query' => [
                        'perpage' => 5,
                        'page'    => $request->getQueryParam('page')
                    ]
                ]);


            } catch (GuzzleException $e) {
                $result6 = $e->getResponse();
            }

            $dipoligami = json_decode($result6->getBody()->getContents(), true);
      return $this->view->render($response, 'user/data/form/update/poligami.twig', [ 
            'poligami' => $poligami['data'],
            'dipoligami' => $dipoligami['data'],
        ]);
    }

    public function postUpdatePoligami(Request $request, Response $response)
    {
         $this->validator->rule('required', ['kesiapan', 'penjelasan_kesiapan', 'alasan_poligami', 'kondisi_istri']);

        try {
               $result = $this->client->request('PUT',
               $this->router->pathFor('api.user.update.poligami'),
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
           
            // var_dump($_SESSION['login']['id']);die;
        if ($this->validator->validate()) {
           if ($data['code'] == 400 ) {
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.update.poligami'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('success_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.update.poligami'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.update.poligami'));
       }
    }

    public function postUpdatediPoligami(Request $request, Response $response)
    {
         $this->validator->rule('required', ['kesiapan', 'penjelasan_kesiapan']);

        try {
               $result = $this->client->request('PUT',
               $this->router->pathFor('api.update.create.dipoligami'),
                   ['form_params' => [
                       'user_id'     => $_SESSION['login']['id'],
                       'kesiapan' => $request->getParam('kesiapan'),
                       'penjelasan_kesiapan' => $request->getParam('penjelasan_kesiapan'),
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
                return $response->withRedirect($this->router->pathFor('user.update.dipoligami'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('error_material', $data['message']);
                return $response->withRedirect($this->router->pathFor('user.update.dipoligami'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('user.update.dipoligami'));
       }
    }

    public function getChangePassword(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/data/form/change-password.twig');
    }

    public function changePassword(Request $request, Response $response)
    {
      $password1 = $request->getParam('new_password');
        $password2 = $request->getParam('confirm_password');
        // var_dump( $request->getParams());die;
        if ($password1 != $password2) {
            $this->flash->addMessage('warning_material', 'Konfirmasi password baru tidak cocok');
            return $response->withRedirect($this->router->pathFor('user.change-password'));
        }

        try {
            $result = $result = $this->client->request('POST',
               $this->router->pathFor('api.user.change-password'),
                ['form_params' => [
                    'password' => $request->getParam('password'),
                    'new_password' => $request->getParam('new_password')
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents(), true);
// var_dump($data);die;
        if ($data['error'] == 200) {
            $this->flash->addMessage('error_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.change-password'));
        } else {
            $this->flash->addMessage('success_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.change-password'));
        }
    }

    public function getChangeImage(Request $request, Response $response, $args)
    {
      return $this->view->render($response, 'auth/change-image.twig');
    }

    public function getNotification(Request $request, Response $response)
    {
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.notification'), [
                    'query' => [
                        'id_terequest' => $_SESSION['login']['id'],
                        'perpage' => 10,
                        'page'    => $request->getQueryParam('page')
                    ]
                ]);


            } catch (GuzzleException $e) {
                $result = $e->getResponse();
            }

      $data = json_decode($result->getBody()->getContents(), true);
      // var_dump($request->getUri()->getBaseUrl());die;
       try {
            $result1 = $this->client->request('GET',
            $this->router->pathFor('api.request.reject'), [
                    'query' => [
                        'id_terequest' => $_SESSION['login']['id'],
                        'perpage' => 10,
                        'page'    => $request->getQueryParam('page')
                    ]
                ]);


            } catch (GuzzleException $e) {
                $result1 = $e->getResponse();
            }

      $blokir = json_decode($result1->getBody()->getContents(), true);
      // var_dump($blokir['data']);die;  
      return $this->view->render($response, 'user/data/notification/notification.twig', [
          'data' => $data['data'],
          'blokir' => $blokir['data'],
          'pagination' => $blokir['pagination'],
          'paginate' => $data['pagination'],
        ]);

    }

    public function viewDetailNotification(Request $request, Response $response, $args )
    {
      try {
            $result1 = $this->client->request('GET',
            $this->router->pathFor('api.find.user', ['id' => $args['id']]), [
                'query' => [
                    // 'page'    => $request->getQueryparam('page'),
                    'perpage' => 5,
                    'id' => $args['id']
                    ]
                ]);
        try {
                $result2 = $this->client->request('GET',
                $this->router->pathFor('user.find.profil', ['id' => $args['id']]), [
                        'query' => [
                            'perpage' => 5,
                            'page'    => $request->getQueryParam('page')
                        ]
                    ]);


                } catch (GuzzleException $e) {
                    $result2 = $e->getResponse();
                }

                $profil = json_decode($result2->getBody()->getContents(), true);

                    try {
                    $result3 = $this->client->request('GET',
                    $this->router->pathFor('user.find.keseharian', ['id' => $args['id']]), [
                            'query' => [
                                'perpage' => 5,
                                'page'    => $request->getQueryParam('page')
                            ]
                        ]);


                    } catch (GuzzleException $e) {
                        $result3 = $e->getResponse();
                    }

                    $keseharian = json_decode($result3->getBody()->getContents(), true);

                        try {
                        $result3 = $this->client->request('GET',
                        $this->router->pathFor('user.find.latar-belakang', ['id' => $args['id']]), [
                                'query' => [
                                    'perpage' => 5,
                                    'page'    => $request->getQueryParam('page')
                                ]
                            ]);


                        } catch (GuzzleException $e) {
                            $result3 = $e->getResponse();
                        }

                        $latar = json_decode($result3->getBody()->getContents(), true);
// var_dump($latar);die;
                            try {
                            $result4 = $this->client->request('GET',
                            $this->router->pathFor('user.find.ciri-fisik', ['id' => $args['id']]), [
                                    'query' => [
                                        'perpage' => 5,
                                        'page'    => $request->getQueryParam('page')
                                    ]
                                ]);


                            } catch (GuzzleException $e) {
                                $result4 = $e->getResponse();
                            }

                            $fisik = json_decode($result4->getBody()->getContents(), true);

                                try {
                                $result5 = $this->client->request('GET',
                                $this->router->pathFor('user.find.poligami', ['id' => $args['id']]), [
                                        'query' => [
                                            'perpage' => 9,
                                            'page'    => $request->getQueryParam('page')
                                        ]
                                    ]);


                                } catch (GuzzleException $e) {
                                    $result5 = $e->getResponse();
                                }

                                $poligami = json_decode($result5->getBody()->getContents(), true);

                                    try {
                                    $result6 = $this->client->request('GET',
                                    $this->router->pathFor('user.find.dipoligami', ['id' => $args['id']]), [
                                            'query' => [
                                                'perpage' => 5,
                                                'page'    => $request->getQueryParam('page')
                                            ]
                                        ]);


                                    } catch (GuzzleException $e) {
                                        $result6 = $e->getResponse();
                                    }

                                    $dipoligami = json_decode($result6->getBody()->getContents(), true);
                                    // var_dump($dipoligami);die();
        } catch (GuzzleException $e) {
              $result = $e->getResponse();
             }
         $user = json_decode($result1->getBody()->getContents(), true);

        // echo "<br />";
        // var_dump($profil['data']);die();
        return $this->view->render($response, 'user/data/notification/view-detail.twig', [
            'user' => $user['data'],
            'profil'    => $profil['data'],
            'keseharian' => $keseharian['data'],
            'latar' => $latar['data'],
            'fisik' => $fisik['data'],
            'poligami' => $poligami['data'],
            'dipoligami' => $dipoligami['data'],
            'pagination'    => $data['pagination'],
        ]);
    }

  public function blokirRequest(Request $request, Response $response, $args)
  {
    try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.notification.blokir.request', ['id' => $args['id']]), [
                 'query' => [
                     'perpage' => 5,
                     'page' => $request->getQueryParam('page'),
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data);die();
        if ($data['error'] == false) {
            $this->flash->addMessage('success_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.notification'));
        } else {
            $this->flash->addMessage('error_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.notification'));
          }
  }

  public function cancelRequest(Request $request, Response $response, $args)
  {
    try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.user.cancel-request', ['id' => $args['id']]), [
                 'query' => [
                     'perpage' => 5,
                     'page' => $request->getQueryParam('page'),
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data);die();
        if ($data['error'] == false) {
            $this->flash->addMessage('success_material', 'Request Berhasil Di Hapus');
            return $response->withRedirect($this->router->pathFor('user.statistik'));
        } else {
            $this->flash->addMessage('error_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.statistik'));
          }
  }

  public function sendRequest(Request $request, Response $response, $args)
  {
     try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.send.request', ['id' => $args['id']]), [
                 'query' => [
                     'perpage' => 5,
                     'page' => $request->getQueryParam('page'),
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data);die();
        if ($data['error'] == false) {
            $this->flash->addMessage('success_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.home'));
        } else {
            $this->flash->addMessage('error_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.home'));
          }
  }

  public function statistikRequest(Request $request, Response $response, $args)
  {
     try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.request.all'), [
                    'query' => [
                        'id_terequest' => $_SESSION['login']['id'],
                        'perpage' => 10,
                        'page'    => $request->getQueryParam('page')
                    ]
                ]);


            } catch (GuzzleException $e) {
                $result = $e->getResponse();
            }

      $data = json_decode($result->getBody()->getContents(), true);

          try {
                $users = $this->client->request('GET',
                $this->router->pathFor('api.user.get.taaruf'), [
                    'query' => [
                        'id' => $_SESSION['login']['id'],
                        'perpage' => 10,
                        'page'    => $request->getQueryParam('page')
                        ]
                    ]);
            } catch (GuzzleException $e) {
                  $users = $e->getResponse();
                 }
             $user = json_decode($users->getBody()->getContents(), true);
      // var_dump($user);die;  
      return $this->view->render($response, 'user/data/statistik-request.twig', [
          'data' => $data['data'],
          'taaruf' => $user['data'],
          'pagination' => $user['pagination'],
          'pagination' => $data['pagination']
        ]);
  }

  public function countNotification(Request $request, Response $response)
    {
       $notification = new \App\Models\Users\RequestModel($this->db);
       $allNotification = count($notification->allNotification($_SESSION['login']['id'])->fetchAll());
      var_dump($allNotification);die;  
      return $this->view->render($response, 'user/templates/navbar.twig', [
          'data' => $data['data'],
        ]);

    }

  public function changeImage(Request $request, Response $response)
  {
    $path = $_FILES['image']['tmp_name'];
        $mime = $_FILES['image']['type'];
        $name  = $_FILES['image']['name'];
        $id = $request->getParam('id');
        $idl = $_SESSION['login']['id'];
// var_dump($_FILES);die;
        try {
            $result = $this->client->request('POST', $this->router->pathFor('api.user.image') , [
                'multipart' => [
                    [
                        'name'     => 'image',
                        'filename' => $name,
                        'Mime-Type'=> $mime,
                        'contents' => fopen( $path, 'r' )
                    ],
                     [
                        'name'     => 'ktp',
                        'filename' => $_FILES['ktp']['name'],
                        'Mime-Type'=> $_FILES['ktp']['type'],
                        'contents' => fopen( $_FILES['image']['tmp_name'], 'r' )
                    ], 
                   [
                        'name'      => 'id',
                        'contents'  => $idl,
                  ]
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        // try {
        //     $user = $this->client->request('GET', 'user/'.$id);
        // } catch (GuzzleException $e) {
        //     $user = $e->getResponse();
        // }

        // $data = json_decode($requestsult->getBody()->getContents(), true);
        $newUser = json_decode($result->getBody()->getContents(), true);

        // var_dump($newUser);die();
        if ($data['error'] == false) {
            $this->flash->addMessage('success_material', 'Foto profil berhasil diubah');
            return $response->withRedirect($this->router->pathFor('user.create.profil'));
            $_SESSION['login'] = $newUser['data'];
        } else {
            $this->flash->addMessage('warning_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.change.image'));
        }
  }

   public function searchUser(Request $request, Response $response)
    {
        try {
            $result = $this->client->request('POST',  $this->router->pathFor('api.search.User'),
                ['form_params' => [
                    'search'          => $request->getParam('search'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $content = $result->getBody()->getContents();
        $data = json_decode($content, true);
        // var_dump($data);die;
        $this->flash->addMessage('succes', 'yoi');
        if (empty($result)) {
            // var_dump('ok');die;
            return $this->view->render($response, 'admin/user/all-user.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);  
            
        } else {
            // var_dump($data);die;
            return $this->view->render($response, 'admin/user/result-search.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);  

        }
    }

    public function getAllUserSearch(Request $request,Response $response)
    {
        try {
            $result = $this->client->request('POST',
            $this->router->pathFor('api.search.User.Pria'), [
            'form_params' => [
                        'search' => $request->getParam('search'),
            ], 
                 'query' => [
                     'perpage' => 6,
                     'page' => $request->getQueryParam('page'),
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data);die();
        
        try {
            $result1 = $this->client->request('POST',
            $this->router->pathFor('api.search.User.Wanita'), [
            'form_params' => [
                        'search' => $request->getParam('search'),
            ], 
                 'query' => [
                     'perpage' => 6,
                     'page' => $request->getQueryParam('page'),
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result1->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result1 = $e->getResponse();
        }
        $profil = json_decode($result1->getBody()->getContents(), true); 
        // var_dump($profil);die();
        
         try {
            $result2= $this->client->request('GET',
            $this->router->pathFor('admin.request.all'), [
                 'query' => [
                     'perpage' => 6,
                     'page' => $request->getQueryParam('page'),
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result2>getBody()->getContents());
        } catch (GuzzleException $e) {
            $result2= $e->getResponse();
        }
          $request = json_decode($result2->getBody()->getContents(), true); 

          try {
            $result3 = $this->client->request('GET', $this->router->pathFor('api.notification'),
            ['query' => [
                // 'user_id'  => $_SESSION['login']['id'],
                // 'page'     => $request->getQueryParam('page'),
                'perpage'  => 10,
                ]
            ]);
        } catch (GuzzleException $e) {
            $result3 = $e->getResponse();
        }
        $notif = json_decode($result3->getBody()->getContents(), true);
        if ($notif['message'] == 'Data ditemukan') {
            $_SESSION['notif'] = $notif['data'];
        }
        // var_dump($notif['message']);die;

        // var_dump($request);die;
        // $this->flash->addMessage('succes', 'sadasdsa');
        return $this->view->render($response, 'user/user.twig', [
            'data'          =>  $data['data'] ,
            'user'          =>  $profil['data'] ,
            'request'       =>  $request['data'] ,
            'paginate'    =>  $data['pagination'],
            'pagination'    =>  $profil['pagination']
        ]);    // 

    }

    public function deleteNotification(Request $request, Response $response, $args)
    {
       try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.user.delete.notification', ['id' => $args['id']]), [
                 'query' => [
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data);die();
        if ($data['error'] == false) {
            $this->flash->addMessage('success_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.notification'));
        } else {
            $this->flash->addMessage('error_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.notification'));
          }
    }

    public function approveRequest(Request $request, Response $response, $args)
    {
      try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.approve.request', ['id' => $args['id']]), [
                 'query' => [
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data);die();
        if ($data['error'] == false) {
            $this->flash->addMessage('success_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.notification'));
        } else {
            $this->flash->addMessage('error_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.notification'));
          }
    }

    public function getUploadImage(Request $request, Response $response)
    {
       try {
            $users = $this->client->request('GET',
            $this->router->pathFor('api.find.user', ['id' => $_SESSION['login']['id']]), [
                'query' => [
                    'id' => $_SESSION['login']['id']
                    ]
                ]);
        } catch (GuzzleException $e) {
              $users = $e->getResponse();
             }
         $user = json_decode($users->getBody()->getContents(), true);

           try {
            $img = $this->client->request('GET',
            $this->router->pathFor('api.user.get.image'), [
                'query' => [
                    'id' => $_SESSION['login']['id'],
                     'perpage' => 9,
                     'page' => $request->getQueryParam('page'),
                    ]
                ]);
        } catch (GuzzleException $e) {
              $img = $e->getResponse();
             }
         $image = json_decode($img->getBody()->getContents(), true);
        // var_dump($image);die();
      return $this->view->render($response, 'user/data/change-image.twig', [
            'data' => $user['data'],
            'img' => $image['data'],
            'pagination' => $image['pagination']
        ]);
    }

    public function uploadImage(Request $request, Response $response)
    {
       $path = $_FILES['image']['tmp_name'];
        $mime = $_FILES['image']['type'];
        $name  = $_FILES['image']['name'];
        $id = $request->getParam('id');
        $idl = $_SESSION['login']['id'];
// var_dump($_FILES);die;
        try {
            $result = $this->client->request('POST', $this->router->pathFor('api.user.change.image') , [
                'multipart' => [
                    [
                        'name'     => 'images',
                        'filename' => $name,
                        'Mime-Type'=> $mime,
                        'contents' => fopen( $path, 'r' )
                    ],

                   [
                        'name'      => 'id',
                        'contents'  => $idl,
                  ]
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $newUser = json_decode($result->getBody()->getContents(), true);


        if ($data['error'] == false) {
            $this->flash->addMessage('success_material', 'Foto profil di upload');
            return $response->withRedirect($this->router->pathFor('user.change-image'));
            $_SESSION['login'] = $newUser['data'];
        } else {
            $this->flash->addMessage('warning_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.change-image'));
        }
    }

    public function changeImageGalery(Request $requst, Response $response, $args)
    {
       try {
            $result1 = $this->client->request('POST',
            $this->router->pathFor('api.user.post.image', ['images' => $args['images']] ), [
                 'query' => [
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result1->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result1 = $e->getResponse();
        }
        $change = json_decode($result1->getBody()->getContents(), true);

        if ($data['error'] == false) {
            $this->flash->addMessage('success_material', 'Foto profil di ubah');
            return $response->withRedirect($this->router->pathFor('user.change-image'));
            $_SESSION['login'] = $newUser['data'];
        } else {
            $this->flash->addMessage('warning_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.change-image'));
        }
    }

    public function deleteImageGalery(Request $request, Response $response, $args)
    {
       try {
            $result1 = $this->client->request('GET',
            $this->router->pathFor('api.user.delete.image', ['id' => $args['id']] ), [
                 'query' => [
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result1->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result1 = $e->getResponse();
        }
        $delete = json_decode($result1->getBody()->getContents(), true);

        if ($data['error'] == false) {
            $this->flash->addMessage('success_material', 'Foto berhasil dihapus');
            return $response->withRedirect($this->router->pathFor('user.change-image'));
            $_SESSION['login'] = $newUser['data'];
        } else {
            $this->flash->addMessage('warning_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.change-image'));
        }
    }

    public function getChangeAvatar(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/data/change-avatar.twig');
    }

    public function cancelTaaruf(Request $request, Response $response, $args)
    {
         try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.cancel.proses', ['id' => $args['id']]), [
                 'query' => [
                     'perpage' => 5,
                     'page' => $request->getQueryParam('page'),
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data);die();
        if ($data['error'] == false) {
            $this->flash->addMessage('success_material', "Taaruf berhasil di akhiri");
            return $response->withRedirect($this->router->pathFor('user.statistik'));
        } else {
            $this->flash->addMessage('error_material', $data['message']);
            return $response->withRedirect($this->router->pathFor('user.statistik'));
        }
    }

}
