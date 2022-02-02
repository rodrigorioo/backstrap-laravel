<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes\Fields;

use Collective\Html\FormFacade;
use Illuminate\Http\Request;
use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Field;

class Image extends Field {

    public function render ($errors, $model = null) {

        $returnInput = FormFacade::label($this->getFieldName(), $this->getName());

        $value = null;
        if($model !== null) {

            $value = $model->{$this->getFieldName()};

            if($value != '') {
                $returnInput .= '<div class="my-1"><img src="'.asset($value).'" class="img-fluid" style="max-height: 150px;"></div>';
            }
        }

        $returnInput .= FormFacade::file($this->getFieldName(), $this->getExtraData($errors));

        // Error message
        $returnInput .= $this->getErrorMessage($errors);

        return $returnInput;
    }

    public function getValue(Request $request, $defaultValue = null) {

        $value = null;

        if($request->file($this->getFieldName())) {

            $uploadFile = config('backstrap_laravel.upload_file');
            $file = $request->file($this->getFieldName());

            $fileUrl = $uploadFile['directory'].'/'.$file->store(strtolower($this->getFieldName()), 'backstrap_laravel');

            $value = $fileUrl;
        } else {
            $value = $defaultValue;
        }

        return $value;
    }

    public function getFieldClass(): string {
        return 'form-control-file';
    }
}