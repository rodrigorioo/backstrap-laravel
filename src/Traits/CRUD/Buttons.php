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

        $html = '';

        if($link) {
            $html .= '<a href="'.$link.'">';
        }

        $html .= '<button type="button" class="btn '.$classes.' mr-2 btn--'.$buttonName.'">'.$text.'</button>';

        if($link) {
            $html .= '</a>';
        }

        self::addButton($buttonName, [
            'html' => $html,
        ]);
    }

    public static function deleteButton($buttonName) {
        unset(self::$buttons[$buttonName]);
    }
}