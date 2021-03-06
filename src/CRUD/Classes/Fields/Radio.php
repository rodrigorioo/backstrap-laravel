<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes\Fields;

use Collective\Html\FormFacade;
use Illuminate\Http\Request;
use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Field;

class Radio extends Field {

    public function render ($errors, $model = null) {

        $returnInput = '<div class="row">';

        $values = $this->getData();

        $value = null;
        if($model !== null) {
            $value = $model->{$this->getFieldName()};
        }

        foreach($values as $iValue => $textValue) {
            $returnInput .= '
            <div class="col-12 col-sm-3">
                <div class="form-check form-check-inline mr-1">
                    '.FormFacade::radio($this->getFieldName(), $iValue, ($value == $iValue), $this->getExtraData($errors)).'
                    '.FormFacade::label($this->getFieldName(), $textValue, ['class' => 'form-check-label']).'
                </div>
            </div>';
        }

        $returnInput .= '</div>';

        // Error message
        $returnInput .= $this->getErrorMessage($errors);

        return $returnInput;
    }

    public function getFieldClass(): string {
        return 'form-check-input';
    }
}