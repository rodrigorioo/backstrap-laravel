<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Controllers;

use Rodrigorioo\BackStrapLaravel\Http\Controllers\Controller;

class AdminController extends Controller {

    public function home() {
        return view('backstrap_laravel::admin.home');
    }
}