<?php

namespace Rodrigorioo\BackStrapLaravel\Traits\CRUD;

use Collective\Html\FormFacade;
use Illuminate\Support\Facades\Route;

trait FormInput {

    public static function getFormInput($inputName, $inputData, $errors, $model = null) {

        $returnInput = null;

        $class = '';

        switch($inputData['type']) {

            case 'image':
                $class = 'form-control-file '.($errors->has($inputName) ? 'is-invalid' : '');
                break;

            case 'checkbox':
            case 'radio':
                $class = 'form-check-input';
                break;

            case 'ckeditor':
                $class = 'form-control ckeditor';
                break;

            default:
                $class = 'form-control '.($errors->has($inputName) ? 'is-invalid' : '');
                break;
        }

        $inputExtraData = array_merge(['class' => $class], self::getInputExtraData($inputData));

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

            case 'text':
            case 'textarea':

                $value = null;
                if($model !== null) {
                    $value = $model->{$inputName};
                }

                $returnInput = FormFacade::label($inputName, $inputData['name']);
                $returnInput .= FormFacade::{$inputData['type']}($inputName, $value, $inputExtraData);
                break;

            case 'ckeditor':

                $value = null;
                if($model !== null) {
                    $value = $model->{$inputName};
                }

                $returnInput = FormFacade::label($inputName, $inputData['name']);
                $returnInput .= FormFacade::textarea($inputName, $value, $inputExtraData);
                break;

            case 'hidden':

                $value = null;
                if($model !== null) {
                    $value = $model->{$inputName};
                } else {

                    if(isset($inputData['value'])) {

                        $inputDataValue = $inputData['value'];

                        if(is_array($inputDataValue)) {

                            // If value of input is "route_parameter" we search this value into the route_parameters names
                            if(isset($inputDataValue['route_parameter']) && $inputDataValue['route_parameter'] != '') {

                                $routeParameter = $inputDataValue['route_parameter'];

                                foreach(Route::getCurrentRoute()->parameters as $nameParameter => $valueParameter) {

                                    // If we found this route parameter, we assign the value to the value of input
                                    if($nameParameter == $routeParameter) {
                                        $value = $valueParameter;
                                    }
                                }
                            }

                        } else {
                            $value = $inputDataValue;
                        }
                    }
                }

                $returnInput .= FormFacade::hidden($inputName, $value, $inputExtraData);

                break;

            default:

                break;

        }

        return $returnInput;
    }

    public static function getInputErrorMessage ($errors, $inputName, $inputData) {

        $errorMessage = '<span class="error invalid-feedback">'.$errors->first($inputName).'</span>';

        if($errors->has($inputName)) {

            switch($inputData['type']) {
                case 'checkbox':
                case 'radio':
                    $errorMessage = '<span class="error invalid-feedback d-block">'.$errors->first($inputName).'</span>';
                    break;

            }

            return $errorMessage;
        }

        return '';
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