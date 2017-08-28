<?php 

namespace App\Middleware;

abstract class BaseMiddleware
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
