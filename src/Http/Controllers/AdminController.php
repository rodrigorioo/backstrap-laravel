<?php

namespace Rodrigorioo\BackStrapLaravel\Http\Controllers;

class AdminController extends Controller {

    public function home() {
        return view('backstrap_laravel::admin.home');
    }
}