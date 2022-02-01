<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Traits;

use Illuminate\Support\Facades\Schema;

trait Fields {

    public function getFields (): array {
        return $this->fields;
    }

    public function setFields ($setFields) : void {

        $fields = $this->getFields();

        foreach($setFields as $setFieldName => $setField) {

            if(isset($fields[$setFieldName])) {

                foreach($setField as $dataName => $dataValue) {
                    $fields[$setFieldName][$dataName] = $dataValue;
                }
            }

        }

        $this->fields = $fields;
    }

    public function deleteField($fieldName) {
        unset($this->fields[$fieldName]);
    }

    public function createField (string $fieldName, string $type, string $classes = '', array $data = []) {

        $name = ucwords(str_replace('_', ' ', $fieldName));
        $typeClass = 'Rodrigorioo\BackStrapLaravel\CRUD\Classes\Fields\\'.ucwords($type);

        $this->fields[$fieldName] = new $typeClass($fieldName, $name, $classes, $data);
    }

    public function addFieldsFromDB ($modelClass) {

        $table = $modelClass->getTable();

        $columnsDB = Schema::getColumnListing($table);

        foreach($columnsDB as $columnDB) {

            if(in_array($columnDB, ['id', 'deleted_at', 'created_at', 'updated_at'])) continue;

            $this->createField($columnDB, 'text');
        }
    }


}