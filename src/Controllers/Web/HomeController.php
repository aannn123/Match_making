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
        try {
            $result = $this->client->request('GET',
            $this->router->pathFor('api.show.profile'), [
                 'query' => [
                     'perpage' => 10,
                     'page' => $request->getQueryParam('page'),
                     'id' => $_SESSION['guard']
            ]]);
            // $content = json_decode($result->getBody()->getContents());
        } catch (GuzzleException $e) {
            $result = $e->getResponse();
        }
        $data = json_decode($result->getBody()->getContents(), true);
        // var_dump($content);die();
        return $this->view->render($response, 'home.twig', [
            'data'          =>  $data['data'] ,
            'pagination'    =>  $data['pagination']
        ]);    // return $this->view->render($response, 'guard/show-user.twig', $content->reporting);
    }
}