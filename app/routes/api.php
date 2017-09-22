<?php

$app->group('/api', function() use ($app, $container) {
    $app->get('/activateaccount/{token}', 'App\Controllers\Api\Users\UserController:activateAccount')->setName('api.activate');
    $app->post('/search', 'App\Controllers\Api\Users\UserController:searchUser')->setName('api.search.User');
    $app->get('/', 'App\Controllers\Api\HomeController:index')->setName('home');
    $app->post('/register', 'App\Controllers\Api\Users\UserController:register')->setName('register');
    $app->post('/{id}/register/change-image', 'App\Controllers\Api\Users\UserController:postImage')->setname('api.user.image');
    $app->post('/login', 'App\Controllers\Api\Users\UserController:login')->setname('api.user.login');
    $app->post('/reset', 'App\Controllers\Api\Users\UserController:forgotPassword')->setName('api.forgot.password');
    $app->get('/password/reset/{token}', 'App\Controllers\Api\Users\UserController:getResetPassword')->setName('api.get.reset');
    $app->post('/password/reset', 'App\Controllers\Api\Users\UserController:resetPassword')->setName('api.reset.password');
    $app->get('/test', 'App\Controllers\Api\AdminController:test')->setName('test');

    $app->group('/admin', function() use ($app, $container) {
        $app->get('/setModerator/{id}', 'App\Controllers\Api\AdminController:setModerator')->setName('admin.setModerator');
        $app->get('/approveUser/{id}', 'App\Controllers\Api\AdminController:approveUser')->setName('admin.approve.user');
        $app->get('/user/cancel/{id}', 'App\Controllers\Api\AdminController:cancelUser')->setName('admin.cancel.user');
        $app->get('/get-taaruf', 'App\Controllers\Api\AdminController:getTaaruf')->setName('admin.get.taaruf');
        $app->get('/get-taaruf/cancel/{id}', 'App\Controllers\Api\AdminController:cancelTaaruf')->setName('admin.cancel.proses');
        $app->get('/new-user', 'App\Controllers\Api\AdminController:showNewUser')->setName('admin.new.user');
        $app->get('/show-request-all', 'App\Controllers\Api\AdminController:showRequestAll')->setName('admin.request.all');
        $app->get('/find/taaruf/{perequest}/{terequest}', 'App\Controllers\Api\AdminController:findTaaruf')->setName('admin.find.taaruf');
        $app->post('/search', 'App\Controllers\Api\Users\UserController:searchUserAll')->setName('api.search.user.all');



        $app->group('/negara', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\NegaraController:getAllNegara')->setName('admin.negara');
            $app->post('/create', 'App\Controllers\Api\NegaraController:createNegara')->setName('admin.create.negara');
            $app->put('/update/{id}', 'App\Controllers\Api\NegaraController:updateNegara');
            $app->delete('/delete/{id}', 'App\Controllers\Api\NegaraController:delete');
            $app->get('/find/{id}', 'App\Controllers\Api\NegaraController:findNegara');
        });

        $app->group('/provinsi', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\ProvinsiController:getAllprovinsi')->setName('admin.provinsi');
            $app->post('/create', 'App\Controllers\Api\ProvinsiController:createProvinsi')->setName('admin.create.provinsi');
            $app->put('/update/{id}', 'App\Controllers\Api\ProvinsiController:updateProvinsi');
            $app->get('/find/{id}', 'App\Controllers\Api\ProvinsiController:findProvinsi');
            $app->delete('/delete/{id}', 'App\Controllers\Api\ProvinsiController:deleteProvinsi');
        });

        $app->group('/kota', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\KotaController:getAllKota')->setName('api.admin.kota');
            $app->post('/create', 'App\Controllers\Api\KotaController:createkota')->setName('admin.create.kota');
            $app->put('/update/{id}', 'App\Controllers\Api\KotaController:updateKota');
            $app->get('/find/{id}', 'App\Controllers\Api\KotaController:findKota');
            $app->delete('/delete/{id}', 'App\Controllers\Api\KotaController:deleteKota');
        });
    });

    $app->group('/user', function() use ($app, $container) {
        $app->get('', 'App\Controllers\Api\Users\UserController:getAllData')->setName('api.show.user');
        $app->get('/join', 'App\Controllers\Api\Users\UserController:allJoinUser')->setName('api.show.user.join');
        $app->get('/find/{id}', 'App\Controllers\Api\Users\UserController:findByUser')->setName('api.find.user');
        $app->get('/new', 'App\Controllers\Api\Users\UserController:getAllNewUser')->setName('api.new.user');
        $app->get('/send-request/{id}', 'App\Controllers\Api\Users\UserController:sendRequest')->setName('api.send.request');
        $app->get('/approve-request/{id}', 'App\Controllers\Api\Users\UserController:approveRequest')->setName('api.approve.request');
        $app->get('/notification', 'App\Controllers\Api\Users\UserController:getAllNotification')->setName('api.notification');
        $app->get('/notification/blokir/{id}', 'App\Controllers\Api\Users\UserController:blokirRequestUser')->setName('api.notification.blokir.request');
        $app->get('/notification/blokir', 'App\Controllers\Api\Users\UserController:getAllBlokirRequest')->setName('api.notification.blokir');
        $app->get('/request-all', 'App\Controllers\Api\Users\UserController:getAllRequest')->setName('api.request.all');
        $app->get('/list-user-ikhwan', 'App\Controllers\Api\Users\UserController:getAllUserMan')->setName('api.show.user.man');
        $app->get('/list-user-akhwat', 'App\Controllers\Api\Users\UserController:getAllUserWoman')->setName('api.show.user.woman');

        $app->group('/profile', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\Users\ProfilController:showProfileUser')->setName('api.show.profile');
            $app->post('/create', 'App\Controllers\Api\Users\ProfilController:createProfile')->setName('api.user.create.profil');
            $app->put('/update', 'App\Controllers\Api\Users\ProfilController:updateProfile');
            $app->get('/find/{id}', 'App\Controllers\Api\Users\ProfilController:findProfil')->setName('user.find.profil');

        });

        $app->group('/ciri-fisik', function() use ($app, $container) {
            $app->get('/show/pria', 'App\Controllers\Api\Users\CiriFisikController:getAllFisikPria');
            $app->get('/show/wanita', 'App\Controllers\Api\Users\CiriFisikController:getAllFisikWanita');
            $app->post('/create/pria', 'App\Controllers\Api\Users\CiriFisikController:createCiriFisikPria')->setName('api.user.create.ciri.fisik.pria');
            $app->post('/create/wanita', 'App\Controllers\Api\Users\CiriFisikController:createCiriFisikWanita')->setName('api.user.create.ciri.fisik.wanita');
            $app->put('/update/pria', 'App\Controllers\Api\Users\CiriFisikController:updateFisikPria');
            $app->put('/update/wanita', 'App\Controllers\Api\Users\CiriFisikController:updateFisikWanita');
            $app->get('/find/{id}', 'App\Controllers\Api\Users\CiriFisikController:findData')->setName('user.find.ciri-fisik');

        });

        $app->group('/keseharian', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\Users\KeseharianController:getAll');

            $app->post('/create', 'App\Controllers\Api\Users\KeseharianController:createKeseharian')->setName('api.user.create.keseharian');
            $app->put('/update', 'App\Controllers\Api\Users\KeseharianController:updateKeseharian');
            $app->get('/find/{id}', 'App\Controllers\Api\Users\KeseharianController:findData')->setName('user.find.keseharian');
        });

        $app->group('/latar-belakang', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\Users\LatarBelakangController:getAll')->setName('api.show.latar');
            $app->post('/create', 'App\Controllers\Api\Users\LatarBelakangController:createLatarBelakang')->setName('api.user.create.latar-belakang');
            $app->put('/update', 'App\Controllers\Api\Users\LatarBelakangController:updateLatarBelakang');
            $app->get('/find/{id}', 'App\Controllers\Api\Users\LatarBelakangController:findData')->setName('user.find.latar-belakang');
        });

        $app->group('/poligami', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\Users\Poligami\PoligamiController:getAll');
            $app->post('/create', 'App\Controllers\Api\Users\Poligami\PoligamiController:createPoligami')->setName('api.user.create.poligami');
            $app->put('/update', 'App\Controllers\Api\Users\Poligami\PoligamiController:updatePoligami');
            $app->get('/find/{id}', 'App\Controllers\Api\Users\Poligami\PoligamiController:findData')->setName('user.find.poligami');

        });

        $app->group('/dipoligami', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\Users\Poligami\DipoligamiController:getAll');
            $app->post('/create', 'App\Controllers\Api\Users\Poligami\DipoligamiController:createDiPoligami');
            $app->put('/update', 'App\Controllers\Api\Users\Poligami\DipoligamiController:updateDiPoligami');
            $app->get('/find/{id}', 'App\Controllers\Api\Users\Poligami\DipoligamiController:findData')->setName('user.find.dipoligami');

        });

    });

});
