<?php 

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AdminMiddleware extends BaseMiddleware
{
    public function __invoke($request, $response, $next)
    {
        $token  = $request->getHeader('Authorization')[0];

        $userToken = new \App\Models\Users\userToken($this->db);
        $findToken = $userToken->find('token', $token);

        $users = new \App\Models\Users\UserModel($this->db);
        $findUser = $users->find('id', $findToken['user_id']);

        if (!$findUser || $findUser['role'] == 1) {
            $data['status'] = 401;
            $data['message'] = "Anda bukan Admin";

            return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
        }

            $response = $next($request, $response);

            return $response;
    }
}
