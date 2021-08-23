<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Rodrigorioo\BackStrapLaravel\Facades\BackStrapLaravel;
use Rodrigorioo\BackStrapLaravel\Http\Controllers\Controller;
use Rodrigorioo\BackStrapLaravel\Http\Requests\ChangePasswordRequest;
use Rodrigorioo\BackStrapLaravel\Http\Requests\RequestNewPasswordRequest;
use Rodrigorioo\BackStrapLaravel\Http\Requests\ResetPasswordRequest;
use Rodrigorioo\BackStrapLaravel\Models\Administrator;
use Rodrigorioo\BackStrapLaravel\Notifications\ForgotPasswordNotification;

class ForgotPasswordController extends Controller {

    public function forgotPassword () {

        return view('backstrap_laravel::forgot_password')->with([
            'login_configuration' => BackStrapLaravel::getLoginConfiguration(),
        ]);
    }

    public function requestNewPassword (RequestNewPasswordRequest $request) {

        $existToken = DB::table('password_resets')
            ->where('email', $request->input('email'))
            ->first();

        if(empty($existToken)) {

            $token = md5($request->input('email'));

            DB::table('password_resets')
                ->insert([
                    'email' => $request->input('email'),
                    'token' => $token,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

        } else {

            $token = $existToken->token;

        }

        $administrator = Administrator::where('email', $request->input('email'))
            ->first();
        $administrator->notify(new ForgotPasswordNotification($administrator, $token));

        return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\Auth\ForgotPasswordController@forgotPassword')->with([
            'success' => 'Notificación enviada con éxito',
        ]);
    }

    public function resetPassword (ResetPasswordRequest $request) {

        return view('backstrap_laravel::reset_password')->with([
            'token' => $request->input('token'),
            'login_configuration' => BackStrapLaravel::getLoginConfiguration(),
        ]);
    }

    public function changePassword (ChangePasswordRequest $request) {

        $passwordReset = DB::table('password_resets')
            ->where('token', $request->input('token'))
            ->first();

        $administrator = Administrator::where('email', $passwordReset->email)
            ->first();
        $administrator->password = Hash::make($request->input('password'));
        $administrator->save();

        DB::table('password_resets')
            ->where('token', $request->input('token'))
            ->delete();

        return Redirect::action('Rodrigorioo\BackStrapLaravel\Http\Controllers\Auth\ForgotPasswordController@forgotPassword')->with([
            'success' => 'Contraseña cambiada con éxito',
        ]);
    }
}