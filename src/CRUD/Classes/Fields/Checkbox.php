<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes\Fields;

use Collective\Html\FormFacade;
use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Field;

class Checkbox extends Field {

    public function render ($errors, $model = null) {

        $returnInput = '<div class="row">';

        $values = $this->getData();

        $value = null;
        if($model !== null) {
            $value = $this->getValue($model);
        }

        foreach($values as $iValue => $textValue) {
            $returnInput .= '
            <div class="col-12 col-sm-3">
                <div class="form-check form-check-inline mr-1">
                    '.FormFacade::checkbox($this->getFieldName().'[]', $iValue, ($value == $iValue), $this->getExtraData($errors)).'
                    '.FormFacade::label($this->getFieldName().'[]', $textValue, ['class' => 'form-check-label']).'
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