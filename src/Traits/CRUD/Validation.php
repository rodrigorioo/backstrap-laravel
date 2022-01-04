<?php

namespace Rodrigorioo\BackStrapLaravel\Traits\CRUD;

use Illuminate\Support\Facades\Schema;

trait Validation {

    protected static $validationCreate = [];
    protected static $validationEdit = [];

    private static function addValidation($type, $fieldName, $fieldValidation, $extras = []) {

        if($type == 'create') {
            self::$validationCreate[$fieldName]['rules'] = $fieldValidation;
            self::$validationCreate[$fieldName] = array_merge(self::$validationCreate[$fieldName], $extras);
        } else {
            self::$validationEdit[$fieldName]['rules'] = $fieldValidation;
            self::$validationEdit[$fieldName] = array_merge(self::$validationEdit[$fieldName], $extras);
        }
    }

    public static function addValidationCreate ($fieldName, $fieldValidation, $extras = []) {
        self::addValidation('create', $fieldName, $fieldValidation, $extras);
    }

    public static function addValidationEdit ($fieldName, $fieldValidation, $extras = []) {
        self::addValidation('edit', $fieldName, $fieldValidation, $extras);
    }

    public static function getValidationCreate (): array {
        return self::$validationCreate;
    }

    public static function getValidationEdit (): array {
        return self::$validationEdit;
    }

    private static function setValidation ($type, $setValidations) {

        if($type == 'create') {
            $validations = self::$validationCreate;
        } else {
            $validations = self::$validationEdit;
        }

        foreach($setValidations as $setValidationName => $setValidation) {

            if(array_key_exists($setValidationName, $validations)) {

                foreach($setValidation as $dataName => $dataValue) {
                    $validations[$setValidationName][$dataName] = $dataValue;
                }

            }

        }

        if($type == 'create') {
            self::$validationCreate = $validations;
        } else {
            self::$validationEdit = $validations;
        }
    }

    public static function setValidationCreate ($setValidations) {
        self::setValidation('create', $setValidations);
    }

    public static function setValidationEdit ($setValidations) {
        self::setValidation('edit', $setValidations);
    }

    public static function addValidationsFromDB ($modelClass) {

        $table = $modelClass->getTable();

        $columnsDB = Schema::getColumnListing($table);

        foreach($columnsDB as $columnDB) {

            if(in_array($columnDB, ['id', 'created_at', 'updated_at'])) continue;

            self::addValidationCreate($columnDB, [
                'required',
            ]);

            self::addValidationEdit($columnDB, [
                'required',
            ]);
        }
    }
}