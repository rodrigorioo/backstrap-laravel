<?php

namespace Rodrigorioo\BackStrapLaravel\View\Components;

use Illuminate\View\Component;

class Alert extends Component {

    public $messages;

    public function __construct($messages) {
        $this->messages = $messages;
    }

    public function render() {
        return view('backstrap_laravel::components.alert');
    }
}