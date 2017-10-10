<?php

namespace App\Controllers\Web;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\BadResponseException as GuzzleException;
use GuzzleHttp;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class AdminController extends BaseController
{
    public function getAllUser(Request $request,Response $response)
    {
        try {
            $result = $this->client->request('POST',
            $this->router->pathFor('api.search.user.all'), [
            'form_params' => [
                        'search' => $request->getParam('search'),
            ], 
                 'query' => [
                     'perpage' => 10,
                     'page' => $request->getQueryParam('page'),
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data);die();
        $this->flash->addMessage('succes', 'sadasdsa');
        return $this->view->render($response, 'admin/user/all-user.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    // 

    }

    public function getAllNewUser(Request $request,Response $response)
    {
         try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.new.user'), [
                 'query' => [
                     'perpage' => 10,
                     'page' => $request->getQueryParam('page'),
                     'id' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data['data']);die();
        return $this->view->render($response, 'admin/user/new-user.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    //
    }

    public function getUserNewDetail(Request $request, Response $response, $args)
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
        return $this->view->render($response, 'admin/user/new-view-detail.twig', [
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


    public function getAllUserMan(Request $request,Response $response)
    {
         try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.show.user.man'), [
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
        return $this->view->render($response, 'admin/user/user-man.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    //
    }

    public function getAllUserWoman(Request $request,Response $response)
    {
         try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.show.user.woman'), [
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
        return $this->view->render($response, 'admin/user/user-woman.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    //
    }

    public function getAllKota(Request $request, Response $response)
    {
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.admin.kota'), [
                 'query' => [
                     'perpage' => 10,
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
                $result1 = $this->client->request('GET',
                $this->router->pathFor('admin.provinsi'), [
                     'query' => [
                         'perpage' => 5,
                         'page' => $request->getQueryParam('page'),
                         'id' => $_SESSION['login']['id']
                ]]);
            } catch (GuzzleException $e) {
                $result1 = $e->getResponse();
            }
            $provinsi = json_decode($result1->getBody()->getContents(), true); 
    // var_dump($provinsi);die;
          return $this->view->render($response, 'admin/crud/kota/kota.twig', [
            'data'          =>  $data['data'] ,
            'provinsi'          =>  $provinsi['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    //
    }

    public function createKota(Request $request, Response $response)
    {
        try {
            $result = $this->client->request('POST',  $this->router->pathFor('admin.create.kota'),
                ['form_params' => [
                    'id_provinsi'   => $request->getParam('id_provinsi'),
                    'nama'          => $request->getParam('nama'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $content = $result->getBody()->getContents();
        $data = json_decode($content, true);
        var_dump($data);die;
        if ($data['error'] == false) {
            $this->flash->addMessage('success', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.show.kota'));
        } else {
            $this->flash->addMessage('error', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.show.kota'));
        }
    }

    public function getAllProvinsi(Request $request, Response $response)
    {
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.provinsi'), [
                 'query' => [
                     'perpage' => 10,
                     'page' => $request->getQueryParam('page'),
                     'id' => $_SESSION['login']['id']
            ]]);

            // var_dump($negara);die;
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data);die();
        
         try {
                $result = $this->client->request('GET',
                $this->router->pathFor('admin.negara'), [
                     'query' => [
                         'perpage' => 5,
                         'page' => $request->getQueryParam('page'),
                         'id' => $_SESSION['login']['id']
                ]]);
            // $content = json_decode($result->getBody()->getContents());
            } catch (GuzzleException $e) {
                $result = $e->getResponse();
            }
            $negara = json_decode($result->getBody()->getContents(), true); 
        
        return $this->view->render($response, 'admin/crud/provinsi/provinsi.twig', [
            'data'          =>  $data['data'] ,
            'negara'          =>  $negara['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    //
    }

    public function getAllNegara(Request $request, Response $response)
    {
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.negara'), [
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
        return $this->view->render($response, 'admin/crud/negara/negara.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    //
    }

    public function getUserDetail(Request $request, Response $response, $args)
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
        return $this->view->render($response, 'admin/user/view-detail.twig', [
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

    public function approveUser(Request $request, Response $response, $args)
    {
        // var_dump($_SESSION['login']);die();
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.approve.user', ['id' => $args['id']]), [
                 'query' => [
                     'accepted_by' => $_SESSION['login']['id']
            ]]);
            // $content = json_decode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // print_r($data);die();
        if ($data['error'] == 404) {
            $this->flash->addMessage('success', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.new.user.all'));
        } else {
            $this->flash->addMessage('success', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.new.user.all'));
        }
    }

    public function cancelUser(Request $request, Response $response, $args)
    {
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.cancel.user', ['id' => $args['id']]), [
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
            $this->flash->addMessage('success', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.new.user.all'));
        } else {
            $this->flash->addMessage('error', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.new.user.all'));
        }
    }

    public function getLogin(Request $request, Response $response)
    {
        return  $this->view->render($response, 'auth/login.twig');
    }

    public function loginAdmin(Request $request, Response $response, $args)
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
        //    var_dump($data['data']);die();

           if ($data['code'] == 200 ) {
                $_SESSION['login'] = $data['data'];
                // var_dump($_SESSION['login']['role'] == 1);die();
               if ($_SESSION['login']['role'] == 1) {
                   // $this->flash->addMessage('success', 'Selamat datang '. $_SESSION['login']['username']);
                   return $response->withRedirect($this->router->pathFor('admin.home'));
               } else {
                   $this->flash->addMessage('warning', 'Anda bukan admin');
                   return $response->withRedirect($this->router->pathFor('admin.login'));
               }
           } else {
               $this->flash->addMessage('warning', 'Username atau password tidak cocok');
               return $response->withRedirect($this->router->pathFor('admin.login'));
           }
       }

    public function logout(Request $request, Response $response)
    {
       $user = new \App\Models\Users\UserModel($this->db);
       if ($_SESSION['login']['role'] == 0) {
        $data = [
            'last_online' => date('Y-m-d H:i:s')
        ];
        $var = $user->updateData($data, $_SESSION['login']['id']);
        // echo date('Y-m-d H:i:s');die;
            session_destroy();
            return $response->withRedirect($this->router->pathFor('user.login'));

        } elseif ($_SESSION['login']['role'] == 1) {
         // echo $var;die;
            session_destroy();
            return $response->withRedirect($this->router->pathFor('admin.login'));
        } else {
            session_destroy();
            return $response->withRedirect($this->router->pathFor('user.login'));
        }
    }

    public function setModerator(Request $request, Response $response, $args)
    {
         try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.setModerator', ['id' => $args['id']]), [
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
            $this->flash->addMessage('success', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.user'));
        } else {
            $this->flash->addMessage('error', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.user'));
        }
    }

    public function getTaaruf(Request $request, Response $response)
    {
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.get.taaruf'), [
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
        $this->flash->addMessage('succes', 'sadasdsa');
        return $this->view->render($response, 'admin/request/taaruf.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    //
    }

    public function getAllRequest(Request $request, Response $response)
    {
       try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.request.all'), [
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
        $this->flash->addMessage('succes', 'sadasdsa');
        return $this->view->render($response, 'admin/request/request-all.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    //
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
            $this->flash->addMessage('success', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.show.taaruf'));
        } else {
            $this->flash->addMessage('error', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.show.taaruf'));
        }
    }

    public function findTaaruf(Request $request, Response $response, $args)
    {
         try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.find.taaruf', ['perequest' => $args['perequest'], 'terequest' => $args['terequest']]), [
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
        var_dump($data);die();
        if ($data['error'] == false) {
            $this->flash->addMessage('success', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.show.taaruf'));
        } else {
            $this->flash->addMessage('error', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.show.taaruf'));
        }
    }

    public function createNegara(Request $request, Response $response)
    {
        try {
            $result = $this->client->request('POST',  $this->router->pathFor('admin.create.negara'),
                ['form_params' => [
                    'nama'          => $request->getParam('nama'),
                ]
            ]);
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $content = $result->getBody()->getContents();
        $data = json_decode($content, true);

        if ($data['error'] == false) {
            $this->flash->addMessage('success', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.show.negara'));
        } else {
            $this->flash->addMessage('error', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.show.negara'));
        }
    }

    public function createProvinsi(Request $request, Response $response, $args)
    {
        try {
            $result = $this->client->request('POST',  $this->router->pathFor('admin.create.provinsi'),
                ['form_params' => [
                    'nama'          => $request->getParam('nama'),
                    'id_negara'          => $request->getParam('id_negara'),
                ]
            ]);

        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data);die;
         if ($data['error'] == 201) {
            $this->flash->addMessage('error', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.show.provinsi'));
        } else {
            $this->flash->addMessage('success', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.show.provinsi'));
        }
    }

    public function searchUser(Request $request, Response $response)
    {
        try {
            $result = $this->client->request('POST',  $this->router->pathFor('api.search.user.all'),
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
        // $this->flash->addMessage('succes', 'yoi');
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


        // try {
        //     $result = $this->client->request('POST',
        //                 $this->router->pathFor('api.search.user.all'));
        //     $content = json_decode($client->getBody()->getContents());
        // } catch (GuzzleException $e) {
        //     $result = $e->getResponse();
        //     $this->flash->addMessage(404, 'Data tidak ditemukan');
        // }
        //     $data = json_decode($result->getBody()->getContents(), true);
          
        //     var_dump($data);die;
        // return $this->view->render($response, 'admin/user/result-search.twig');
    }

     public function getNotification(Request $request, Response $response)
    {

        $notification = new \App\Models\Users\RequestModel($this->db);
        $countNotification = count($notification->getAllNotification()->fetchAll());
        $countCancelNotification = count($notification->getAllBlokirRequest()->fetchAll());
        $countTaarufNotification = count($notification->joinRequest()->fetchAll());
        // var_dump($countCancelNotification);die;
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.notification'), [
                    'query' => [
                        'id_terequest' => $_SESSION['login']['id'],
                        'perpage' => 10,
                        'page'    => $request->getQueryParam('page')
                    ]
                ]);

            try {
                $result1 = $this->client->request('GET',
                $this->router->pathFor('api.user.cancel-notification'), [
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

                 try {
                    $result2 = $this->client->request('GET',
                    $this->router->pathFor('admin.get.taaruf'), [
                         'query' => [
                             'perpage' => 5,
                             'page' => $request->getQueryParam('page'),
                             'id' => $_SESSION['login']['id']
                    ]]);
                    // $content = json_decode($result2->getBody()->getContents());
                } catch (GuzzleException $e) {
                    $result2 = $e->getResponse();
                }
                $approve = json_decode($result2->getBody()->getContents(), true);
                // var_dump($approve);die;
            } catch (GuzzleException $e) {
                $result = $e->getResponse();
            }

      $data = json_decode($result->getBody()->getContents(), true);
      // var_dump($data['data']);die;  
      return $this->view->render($response, 'admin/notification.twig', [
          'data' => $data['data'],
          'blokir' => $blokir['data'],
          'counts' => [
            'countNotification' => $countNotification,
            'countCancel' => $countCancelNotification,
            'countTaaruf' => $countTaarufNotification,
          ],
          'approve' => $approve['data'],
          'pagination' => $data['pagination'],
        ]);

    }

    public function getCreateMember(Request $request, Response $response)
    {
        return $this->view->render($response, 'admin/crud/user/create.twig');
    }

    public function createMember(Request $request, Response $response)
    {
        $this->validator->rule('required', ['username', 'email', 'password', 'phone', 'gender', 'role'])
        ->labels(array(
            'username' => 'Username', 
            'email' => 'Email', 
            'password' => 'Password', 
            'phone' => 'Nomor Telepon', 
            'gender' => 'Jenis Kelamin', 
            'roel' => 'Status Member', 

        ));
        $this->validator->rule('email', 'email');
        $this->validator->rule('numeric', 'phone');
        $this->validator->rule('alphaNum', 'username');
        $this->validator->rule('lengthMin', ['username', 'password'], 5);
        $this->validator->rule('lengthMax', ['username', 'password'], 20);
        try {
               $result = $this->client->request('POST',
               $this->router->pathFor('api.admin.create.user'),
                   ['form_params' => [
                       'username' => $request->getParam('username'),
                       'email' => $request->getParam('email'),
                       'phone' => $request->getParam('phone'),
                       'password' => $request->getParam('password'),
                       'gender' => $request->getParam('gender'),
                       'role' => $request->getParam('role'),
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
                $this->flash->addMessage('success', $data['message']);
                return $response->withRedirect($this->router->pathFor('admin.create.user'));
           } else {
               $_SESSION['old'] = $request->getParams();
                $this->flash->addMessage('errors', $data['message']);
                return $response->withRedirect($this->router->pathFor('admin.create.user'));
           }
       } else {
        $_SESSION['errors'] = $this->validator->errors();
        $_SESSION['old'] = $request->getParams();
        return $response->withRedirect($this->router->pathFor('admin.create.user'));
       }
    }

    public function setMemberPremium(Request $request, Response $response, $args)
    {
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.setUserPremium', ['id' => $args['id']]), [
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
            $this->flash->addMessage('success', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.user'));
        } else {
            $this->flash->addMessage('error', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.user'));
        }
    }
}
