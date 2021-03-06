<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Rodrigorioo\BackStrapLaravel\Http\Controllers\Auth\LoginController;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\AdminController;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\ProfileController;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\AdministratorController;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\RoleController;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\Auth\ForgotPasswordController;

$prefix = config('backstrap_laravel.prefix');

Route::group(['prefix' => $prefix, 'middleware' => ['web']], function() {

    Route::group(['middleware' => ['backstrap_laravel_admin_authenticate:1']], function () {

        $logoutUrl = config('backstrap_laravel.logout_url');
        if($logoutUrl) {
            Route::get($logoutUrl, [LoginController::class, 'logout']);
        }

        $customHome = config('backstrap_laravel.custom_home');
        if(!$customHome) {
            Route::get('/', [AdminController::class, 'home']);
        }

        // PROFILE
        Route::get('profile', [ProfileController::class, 'index']);
        Route::post('profile/update', [ProfileController::class, 'update']);

        // ROLES
        $crudRoles = config('backstrap_laravel.crud_roles.enable');
        if($crudRoles) {
            Route::resource('roles', RoleController::class);

            // PERMISSIONS
            $crudPermissions = config('backstrap_laravel.crud_permissions.enable');
            if($crudPermissions) {
                Route::get('roles/{role}/permissions', [RoleController::class, 'permissions']);
                Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissions']);
            }
        }

        $guard = config('backstrap_laravel.guard');

        // ADMINISTRATORS
        Route::get('administrator/{administrator}/change-status', [AdministratorController::class, 'changeStatus'])->middleware('role:super-admin,'.$guard['name']);

        Route::group(['middleware' => ['role:super-admin,'.$guard['name']]], function() {

            Route::resources([
                'administrators' => AdministratorController::class,
            ]);
        });

    });

    Route::group(['middleware' => ['backstrap_laravel_admin_authenticate:0']], function() {

        $loginUrl = config('backstrap_laravel.login_url');
        if($loginUrl) {
            Route::get($loginUrl, [LoginController::class, 'login']);
            Route::post($loginUrl, [LoginController::class, 'authenticate']);
        }

        $forgotPasswordUrl = config('backstrap_laravel.forgot_password_url');
        if($forgotPasswordUrl) {
            Route::get($forgotPasswordUrl, [ForgotPasswordController::class, 'forgotPassword']);
            Route::post($forgotPasswordUrl, [ForgotPasswordController::class, 'requestNewPassword']);
        }

        $passwordResetUrl = config('backstrap_laravel.password_reset_url');
        if($forgotPasswordUrl) {
            Route::get($passwordResetUrl, [ForgotPasswordController::class, 'resetPassword']);
            Route::post($passwordResetUrl, [ForgotPasswordController::class, 'changePassword']);
        }
    });

});