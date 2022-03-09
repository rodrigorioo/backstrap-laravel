<?php

namespace Rodrigorioo\BackStrapLaravel\Traits;

use Illuminate\Support\Arr;

trait URL {

    public static function getLoginURL() : string {
        return config('backstrap_laravel.prefix').'/'.config('backstrap_laravel.login_url');
    }

    public static function getLogoutURL() : string {
        return config('backstrap_laravel.prefix').'/'.config('backstrap_laravel.logout_url');
    }

    public static function generateLanguageURL($url, $newQuery) : string {

        // Get actual query
        $query = request()->query();

        // Replace actual query with new query
        $fullQuery = array_merge($query, $newQuery);

        return $url.'?'.Arr::query($fullQuery);
    }

}