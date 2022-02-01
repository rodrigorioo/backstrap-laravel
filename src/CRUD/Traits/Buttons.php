<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Traits;

use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Button;

trait Buttons {

    protected static $buttons = [];

    public static function getButtons (): array {
        return self::$buttons;
    }

    public static function createButton(string $buttonName, string $text, string $classes = '', $link = null) {
        self::$buttons[$buttonName] = new Button($link, $classes, $text);
    }

    public static function editButton ($buttonName, $data) {
        self::$buttons[$buttonName] = $data;
    }

    public static function deleteButton($buttonName) {
        unset(self::$buttons[$buttonName]);
    }
}