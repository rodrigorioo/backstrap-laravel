<?php

namespace Rodrigorioo\BackStrapLaravel\Traits\CRUD;

use Collective\Html\FormFacade;

trait FormInput {

    public static function getFormInput($inputName, $inputData, $errors, $model = null) {

        $returnInput = null;

        $class = '';

        switch($inputData['type']) {

            case 'image':
                $class = 'form-control-file';
                break;

            case 'checkbox':
            case 'radio':
                $class = 'form-check-input';
                break;

            default:
                $class = 'form-control';
                break;
        }

        $inputExtraData = ['class' => $class.' '.($errors->has($inputName) ? 'is-invalid' : '')];

        $inputExtraData = array_merge($inputExtraData, self::getInputExtraData($inputData));

        switch($inputData['type']) {

            case 'select':

                $values = $inputData['data'];

                $value = null;
                if($model !== null) {
                    $value = $model->{$inputName};
                }

                $returnInput = FormFacade::label($inputName, $inputData['name']);
                $returnInput .= FormFacade::{$inputData['type']}($inputName, $values, $value, $inputExtraData);
                break;

            case 'checkbox':

                $returnInput = '<div class="row">';

                $values = $inputData['data'];

                $value = null;
                if($model !== null) {
                    $value = $model->{$inputName};
                }

                foreach($values as $iValue => $textValue) {
                    $returnInput .= '
                                    <div class="col-12 col-sm-3">
                                        <div class="form-check form-check-inline mr-1">
                                            '.FormFacade::{$inputData['type']}($inputName.'[]', $iValue, ($value == $iValue), $inputExtraData).'
                                            '.FormFacade::label($inputName.'[]', $textValue, ['class' => 'form-check-label']).'
                                        </div>
                                    </div>';
                }

                $returnInput .= '</div>';

                break;

            case 'radio':

                $returnInput = '<div class="row">';

                $values = $inputData['data'];

                $value = null;
                if($model !== null) {
                    $value = $model->{$inputName};
                }

                foreach($values as $iValue => $textValue) {
                    $returnInput .= '
                                    <div class="col-12 col-sm-3">
                                        <div class="form-check form-check-inline mr-1">
                                            '.FormFacade::{$inputData['type']}($inputName, $iValue, ($value == $iValue), $inputExtraData).'
                                            '.FormFacade::label($inputName, $textValue, ['class' => 'form-check-label']).'
                                        </div>
                                    </div>';
                }

                $returnInput .= '</div>';

                break;

            case 'image':

                $returnInput = FormFacade::label($inputName, $inputData['name']);

                $value = null;
                if($model !== null) {

                    $value = $model->{$inputName};

                    if($value != '') {
                        $returnInput .= '<div class="my-1"><img src="'.asset($value).'" class="img-fluid" style="max-height: 150px;"></div>';
                    }
                }

                $returnInput .= FormFacade::file($inputName, $inputExtraData);
                break;

            default:

            case 'text':
            case 'textarea':

                $value = null;
                if($model !== null) {
                    $value = $model->{$inputName};
                }

                $returnInput = FormFacade::label($inputName, $inputData['name']);
                $returnInput .= FormFacade::{$inputData['type']}($inputName, $value, $inputExtraData);
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