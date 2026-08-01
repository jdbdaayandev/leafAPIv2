<?php

use LeafAPI\Routing\RouteFacade as Route;
use App\Controllers\UserController;



Route::prefix('/api/v1')
->group(function(){


    Route::get('/users', [

        UserController::class,

        'index'

    ]);



    Route::get('/users/{id}', [

        UserController::class,

        'show'

    ]);


});