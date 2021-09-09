<?php

namespace Rodrigorioo\BackStrapLaravel\Traits\CRUD;

use Collective\Html\FormFacade;

trait FormInput {

    public static function getFormInput($inputName, $inputData, $errors) {

        $returnInput = null;

        $inputExtraData = ['class' => 'form-control '.($errors->has($inputName) ? 'is-invalid' : '')];
        if(array_key_exists('required', $inputData)) {
            $inputExtraData['required'] = 'required';
        }

        switch($inputData['type']) {

            case 'text':
            case 'textarea':
                $returnInput = FormFacade::{$inputData['type']}($inputName, null, $inputExtraData);
        }

        return $returnInput;
    }
}