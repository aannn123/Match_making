<?php 

$app->group('/api', function() use ($app, $container) {

    $app->get('/', 'App\Controllers\api\HomeController:index')->setName('home');


    $app->group('/negara', function() use ($app, $container) {
        $app->get('', 'App\Controllers\api\NegaraController:getAllNegara');
        $app->post('/create', 'App\Controllers\api\NegaraController:createNegara');
        $app->put('/update/{id}', 'App\Controllers\api\NegaraController:updateNegara');
        $app->delete('/delete/{id}', 'App\Controllers\api\NegaraController:delete');
        $app->get('/find/{id}', 'App\Controllers\api\NegaraController:findNegara');
    });

    $app->group('/provinsi', function() use ($app, $container) {
        $app->get('', 'App\Controllers\api\ProvinsiController:getAllprovinsi');
        $app->post('/create/{id}', 'App\Controllers\api\ProvinsiController:createProvinsi');
        $app->put('/update/{id}', 'App\Controllers\api\ProvinsiController:updateProvinsi');
        $app->get('/find/{id}', 'App\Controllers\api\ProvinsiController:findProvinsi');
        $app->delete('/delete/{id}', 'App\Controllers\api\ProvinsiController:deleteProvinsi');
    });

    $app->group('/kota', function() use ($app, $container) {
        $app->get('', 'App\Controllers\api\KotaController:getAllKota');
        $app->post('/create', 'App\Controllers\api\KotaController:createkota');
        $app->put('/update/{id}', 'App\Controllers\api\KotaController:updateKota');
        $app->get('/find/{id}', 'App\Controllers\api\KotaController:findKota');
        $app->delete('/delete/{id}', 'App\Controllers\api\KotaController:deleteKota');
    });
});