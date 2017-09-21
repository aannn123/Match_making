<?php

$app->get('/home', 'App\Controllers\Web\HomeController:index')->setName('home');
$app->get('/admin', 'App\Controllers\Web\AdminController:getLogin')->setName('admin.login');
$app->post('/admin', 'App\Controllers\Web\AdminController:loginAdmin')->setName('post.login');
$app->get('/logout', 'App\Controllers\Web\AdminController:logout')->setName('logout');
$app->get('/register', 'App\Controllers\Web\UserController:getRegister')->setName('user.register');
$app->post('/register', 'App\Controllers\Web\UserController:register')->setName('user.post.register');

$app->get('/forgot-password', 'App\Controllers\Web\UserController:getForgotPassword')->setName('forgot.password');
$app->post('/forgot-password', 'App\Controllers\Web\UserController:forgotPassword')->setName('post.forgot.password');

$app->get('/', 'App\Controllers\Web\UserController:getLogin')->setName('user.login');
$app->post('/', 'App\Controllers\Web\UserController:login')->setName('post.login.user');

// $app->get('/{id}/change-image/get', 'App\Controllers\Web\UserController:getChangeImage')->setName('user.change.image');
$app->post('/{id}/change-image', 'App\Controllers\Web\UserController:changeImage')->setName('user.post.change.image');


$app->group('', function() use ($app, $container) {

$app->group('/admin', function() use ($app, $container) {
    $app->get('/home', 'App\Controllers\Web\HomeController:index')->setName('admin.home');
    $app->group('/user', function() use ($app, $container) {
        $app->get('',  'App\Controllers\Web\AdminController:getAllUser')->setName('admin.user');
        $app->post('/search',  'App\Controllers\Web\AdminController:searchUser')->setName('admin.user.search');
        $app->get('/setModerator/{id}',  'App\Controllers\Web\AdminController:setModerator')->setName('admin.setModerator.user');
        $app->get('/new',  'App\Controllers\Web\AdminController:getAllNewUser')->setName('admin.new.user.all');
        $app->get('/new/approve/{id}',  'App\Controllers\Web\AdminController:approveUser')->setName('admin.approve.new.user');
        $app->get('/new/cancel/{id}',  'App\Controllers\Web\AdminController:cancelUser')->setName('admin.cancel.new.user');
        $app->get('/profil/{id}',  'App\Controllers\Web\AdminController:getUserDetail')->setName('admin.detail.user');
        $app->get('/pria',  'App\Controllers\Web\AdminController:getAllUserMan')->setName('admin.list.pria.user');
        $app->get('/wanita',  'App\Controllers\Web\AdminController:getAllUserWoman')->setName('admin.list.wanita.user');
        $app->get('/get-taaruf',  'App\Controllers\Web\AdminController:getTaaruf')->setName('admin.show.taaruf');
        $app->get('/get-taaruf/find/{perequest}/{terequest}',  'App\Controllers\Web\AdminController:findTaaruf')->setName('admin.find.taaruf');
        $app->get('/get-request-all',  'App\Controllers\Web\AdminController:getAllRequest')->setName('admin.show.all.request');
        $app->get('/get-taaruf/cancel/taaruf/{id}',  'App\Controllers\Web\AdminController:cancelTaaruf')->setName('admin.cancel.taaruf');
        // $app->get('/search-user',  'App\Controllers\Web\AdminController:searchUser')->setName('admin.search.user');

    });

    $app->group('/kota', function() use ($app, $container) {
        $app->get('',  'App\Controllers\Web\AdminController:getAllKota')->setName('admin.show.kota');
        $app->post('/create',  'App\Controllers\Web\AdminController:createKota')->setName('admin.tambah.kota');
    });

    $app->group('/provinsi', function() use ($app, $container) {
        $app->get('',  'App\Controllers\Web\AdminController:getAllProvinsi')->setName('admin.show.provinsi');
        $app->post('/create',  'App\Controllers\Web\AdminController:createProvinsi')->setName('admin.tambah.provinsi');
    });

     $app->group('/negara', function() use ($app, $container) {
        $app->get('',  'App\Controllers\Web\AdminController:getAllNegara')->setName('admin.show.negara');
        $app->post('/create',  'App\Controllers\Web\AdminController:createNegara')->setName('admin.tambah.negara');
    });
})->add(new \App\Middlewares\web\AdminMiddleware($container));

    $app->group('/user', function() use ($app, $container) {
        $app->get('',  'App\Controllers\Web\UserController:home')->setName('user.home');
        // $app->get('/list-user',  'App\Controllers\Web\UserController:getAllUserPria')->setName('user.list.pria');
        $app->get('/create/profil',  'App\Controllers\Web\UserController:getCreateProfil')->setName('user.create.profil');
        $app->post('/create/profil',  'App\Controllers\Web\UserController:createProfil')->setName('user.create.profil.post');

        $app->get('/create/keseharian',  'App\Controllers\Web\UserController:getCreateKeseharian')->setName('user.create.keseharian');
        $app->post('/create/keseharian',  'App\Controllers\Web\UserController:createKeseharian')->setName('user.post.create.keseharian');

        $app->get('/create/latar-belakang',  'App\Controllers\Web\UserController:getCreateLatarBelakang')->setName('user.create.latar-belakang');
        $app->post('/create/latar-belakang',  'App\Controllers\Web\UserController:createLatarBelakang')->setName('user.post.create.latar-belakang');

        $app->get('/create/ciri-fisik',  'App\Controllers\Web\UserController:getCreateCiriFisik')->setName('user.create.ciri-fisik');
        $app->post('/create/ciri-fisik',  'App\Controllers\Web\UserController:createCiriFisik')->setName('user.post.create.ciri-fisik');

        $app->get('/create/poligami',  'App\Controllers\Web\UserController:getCreatePoligami')->setName('user.create.poligami');
        $app->post('/create/poligami',  'App\Controllers\Web\UserController:createPoligami')->setName('user.post.create.poligami');

        $app->get('/profil',  'App\Controllers\Web\UserController:myProfil')->setName('user.my.profil');

        $app->get('/statistik',  'App\Controllers\Web\UserController:statistikRequest')->setName('user.statistik');

        $app->get('/notification',  'App\Controllers\Web\UserController:getNotification')->setName('user.notification');

    });

})->add(new \App\Middlewares\web\AuthMiddleware($container));
