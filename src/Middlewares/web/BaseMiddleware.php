<?php 

namespace App\Middleware\web;

abstract class BaseMiddleware
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
