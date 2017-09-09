<?php 

$app->get('/home', 'App\Controllers\Web\HomeController:index')->setName('home');
$app->get('/admin', 'App\Controllers\Web\AdminController:getLogin')->setName('admin.login');
$app->post('/admin', 'App\Controllers\Web\AdminController:login')->setName('post.login');
$app->get('/logout', 'App\Controllers\Web\AdminController:logout')->setName('logout');

$app->group('/admin', function() use ($app, $container) {
        $app->get('/home', 'App\Controllers\Web\HomeController:index')->setName('admin.home');
    $app->group('/user', function() use ($app, $container) {
        $app->get('',  'App\Controllers\Web\AdminController:getAllUser')->setName('admin.user');
        $app->get('/setModerator/{id}',  'App\Controllers\Web\AdminController:setModerator')->setName('admin.setModerator.user');
        $app->get('/new',  'App\Controllers\Web\AdminController:getAllNewUser')->setName('admin.new.user.all');
        $app->get('/new/approve/{id}',  'App\Controllers\Web\AdminController:approveUser')->setName('admin.approve.new.user');
        $app->get('/new/cancel/{id}',  'App\Controllers\Web\AdminController:cancelUser')->setName('admin.cancel.new.user');
        $app->get('/profil/{id}',  'App\Controllers\Web\AdminController:getUserDetail')->setName('admin.detail.user');
        $app->get('/pria',  'App\Controllers\Web\AdminController:getAllUserMan')->setName('admin.list.pria.user');
        $app->get('/wanita',  'App\Controllers\Web\AdminController:getAllUserWoman')->setName('admin.list.wanita.user');
        $app->get('/get-taaruf',  'App\Controllers\Web\AdminController:getTaaruf')->setName('admin.show.taaruf');
        $app->get('/get-request-all',  'App\Controllers\Web\AdminController:getAllRequest')->setName('admin.show.all.request');
    });

    $app->group('/kota', function() use ($app, $container) {
        $app->get('',  'App\Controllers\Web\AdminController:getAllKota')->setName('admin.kota');
    });

    $app->group('/provinsi', function() use ($app, $container) {
        $app->get('',  'App\Controllers\Web\AdminController:getAllProvinsi')->setName('admin.provinsi');
    });

     $app->group('/negara', function() use ($app, $container) {
        $app->get('',  'App\Controllers\Web\AdminController:getAllNegara')->setName('admin.negara');
    });
});

