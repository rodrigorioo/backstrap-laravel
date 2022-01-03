<?php

use Illuminate\Support\Facades\Route;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\API\RoleController;

Route::prefix('api')->group(function () {

    Route::group(['middleware' => ['api']], function () {
        Route::apiResources([
            'roles' => RoleController::class,
        ]);
    });
});

