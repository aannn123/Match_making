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
        return $this->view->render($response, 'user/user.twig');
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
// var_dump($data['message']);die;
           if ($data['code'] == true ) {
                $_SESSION['login'] = $data['data'];
                // var_dump($_SESSION['login']['role'] == 1);die();
               if ($_SESSION['login']['role'] == 0 && $_SESSION['login']['status'] == 2 ) {
                   return $response->withRedirect($this->router->pathFor('user.home'));
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

    public function getFormData(Request $request, Response $response)
    {   
        return $this->view->render($response, 'user/data/form-data.twig');
    }
}
