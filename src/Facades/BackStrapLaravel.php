<?php

namespace Rodrigorioo\BackStrapLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class BackStrapLaravel extends Facade {

    protected static function getFacadeAccessor() {
        return 'backstrap_laravel';
    }

}