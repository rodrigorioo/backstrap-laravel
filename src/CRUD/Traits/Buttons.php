<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Traits;

use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Button;

trait Buttons {

    public function getButtons (): array {
        return $this->buttons;
    }

    public function createButton(string $buttonName, string $text, string $classes = '', $link = null) {
        $this->buttons[$buttonName] = new Button($buttonName, $link, $classes, $text);
    }

    public function editButton ($buttonName, $data) {

        // If exists the button
        if(array_key_exists($buttonName, $this->buttons)) {

            if(array_key_exists('link', $data)) {
                $this->buttons[$buttonName]->setUrl($data['link']);
            }
        }
    }

    public function deleteButton($buttonName) {
        unset($this->buttons[$buttonName]);
    }

    public function addDefaultButtons () {
        $this->createButton('edit_button', 'Editar', "btn btn-success btn-sm mr-1", '');
        $this->createButton('delete_button', 'Borrar', "delete btn btn-danger btn-sm", '');

    }
}