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

    public static function createButton($buttonName, $text, $classes, $link = null) {
        self::addButton($buttonName, [
            'text' => $text,
            'classes' => $classes,
            'link' => $link,
        ]);
    }

    public static function deleteButton($buttonName) {
        unset(self::$buttons[$buttonName]);
    }
}