<?php 

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthToken extends BaseMiddleware
{
    public function __invoke($request, $response, $next)
    {
        $token = $request->getHeader('Authorization')[0];

        $userToken = new \App\Models\Users\UserToken($this->db);
        $users = new \App\Models\Users\UserModel($this->db);

        $findUser = $userToken->find('token', $token);
        $user = $users->find('id', $findUser['user_id']);

         if (!$findUser) {
            $data['status'] = 401;
            $data['message'] = "Anda harus login";

            return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
        }

            $response = $next($request, $response);
            return $response;
    }
}
