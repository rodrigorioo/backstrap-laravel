<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes\Fields;

use Collective\Html\FormFacade;
use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Field;

class Textarea extends Field {

    public function render ($errors, $model = null) {

        $value = null;
        if($model !== null) {
            $value = $this->getValue($model);
        }

        $returnInput = FormFacade::label($this->getFieldName(), $this->getName());
        $returnInput .= FormFacade::textarea($this->getFieldName(), $value, $this->getExtraData($errors));

        // Error message
        $returnInput .= $this->getErrorMessage($errors);

        return $returnInput;
    }

}