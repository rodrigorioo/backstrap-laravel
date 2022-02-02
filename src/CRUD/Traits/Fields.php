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

                    switch($dataName) {

                        case 'type':
                            $actualField = $fields[$setFieldName];

                            $fields[$setFieldName] = $this->createFieldClass($setFieldName, $dataValue, $actualField->getClasses(), $actualField->getData());

                            break;

                        case 'classes': $fields[$setFieldName]->setClasses($dataValue); break;

                        case 'data': $fields[$setFieldName]->setData($dataValue); break;
                    }
                }

            } else {
                $fields[] = $this->createFieldClass(
                    $setFieldName,
                    $setField['type'],
                    (isset($setField['classes'])) ? $setField['classes'] : '',
                    (isset($setField['data'])) ? $setField['data'] : [],
                );
            }

        }

        $this->fields = $fields;
    }

    public function deleteField($fieldName) {
        unset($this->fields[$fieldName]);
    }

    public function createFieldClass (string $fieldName, string $type, string $classes = '', array $data = []) {

        $name = ucwords(str_replace('_', ' ', $fieldName));
        $typeClass = 'Rodrigorioo\BackStrapLaravel\CRUD\Classes\Fields\\'.ucwords($type);

        return new $typeClass($fieldName, $name, $classes, $data);
    }

    public function createField (string $fieldName, string $type, string $classes = '', array $data = []) {
        $this->fields[$fieldName] = $this->createFieldClass($fieldName, $type, $classes, $data);
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