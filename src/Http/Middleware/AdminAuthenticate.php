<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $login = 1)
    {
        $guard = config('backstrap_laravel.guard');

        if($login) {

            if (!Auth::guard($guard['name'])->check()) {
                return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\Auth\LoginController@login');
            }
        } else {
            if (Auth::guard($guard['name'])->check()) {
                return Redirect::to(action('Rodrigorioo\BackStrapLaravel\Http\Controllers\AdminController@home'));
            }
        }

        return $next($request);
    }
}
