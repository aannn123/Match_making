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

$app->get('/user/change-image', 'App\Controllers\Web\UserController:getChangeImage')->setName('user.change.image');
$app->post('/user/{id}/change-image', 'App\Controllers\Web\UserController:changeImage')->setName('user.post.change.image');

$app->get('/404', 'App\Controllers\Web\HomeController:notFound')->setName('not.found');

// $app->post('/register/{id}/change-image', 'App\Controllers\Web\UserController:changeImage')->setName('user.post.change.image');


$app->group('', function() use ($app, $container) {

$app->group('/admin', function() use ($app, $container) {
        $app->get('/home', 'App\Controllers\Web\HomeController:index')->setName('admin.home');
        $app->get('/get/notification',  'App\Controllers\Web\AdminController:getNotification')->setName('admin.notification.all');
    $app->group('/user', function() use ($app, $container) {
        $app->get('',  'App\Controllers\Web\AdminController:getAllUser')->setName('admin.user');
        $app->post('/search',  'App\Controllers\Web\AdminController:searchUser')->setName('admin.user.search');
        $app->get('/setModerator/{id}',  'App\Controllers\Web\AdminController:setModerator')->setName('admin.setModerator.user');
        $app->get('/setuserpremium/{id}',  'App\Controllers\Web\AdminController:setMemberPremium')->setName('admin.setpremium.user');
        $app->get('/new',  'App\Controllers\Web\AdminController:getAllNewUser')->setName('admin.new.user.all');
        $app->get('/new/detail/{id}',  'App\Controllers\Web\AdminController:getUserNewDetail')->setName('admin.new.detail.user');
        $app->get('/new/approve/{id}',  'App\Controllers\Web\AdminController:approveUser')->setName('admin.approve.new.user');
        $app->get('/new/cancel/{id}',  'App\Controllers\Web\AdminController:cancelUser')->setName('admin.cancel.new.user');
        $app->get('/profil/{id}',  'App\Controllers\Web\AdminController:getUserDetail')->setName('admin.detail.user');
        $app->get('/pria',  'App\Controllers\Web\AdminController:getAllUserMan')->setName('admin.list.pria.user');
        $app->get('/wanita',  'App\Controllers\Web\AdminController:getAllUserWoman')->setName('admin.list.wanita.user');
        $app->get('/get-taaruf',  'App\Controllers\Web\AdminController:getTaaruf')->setName('admin.show.taaruf');
        $app->get('/get-taaruf/find/{perequest}/{terequest}',  'App\Controllers\Web\AdminController:findTaaruf')->setName('admin.find.taaruf');
        $app->get('/get-request-all',  'App\Controllers\Web\AdminController:getAllRequest')->setName('admin.show.all.request');
        $app->get('/get-taaruf/cancel/taaruf/{id}',  'App\Controllers\Web\AdminController:cancelTaaruf')->setName('admin.cancel.taaruf');
        $app->get('/create', 'App\Controllers\Web\AdminController:getCreateMember')->setName('admin.create.user');
        $app->post('/create/user', 'App\Controllers\Web\AdminController:createMember')->setName('admin.post.create.user');
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
        $app->get('',  'App\Controllers\Web\UserController:getAllUserSearch')->setName('user.home');
        // $app->get('/list-user',  'App\Controllers\Web\UserController:getAllUserPria')->setName('user.list.pria');
        $app->get('/create/profil',  'App\Controllers\Web\UserController:getCreateProfil')->setName('user.create.profil');
        $app->post('/create/profil',  'App\Controllers\Web\UserController:createProfil')->setName('user.create.profil.post');

        $app->get('/create/keseharian',  'App\Controllers\Web\UserController:getCreateKeseharian')->setName('user.create.keseharian');
        $app->post('/create/keseharian',  'App\Controllers\Web\UserController:createKeseharian')->setName('user.post.create.keseharian');

        $app->get('/create/latar-belakang',  'App\Controllers\Web\UserController:getCreateLatarBelakang')->setName('user.create.latar-belakang');
        $app->post('/create/latar-belakang',  'App\Controllers\Web\UserController:createLatarBelakang')->setName('user.post.create.latar-belakang');

        $app->get('/create/ciri-fisik',  'App\Controllers\Web\UserController:getCreateCiriFisik')->setName('user.create.ciri-fisik');

        $app->post('/create/ciri-fisik',  'App\Controllers\Web\UserController:createCiriFisik')->setName('user.post.create.ciri-fisik');

        $app->post('/create/ciri-fisik/wanita',  'App\Controllers\Web\UserController:createCiriFisikWanita')->setName('user.post.create.ciri-fisik.wanita');

        $app->get('/create/poligami',  'App\Controllers\Web\UserController:getCreatePoligami')->setName('user.create.poligami');

        $app->post('/create/poligami',  'App\Controllers\Web\UserController:createPoligami')->setName('user.post.create.poligami');

        $app->get('/create/dipoligami',  'App\Controllers\Web\UserController:getCreateDipoligami')->setName('user.create.dipoligami');

        $app->post('/create/dipoligami',  'App\Controllers\Web\UserController:createDipoligami')->setName('user.post.create.dipoligami');

        $app->get('/profil',  'App\Controllers\Web\UserController:viewProfile')->setName('user.my.profil');

        $app->get('/statistik',  'App\Controllers\Web\UserController:statistikRequest')->setName('user.statistik');

        $app->get('/notification',  'App\Controllers\Web\UserController:getNotification')->setName('user.notification');

        $app->get('/notification/{id}',  'App\Controllers\Web\UserController:viewDetailNotification')->setName('user.notification.detail');

        $app->get('/view/detail/{id}',  'App\Controllers\Web\UserController:viewDetailUser')->setName('user.view.detail.user');

        $app->get('/update/profil',  'App\Controllers\Web\UserController:updateProfil')->setName('user.update.profil');

        $app->post('/update/profil',  'App\Controllers\Web\UserController:postUpdateProfil')->setName('user.post.update.profil');

        $app->get('/update/latar-belakang',  'App\Controllers\Web\UserController:updateLatarBelakang')->setName('user.update.latar-belakang');

        $app->post('/update/latar-belakang',  'App\Controllers\Web\UserController:postUpdateLatarBelakang')->setName('user.post.update.latar-belakang');

        $app->get('/update/ciri-fisik',  'App\Controllers\Web\UserController:updateCiriFisik')->setName('user.update.ciri-fisik');

        $app->post('/update/ciri-fisik',  'App\Controllers\Web\UserController:postUpdateCiriFisikPria')->setName('user.update.ciri-fisik.post.pria');

        $app->post('/update/ciri-fisik/wanita',  'App\Controllers\Web\UserController:postUpdateCiriFisikWanita')->setName('user.update.ciri-fisik.post.wanita');

        $app->get('/update/keseharian',  'App\Controllers\Web\UserController:updateKeseharian')->setName('user.update.keseharian');

        $app->post('/update/keseharian',  'App\Controllers\Web\UserController:postUpdateKeseharian')->setName('user.post.update.keseharian');

        $app->get('/update/poligami',  'App\Controllers\Web\UserController:updatePoligami')->setName('user.update.poligami');

        $app->post('/update/poligami',  'App\Controllers\Web\UserController:postUpdatePoligami')->setName('user.post.update.poligami');

        $app->post('/update/dipoligami',  'App\Controllers\Web\UserController:')->setName('user.post.update.dipoligami');

        $app->get('/change-password',  'App\Controllers\Web\UserController:getChangePassword')->setName('user.change-password');

        $app->post('/change-password',  'App\Controllers\Web\UserController:changePassword')->setName('user.post.change-password');

        $app->get('/send-request/{id}',  'App\Controllers\Web\UserController:sendRequest')->setName('user.send-request');

        $app->get('/cancel-request/{id}',  'App\Controllers\Web\UserController:cancelRequest')->setName('user.cancel-request');

        $app->get('/blokir-notification/{id}',  'App\Controllers\Web\UserController:blokirRequest')->setName('user.blokir-notification');

        $app->get('/delete/notification/{id}',  'App\Controllers\Web\UserController:deleteNotification')->setName('user.delete.notification');

        $app->get('/approve/request/{id}',  'App\Controllers\Web\UserController:approveRequest')->setName('user.approve.request');

        $app->get('/change/image',  'App\Controllers\Web\UserController:getUploadImage')->setName('user.change-image');

        $app->post('/change/image/{images}',  'App\Controllers\Web\UserController:changeImageGalery')->setName('user.change-image.post.galery');
        
        $app->get('/change/image/delete/{id}',  'App\Controllers\Web\UserController:deleteImageGalery')->setName('user.change-image.delete.galery');

        $app->post('/change/image',  'App\Controllers\Web\UserController:uploadImage')->setName('user.post.change-image');

        $app->get('/change/avatar',  'App\Controllers\Web\UserController:getChangeAvatar')->setName('user.change.avatar');

        $app->get('/cancel/taaruf/{id}',  'App\Controllers\Web\UserController:cancelTaaruf')->setName('user.cancel.taaruf');
        $app->get('/request/statistik',  'App\Controllers\Web\UserController:userStatistikRequest')->setName('user.request.statistik');
    });

})->add(new \App\Middlewares\web\AuthMiddleware($container));
