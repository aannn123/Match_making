<?php 

namespace App\Middlewares\web;

use Slim\Container;

abstract class BaseMiddleware
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
