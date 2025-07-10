<?php

$routes->group('admin', function ($routes) {


    $routes->resource('unidades_medida', [
        'filter' => 'permission:unidades_medida-permission',
        'controller' => 'unidades_medidaController',
        'except' => 'show',
        'namespace' => 'julio101290\boilerplateunidadesmedidas\Controllers'
    ]);
    $routes->post('unidades_medida/save'
            , 'Unidades_medidaController::save'
            , ['namespace' => 'julio101290\boilerplateunidadesmedidas\Controllers']
    );

    $routes->post('unidades_medida/getUnidades_medida'
            , 'Unidades_medidaController::getUnidades_medida'
            , ['namespace' => 'julio101290\boilerplateunidadesmedidas\Controllers']
    );

    $routes->post('unidades_medida/getUnidadesAjax'
            , 'Unidades_medidaController::getUnidadesAjax'
            , ['namespace' => 'julio101290\boilerplateunidadesmedidas\Controllers']
    );
    
});
