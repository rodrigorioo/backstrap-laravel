<?php

namespace Rodrigorioo\BackStrapLaravel\Traits\CRUD;

use Collective\Html\FormFacade;

trait FormInput {

    public static function getFormInput($inputName, $inputData, $errors, $model = null) {

        $returnInput = null;

        $class = '';

        switch($inputData['type']) {

            case 'text':
            case 'textarea':
            case 'select':
                $class = 'form-control';
                break;

            default:
                $class = 'form-control-file';
                break;
        }

        $inputExtraData = ['class' => $class.' '.($errors->has($inputName) ? 'is-invalid' : '')];

        $inputExtraData = array_merge($inputExtraData, self::getInputExtraData($inputData));

        switch($inputData['type']) {

            case 'text':
            case 'textarea':

                $value = null;
                if($model !== null) {
                    $value = $model->{$inputName};
                }

                $returnInput = FormFacade::{$inputData['type']}($inputName, $value, $inputExtraData);
                break;

            case 'select':

                $values = $inputData['data'];

                $value = null;
                if($model !== null) {
                    $value = $model->{$inputName};
                }

                $returnInput = FormFacade::{$inputData['type']}($inputName, $values, $value, $inputExtraData);
                break;

            case 'image':

                $returnInput = '';

                $value = null;
                if($model !== null) {

                    $value = $model->{$inputName};

                    if($value != '') {
                        $returnInput .= '<div class="my-1"><img src="'.asset($value).'" class="img-fluid" style="max-height: 150px;"></div>';
                    }
                }

                $returnInput .= FormFacade::file($inputName, $inputExtraData);
                break;
        }

        return $returnInput;
    }

    private static function getInputExtraData($extraData) {

        $inputExtraData = [];

        if(array_key_exists('required', $extraData)) {
            $inputExtraData['required'] = 'required';
        }

        if(array_key_exists('placeholder', $extraData)) {
            $inputExtraData['placeholder'] = $extraData['placeholder'];
        }

        return $inputExtraData;
    }
}