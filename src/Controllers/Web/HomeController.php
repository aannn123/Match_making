<?php 

namespace App\Controllers\Web;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\BadResponseException as GuzzleException;
use GuzzleHttp;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class HomeController extends BaseController
{

    public function index($request, $response)
    {
            $users = new \App\Models\Users\UserModel($this->db);
            $requests = new \App\Models\Users\RequestModel($this->db);
            // $item = new \App\Models\Item($this->db);
            // $user = new \App\Models\Users\UserModel($this->db);

            $allUser = count($users->getAllData()->fetchAll());
            $newUser = count($users->getAllNewUser()->fetchAll());
            $userMan = count($users->getAllUserMan()->fetchAll());
            $userWoman = count($users->getAllUserWoman()->fetchAll());
            $userRequest = count($requests->joinRequestAll()->fetchAll());
            $userProses = count($requests->getTaaruf()->fetchAll());
            // $inActiveArticle = count($article->getAllTrash());
            // $inActiveItem = count($item->getAllTrash());

            // var_dump($activeGroup);die();
            // 
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

            $request = json_decode($result->getBody()->getContents(), true);

            $_SESSION['notif'] = [
                'req' => $request['data'],
                'blok' => $blokir['data'],
                'approve' => $approve['data'],
            ];
            // var_dump($_SESSION['notif']);
            $data = $this->view->render($response, 'home.twig', [
                'counts'=> [
                    'allUser'         =>  $allUser,
                    'newUser'          =>  $newUser,
                    'userMan'       =>  $userMan,
                    'userWoman'          =>  $userWoman,
                    'userRequest'   =>  $userRequest,
                    'userProses'   =>  $userProses,
                    // 'inact_user'    =>  $inActiveUser,
                    // 'inact_article' =>  $inActiveArticle,
                    // 'inact_item'    =>  $inActiveItem,
                ]
            ]);
        return $data;
    }

    public function requestProfil(Request $request, Response $response, $args)
    {
        $users = new \App\Models\Users\UserModel($this->db);
        $requests = new \App\Models\Users\RequestModel($this->db);

        $allNotification = count($requests->allNotification()->fetchAll());
        var_dump($allNotification);die;
        $data = $this->view->render($response, 'user/user.twig', [
                'counts'=> [
                    'allNotification'         =>  $allNotification,
                ]
            ]);
        return $data;
    }

    public function notFound($request, $response)
    {
        return $this->view->render($response, 'response/404.twig');
    }
}



    // public function index(Request $request, Response $response)
    // {
        
    //     try {
    //         $result1 = $this->client->request('GET',
    //         $this->router->pathFor('api.show.user'), [
    //             'query' => [
    //                 'page'    => $request->getQueryparam('page'),
    //                 'perpage' => 10,
    //                 'user_id' => $args['id']
    //                 ]
    //             ]);
    //             try {
    //             $result2 = $this->client->request('GET',
    //             $this->router->pathFor('api.new.user'), [
    //                     'query' => [
    //                         'perpage' => 10,
    //                         'page'    => $request->getQueryParam('page'),
    //                     ]
    //                 ]);
    //             try {
    //             $result3 = $this->client->request('GET',
    //             $this->router->pathFor('api.show.user.man'), [
    //                     'query' => [
    //                         'perpage' => 10,
    //                         'page'    => $request->getQueryParam('page'),
    //                     ]
    //                 ]);

    //             try {
    //             $result4 = $this->client->request('GET',
    //             $this->router->pathFor('api.show.user.woman'), [
    //                     'query' => [
    //                         'perpage' => 10,
    //                         'page'    => $request->getQueryParam('page'),
    //                     ]
    //                 ]);
    //     } catch (GuzzleException $e) {
    //                 $result2 = $e->getResponse();
    //             }
    //                 $new = json_decode($result2->getBody()->getContents(), true);
    //                 $count1 = count($new['data']);
    //     } catch (GuzzleException $e) {
    //                 $result3 = $e->getResponse();
    //             }
    //                 $ikhwan = json_decode($result3->getBody()->getContents(), true);
    //                 $count2 = count($ikhwan['data']['count']);
    //                 var_dump($count2);die();
    //     } catch (GuzzleException $e) {
    //         $result = $e->getResponse();
    //     }

    //     } catch (GuzzleException $e) {
    //                 $result1 = $e->getResponse();
    //         }

    //     $user = json_decode($result1->getBody()->getContents(), true);
    //     $count = count($user['data']);
    //     // var_dump($count);die();

    //     // echo "<br />";
    //     // var_dump($data); die();
    //     return $this->view->render($response, 'home.twig', [
    //         'count_user' => $count,
    //         'count_new' => $count1,
    //         'count_ikhwan' => $count2,
    //         'count_akhwat' => $count3,
    //     ]);

    // }
// }