<?php

namespace App\Controllers\Api;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Slim\Container;

abstract class BaseController
{
    protected $container;

    public function __construct(Container $container)
    {
        return $this->container = $container;
    }

    public function __get($property)
    {
        return $this->container->{$property};
    }

    // Detail ResponseWithJson API
    public function responseWithJson(array $data)
    {
        return $this->response->withHeader('Content-type', 'application/json')
        ->withJson($data, $data['code']);
    }

    // Detail ResponseWithJson API
    public function responseDetail($code, $error, $message, array $data = null)
    {
        if (empty($data['pagination'])) {
            $data['pagination'] = null;
        }
        if (empty($data['data'])) {
            $data['data'] = [];
        }
        if (empty($data['key'])) {
            $data['key'] = null;
        }

        $response = [
            'code'      => $code,
            'error'     => $error,
            'message'   => $message,
            'data'      => $data['data'],
            'pagination'=> $data['pagination'],
            'key'       => $data['key']
        ];

        if ($data['pagination'] == null) {
            unset($response['pagination']);
        }

        if ($data['key'] == null) {
            unset($response['key']);
        }

        return $this->responseWithJson($response, $code);
    }

    // Set Paginate
    function paginateArray($data, int $page, int $per_page)
    {
        $total = count($data);
        $pages = (int) ceil($total / $per_page);

        $start = ($page - 1) * ($per_page);
        // $offset = $per_page;

        $outArray = array_slice($data, $start, $per_page);

        $result = [
            'data'       => $outArray,
            'pagination' =>[
                'total_data'    => $total,
                'perpage'       => $per_page,
                'current'       => $page,
                'total_page'    => $pages,
                'first_page'    => 1,
            ]
        ];

        return $result;
    }

}
