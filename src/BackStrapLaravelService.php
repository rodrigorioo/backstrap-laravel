<?php

namespace Rodrigorioo\BackStrapLaravel;

use Illuminate\Support\Facades\Auth;
use Rodrigorioo\BackStrapLaravel\Menu\Builder;
use Rodrigorioo\BackStrapLaravel\Traits\Assets;
use Rodrigorioo\BackStrapLaravel\Traits\Breadcrumbs;
use Rodrigorioo\BackStrapLaravel\Traits\URL;

class BackStrapLaravelService {

    use Assets, Breadcrumbs, URL;

    public static function getTemplateConfiguration(array $configuration = []) : array {

        $backgroundColorHeader = config('backstrap_laravel.background_color_header');
        $backgroundColorNavbar = config('backstrap_laravel.background_color_navbar');
        $backgroundColorBody = config('backstrap_laravel.background_color_body');
        $backgroundColorFooter = config('backstrap_laravel.background_color_footer');

        return [
            'prefix' => config('backstrap_laravel.prefix'),
            'title' => config('backstrap_laravel.title'),
            'background_color_header' => ($backgroundColorHeader != '') ? 'background-color: '.$backgroundColorHeader.'!important' : '',
            'menu' => Builder::getMenu(),
            'meta_tags' => self::getMetaTags(),
            'background_color_navbar' => ($backgroundColorNavbar != '') ? 'background-color: '.$backgroundColorNavbar.'!important' : '',
            'css' => self::getCSS(),
            'js' => self::getJS(),
            'background_color_body' => ($backgroundColorBody != '') ? 'background-color: '.$backgroundColorBody.'!important' : '',
            'logged_user' => self::getLoggedUser(),
            'login_configuration' => self::getLoginConfiguration(),
            'background_color_footer' => ($backgroundColorFooter != '') ? 'background-color: '.$backgroundColorFooter.'!important' : '',
            'footer' => self::footer(),
        ];
    }

    public static function getMetaTags () : string {

        return '
            <base href="./">
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
            <meta name="description" content="'.config('backstrap_laravel.meta_description').'">
            <meta name="author" content="'.config('backstrap_laravel.meta_author').'">
            <meta name="keyword" content="'.config('backstrap_laravel.meta_keyword').'">
        ';
    }
    /**
     * @return mixed
     */
    public static function getLoggedUser () {

        $guard = config('backstrap_laravel.guard');

        return Auth::guard($guard['name'])->user();
    }

    public static function getLoginConfiguration () : array {
        return [
            'login_url' => config('backstrap_laravel.login_url'),
            'logout_url' => config('backstrap_laravel.logout_url'),
            'register_url' => config('backstrap_laravel.register_url'),
            'forgot_password_url' => config('backstrap_laravel.forgot_password_url'),
            'password_reset_url' => config('backstrap_laravel.password_reset_url'),

            'full_login_url' => config('backstrap_laravel.prefix').'/'.config('backstrap_laravel.login_url'),
            'full_logout_url' => config('backstrap_laravel.prefix').'/'.config('backstrap_laravel.logout_url'),
            'full_register_url' => config('backstrap_laravel.prefix').'/'.config('backstrap_laravel.register_url'),
            'full_forgot_password_url' => config('backstrap_laravel.prefix').'/'.config('backstrap_laravel.forgot_password_url'),
            'full_password_reset_url' => config('backstrap_laravel.prefix').'/'.config('backstrap_laravel.password_reset_url'),
        ];
    }

    public static function footer () : array {
        return config('backstrap_laravel.footer');
    }

}