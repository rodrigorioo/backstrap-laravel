<?php

namespace Rodrigorioo\BackStrapLaravel\View\Components;

use Illuminate\View\Component;

class Errors extends Component {

    public $errors;

    public function __construct($errors) {
        $this->errors = $errors;
    }

    public function render() {
        return view('backstrap_laravel::components.errors');
    }
}