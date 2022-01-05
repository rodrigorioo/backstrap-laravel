<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\Controller;
use Rodrigorioo\BackStrapLaravel\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function index() {

        $guard = config('backstrap_laravel.guard');
        $user = Auth::guard($guard['name'])->user();

        return view('backstrap_laravel::admin.profile.edit')->with([
            'user' => $user,
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $guard = config('backstrap_laravel.guard');
        $user = Auth::guard($guard['name'])->user();

        $user->name = $request->input('name');
        if ($request->input('password') != '') {
            $user->password = Hash::make($request->input('password'));
        }

        if ($user->save()) {
            $alertSuccess = config('backstrap_laravel.alert_success');
            return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\ProfileController@index')->withAlert(array_merge($alertSuccess, [
                'title' => __('backstrap_laravel::alerts.success.title'),
                'text' => __('backstrap_laravel::alerts.success.text'),
                'close' => __('backstrap_laravel::alerts.success.close'),
            ]));
        }

        $alertError = config('backstrap_laravel.alert_error');
        return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\ProfileController@index')->withAlert(array_merge($alertError, [
            'title' => __('backstrap_laravel::alerts.error.title'),
            'text' => __('backstrap_laravel::alerts.error.text'),
            'close' => __('backstrap_laravel::alerts.error.close'),
        ]));
    }
}
