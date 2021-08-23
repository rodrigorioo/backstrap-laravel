<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Rodrigorioo\BackStrapLaravel\Facades\BackStrapLaravel;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\Controller;
use Rodrigorioo\BackStrapLaravel\Http\Requests\AuthenticateRequest;

class LoginController extends Controller {

    public function login (Request $request) {

        return view('backstrap_laravel::login')->with([
            'urlLogin' => BackStrapLaravel::getLoginURL(),
        ]);
    }

    public function authenticate(AuthenticateRequest $request) {

        $guard = config('backstrap_laravel.guard');

        if (Auth::guard($guard['name'])->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            if (Auth::guard($guard['name'])->user()->is_active) {

                return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdminController@home');

            } else {
                Auth::guard($guard['name'])->logout();
            }
        }

        return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\Auth\LoginController@login')->withErrors([
            'login' => 'Usuario/Contraseña incorrectos'
        ]);
    }

    public function logout() {

        $guard = config('backstrap_laravel.guard');

        Auth::guard($guard['name'])->logout();

        return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\Auth\LoginController@login');
    }
}