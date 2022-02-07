<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes\Fields;

use Collective\Html\FormFacade;
use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Field;

class Hidden extends Field {

    public function render ($errors, $model = null) {

        $value = null;
        if($model !== null) {
            $value = $model->{$this->getFieldName()};
        } else {
            if(array_key_exists('value', $this->getData())) {
                $value = $this->getData()['value'];
            }
        }

        $returnInput = FormFacade::hidden($this->getFieldName(), $value, $this->getExtraData($errors));

        // Error message
        $returnInput .= $this->getErrorMessage($errors);

        return $returnInput;
    }
}