<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Traits;

use Illuminate\Support\Facades\Schema;
use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Validation;

trait Validations {

    public function getValidations (): array {
        return $this->validations;
    }

    public function setValidations ($setValidations) {

        $validations = $this->getValidations();

        foreach($setValidations as $setValidationName => $setValidation) {

            if(isset($validations[$setValidationName])) {

                foreach($setValidation as $dataName => $dataValue) {

                    switch($dataName) {
                        case 'rules': $validations[$setValidationName]->setRules($dataValue); break;
                        case 'attribute': $validations[$setValidationName]->setAttribute($dataValue); break;
                        case 'messages': $validations[$setValidationName]->setMessages($dataValue); break;
                        case 'prepare': $validations[$setValidationName]->setPrepare($dataValue); break;
                    }
                }

            } else {
                $validations[$setValidationName] = $this->createValidationClass(
                    $setValidationName,
                    $setValidation['rules'],
                    $setValidation['attribute'],
                    (isset($setValidation['messages'])) ? $setValidation['messages'] : [],
                    (isset($setValidation['prepare'])) ? $setValidation['prepare'] : null,
                );
            }

        }

        $this->validations = $validations;
    }

    public function deleteValidation($fieldName) {
        unset($this->validations[$fieldName]);
    }

    public function createValidationClass ($fieldName, $rules, $attribute, $messages = [], $prepare = null) : Validation
    {
        return new Validation($fieldName, $rules, $attribute, $messages, $prepare);
    }

    public function createValidation($fieldName, $rules, $attribute, $messages = [], $prepare = null) {
        $this->validations[$fieldName] = $this->createValidationClass($fieldName, $rules, $attribute, $messages = [], $prepare = null);
    }

    public function addValidationsFromDB ($modelClass) {

        $table = $modelClass->getTable();

        $columnsDB = Schema::getColumnListing($table);

        foreach($columnsDB as $columnDB) {

            if(in_array($columnDB, ['id', 'deleted_at', 'created_at', 'updated_at'])) continue;

            $this->createValidation($columnDB, [
                'required',
            ], $columnDB);
        }
    }
}