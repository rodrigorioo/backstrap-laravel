<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes\Fields;

use Collective\Html\FormFacade;

class Text extends Field {

    public function render ($errors, $model = null) {

        $value = null;
        if($model !== null) {
            $value = $model->{$this->getFieldName()};
        }

        $returnInput = FormFacade::label($this->getFieldName(), $this->getName());
        $returnInput .= FormFacade::text($this->getFieldName(), $value, $this->getExtraData($errors));

        // Error message
        $returnInput .= $this->getErrorMessage($errors);

        return $returnInput;
    }
}