<?php 

namespace App\Controllers\web;

class HomeController extends BaseController
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'home.twig');
    }
}