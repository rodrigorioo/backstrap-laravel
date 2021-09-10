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

    public static function addButton ($buttonName, $data) {
        self::$buttons[$buttonName] = $data;
    }

    public static function getButtons (): array {
        return self::$buttons;
    }
}