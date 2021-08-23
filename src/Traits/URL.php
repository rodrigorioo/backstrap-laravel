<?php

namespace Rodrigorioo\BackStrapLaravel\Traits;

trait URL {

    public static function getLoginURL() : string {
        return config('backstrap_laravel.prefix').'/'.config('backstrap_laravel.login_url');
    }

    public static function getLogoutURL() : string {
        return config('backstrap_laravel.prefix').'/'.config('backstrap_laravel.logout_url');
    }

}