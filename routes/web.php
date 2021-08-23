<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Rodrigorioo\BackStrapLaravel\Http\Controllers\Auth\LoginController;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\AdminController;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\ProfileController;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\Auth\ForgotPasswordController;

$prefix = config('backstrap_laravel.prefix');

Route::group(['prefix' => $prefix, 'middleware' => ['web']], function() {

    Route::group(['middleware' => ['backstrap_laravel_admin_authenticate:1']], function () {

        $logoutUrl = config('backstrap_laravel.logout_url');
        Route::get($logoutUrl, [LoginController::class, 'logout']);

        $customHome = config('backstrap_laravel.custom_home');
        if(!$customHome) {
            Route::get('/', [AdminController::class, 'home']);
        }

        // PROFILE
        Route::get('profile', [ProfileController::class, 'index']);
        Route::post('profile/update', [ProfileController::class, 'update']);

        $guard = config('backstrap_laravel.guard');

        // ADMINISTRATORS
        Route::get('administrator/{administrator}/change-status', [AdministratorController::class, 'changeStatus'])->middleware('role:super-admin,'.$guard['name']);

        Route::group([/*'middleware' => ['role:super-admin']*/], function() {

            Route::resources([
                'administrators' => AdministratorController::class,
            ]);
        });

    });

    Route::group(['middleware' => ['backstrap_laravel_admin_authenticate:0']], function() {

        $loginUrl = config('backstrap_laravel.login_url');
        Route::get($loginUrl, [LoginController::class, 'login']);
        Route::post($loginUrl, [LoginController::class,'authenticate']);

        $forgotPasswordUrl = config('backstrap_laravel.forgot_password_url');
        Route::get($forgotPasswordUrl, [ForgotPasswordController::class, 'forgotPassword']);
        Route::post($forgotPasswordUrl, [ForgotPasswordController::class, 'requestNewPassword']);

        $passwordResetUrl = config('backstrap_laravel.password_reset_url');
        Route::get($passwordResetUrl, [ForgotPasswordController::class, 'resetPassword']);
        Route::post($passwordResetUrl, [ForgotPasswordController::class, 'changePassword']);
    });

});