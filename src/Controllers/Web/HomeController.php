<?php 

namespace App\Controllers\Web;

class HomeController extends BaseController
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'home.twig');
    }
}