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
            $result = $this->client->request('GET',
            $this->router->pathFor('api.show.user'), [
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
        // var_dump($data);die();
        return $this->view->render($response, 'admin/user/new-user.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    // 
    }

    public function getAllUserMan(Request $request,Response $response)
    {
         try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.show.user.man'), [
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
        return $this->view->render($response, 'admin/crud/kota/kota.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    // 
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
            // $content = json_decode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($data);die();
        return $this->view->render($response, 'admin/crud/provinsi/provinsi.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    // 
    }

    public function getAllNegara(Request $request, Response $response)
    {
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.negara'), [
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
                    'perpage' => 10,
                    'id' => $args['id']
                    ]
                ]);
        try {
                $result2 = $this->client->request('GET',
                $this->router->pathFor('user.find.profil', ['id' => $args['id']]), [
                        'query' => [
                            'perpage' => 9,
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
                                'perpage' => 9,
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
                                    'perpage' => 9,
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
                                        'perpage' => 9,
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
                                                'perpage' => 9,
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
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.approve.user', ['id' => $args['id']]), [
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
        if ($data['error'] == false) {
            $this->flash->addMessage('success', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.new.user.all'));
        } else {
            $this->flash->addMessage('error', $data['message']);
            return $response->withRedirect($this->router->pathFor('admin.new.user.all'));
        }
    }

    public function cancelUser(Request $request, Response $response, $args)
    {
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.cancel.user', ['id' => $args['id']]), [
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

    public function login(Request $request, Response $response, $args)
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
        // var_dump($data);die();
        if ($data['code'] == 200 ) {
             $_SESSION['login'] = $data['data'];
            if ($_SESSION['login']['status'] == 0) {
                $this->flash->addMessage('warning', $data['message']);
                return $response->withRedirect($this->router->pathFor('admin.login'));
            } elseif($_SESSION['login']['status'] == 1) {
                $this->flash->addMessage('warning', $data['message']);
                return $response->withRedirect($this->router->pathFor('admin.login'));
            } elseif($_SESSION['login']['status'] == 2 && $_SESSION['login']['role'] == 1) {
                $this->flash->addMessage('success', 'Selamat datang '. $_SESSION['login']['username']);
                return $response->withRedirect($this->router->pathFor('admin.home'));
            } else {
                $this->flash->addMessage('warning',
                'Anda bukan admin');
                return $response->withRedirect($this->router->pathFor('admin.login'));
            }
        } else {
            $this->flash->addMessage('warning', 'Username atau password tidak cocok');
            return $response->withRedirect($this->router->pathFor('admin.login'));
        }
    }

    public function logout(Request $request, Response $response)
    {
       if ($_SESSION['login']['role'] == 0) {
            session_destroy();
            return $response->withRedirect($this->router->pathFor('admin.login'));

        } elseif ($_SESSION['login']['role'] == 1) {
            session_destroy();
            return $response->withRedirect($this->router->pathFor('admin.login'));
        }
    }

    public function setModerator(Request $request, Response $response, $args)
    {
         try {
            $result = $this->client->request('GET',
            $this->router->pathFor('admin.setModerator', ['id' => $args['id']]), [
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
        return $this->view->render($response, 'admin/request/request-all.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    // 
    } 

    public function cancelTaaruf(Request $request, Response $response, $args)
    {
         try {
            $result = $this->client->request('GET',
            $this->router->pathFor('user.cancel.proses', ['perequest' => $args['perequest'], 'terequest' => $args['terequest']]), [
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
            $result = $this->client->request('POST',  $this->router->pathFor('admin.create.provinsi', ['id' => $args['id']]),
                ['form_params' => [
                    'nama'          => $request->getParam('nama'),
                    'id_provinsi'          => $request->getParam('id_provinsi'),
                ]
            ]);


             try {
                $result1 = $this->client->request('GET',
                $this->router->pathFor('admin.negara'), [
                     'query' => [
                         'perpage' => 10,
                         'page' => $request->getQueryParam('page'),
                ]]);
                // $content = json_decode($result1->getBody()->getContents());
            } catch (GuzzleException $e) {
                $result1 = $e->getResponse();
            }

                $negara = json_decode($result1->getBody()->getContents(), true);
                var_dump($negara);die();
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }

        $content = $result->getBody()->getContents();
        $data = json_decode($content, true);
return $this->view->render($response, 'admin/crud/provinsi/provinsi.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    
        // if ($data['error'] == false) {
        //     $this->flash->addMessage('success', $data['message']);
        //     return $response->withRedirect($this->router->pathFor('admin.show.negara'));
        // } else {
        //     $this->flash->addMessage('error', $data['message']);
        //     return $response->withRedirect($this->router->pathFor('admin.show.negara'));
        // }
    }
}