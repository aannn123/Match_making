<?php 

$app->get('/activateaccount/{token}', 'App\Controllers\Api\Users\UserController:activateAccount')->setName('api.activate');


$app->group('/api', function() use ($app, $container) {
    $app->post('/search', 'App\Controllers\Api\Users\UserController:searchUser')->setName('api.search.User');
    $app->get('/', 'App\Controllers\Api\HomeController:index')->setName('home');
    $app->post('/register', 'App\Controllers\Api\Users\UserController:register')->setName('register');
    $app->post('/{id}/register/change-image', 'App\Controllers\Api\Users\UserController:postImage')->setname('api.user.image');
    $app->post('/login', 'App\Controllers\Api\Users\UserController:login')->setname('api.user.login');
    $app->post('/reset', 'App\Controllers\Api\Users\UserController:forgotPassword')->setName('api.reset');
    $app->get('/password/reset/{token}', 'App\Controllers\Api\Users\UserController:getResetPassword')->setName('api.get.reset');
    $app->post('/password/reset', 'App\Controllers\Api\Users\UserController:resetPassword')->setName('api.reset.password');

    $app->group('/admin', function() use ($app, $container) {
        $app->get('/setModerator/{id}', 'App\Controllers\Api\AdminController:setModerator');

        $app->group('/negara', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\NegaraController:getAllNegara');
            $app->post('/create', 'App\Controllers\Api\NegaraController:createNegara');
            $app->put('/update/{id}', 'App\Controllers\Api\NegaraController:updateNegara');
            $app->delete('/delete/{id}', 'App\Controllers\Api\NegaraController:delete');
            $app->get('/find/{id}', 'App\Controllers\Api\NegaraController:findNegara');
        });

        $app->group('/provinsi', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\ProvinsiController:getAllprovinsi');
            $app->post('/create/{id}', 'App\Controllers\Api\ProvinsiController:createProvinsi');
            $app->put('/update/{id}', 'App\Controllers\Api\ProvinsiController:updateProvinsi');
            $app->get('/find/{id}', 'App\Controllers\Api\ProvinsiController:findProvinsi');
            $app->delete('/delete/{id}', 'App\Controllers\Api\ProvinsiController:deleteProvinsi');
        });

        $app->group('/kota', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\KotaController:getAllKota');
            $app->post('/create', 'App\Controllers\Api\KotaController:createkota');
            $app->put('/update/{id}', 'App\Controllers\Api\KotaController:updateKota');
            $app->get('/find/{id}', 'App\Controllers\Api\KotaController:findKota');
            $app->delete('/delete/{id}', 'App\Controllers\Api\KotaController:deleteKota');
        });
    });

    $app->group('/user', function() use ($app, $container) {
        $app->get('/list-user-ikhwan', 'App\Controllers\Api\Users\UserController:getAllUserMan')->setName('api.show.user.man');
        $app->get('/list-user-akhwat', 'App\Controllers\Api\Users\UserController:getAllUserWoman')->setName('api.show.user.woman');

        $app->group('/profile', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\Users\ProfilController:showProfileUser');
            $app->post('/create', 'App\Controllers\Api\Users\ProfilController:createProfile');
            $app->put('/update', 'App\Controllers\Api\Users\ProfilController:updateProfile');
            $app->get('/find/{id}', 'App\Controllers\Api\Users\ProfilController:findProfil');

        });

        $app->group('/ciri-fisik', function() use ($app, $container) {
            $app->get('/show', 'App\Controllers\Api\Users\CiriFisikController:getAll');
            $app->post('/create/pria', 'App\Controllers\Api\Users\CiriFisikController:createCiriFisikPria');
            $app->post('/create/wanita', 'App\Controllers\Api\Users\CiriFisikController:createCiriFisikWanita');            
            $app->put('/update/pria', 'App\Controllers\Api\Users\CiriFisikController:updateFisikPria');   
            $app->put('/update/wanita', 'App\Controllers\Api\Users\CiriFisikController:updateFisikWanita');            
        });

        $app->group('/keseharian', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\Users\KeseharianController:getAll');

            $app->post('/create', 'App\Controllers\Api\Users\KeseharianController:createKeseharian');
            $app->put('/update', 'App\Controllers\Api\Users\KeseharianController:updateKeseharian');
            $app->get('/find/{id}', 'App\Controllers\Api\Users\KeseharianController:findData');
        });

        $app->group('/latar-belakang', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\Users\LatarBelakangController:getAll');
            $app->post('/create', 'App\Controllers\Api\Users\LatarBelakangController:createLatarBelakang');
            $app->put('/update', 'App\Controllers\Api\Users\LatarBelakangController:updateLatarBelakang');
            $app->get('/find/{id}', 'App\Controllers\Api\Users\LatarBelakangController:findData');
        });

        $app->group('/poligami', function() use ($app, $container) {
            $app->get('', 'App\Controllers\Api\Users\Poligami\PoligamiController:getAll');
            $app->post('/create', 'App\Controllers\Api\Users\Poligami\PoligamiController:createPoligami');
            $app->put('/update', 'App\Controllers\Api\Users\Poligami\PoligamiController:updatePoligami');
            $app->get('/find/{id}', 'App\Controllers\Api\Users\Poligami\PoligamiController:findData');

        });

    });

});