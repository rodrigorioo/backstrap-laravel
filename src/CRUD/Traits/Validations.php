<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Traits;

use Illuminate\Support\Facades\Schema;
use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Validation;

trait Validations {

    public function getValidations (): array {
        return $this->validations;
    }

    public function setValidations ($type, $setValidations) {

        $validations = $this->getValidations();

        foreach($setValidations as $setValidationName => $setValidation) {

            if(array_key_exists($setValidationName, $validations)) {

                foreach($setValidation as $dataName => $dataValue) {
                    $validations[$setValidationName][$dataName] = $dataValue;
                }

            }

        }

        $this->validations = $validations;
    }

    public function deleteValidation($fieldName) {
        unset($this->validations[$fieldName]);
    }

    public function createValidation($fieldName, $rules, $attribute, $messages = []) {

        // $this->validations[$fieldName]['rules'] = $fieldValidation;
        // $this->validations[$fieldName] = array_merge(self::$validationCreate[$fieldName], $extras);

        $this->validations[$fieldName] = new Validation($fieldName, $rules, $attribute, $messages);
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