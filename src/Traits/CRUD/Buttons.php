<?php

namespace Rodrigorioo\BackStrapLaravel\Traits\CRUD;

trait Buttons {

    protected static $buttons = [
        'edit_button' => [
            'html' => '',
        ],
        'delete_button' => [
            'html' => '',
        ],
    ];

    public static function addButton ($buttonName, $html) {

    }

    public static function getButtons () {
        return self::$buttons;
    }
}