<?php 

$app->get('/home', 'App\Controllers\Web\HomeController:index')->setName('home');