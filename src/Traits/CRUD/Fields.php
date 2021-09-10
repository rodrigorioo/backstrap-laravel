<?php

namespace Rodrigorioo\BackStrapLaravel\Traits\CRUD;

use Illuminate\Support\Facades\Schema;

trait Fields {

    /**
     * @var array
     *
     */
    protected static array $fields = [];

    public static function addField ($fieldName, $data) {

        $name = ucwords(str_replace('_', ' ', $fieldName));
        if(!array_key_exists('name', $data)) {
            $data['name'] = $name;
        }

        self::$fields[$fieldName] = $data;
    }

    public static function getFields (): array {
        return self::$fields;
    }

    public static function setFields ($setFields) {

        $fields = self::$fields;

        foreach($setFields as $setFieldName => $setField) {

            if(isset($fields[$setFieldName])) {

                foreach($setField as $dataName => $dataValue) {
                    $fields[$setFieldName][$dataName] = $dataValue;
                }
            }

        }

        self::$fields = $fields;
    }

    public static function addFieldsFromDB ($modelClass) {

        $table = $modelClass->getTable();

        $columnsDB = Schema::getColumnListing($table);

        foreach($columnsDB as $columnDB) {

            if(in_array($columnDB, ['id', 'created_at', 'updated_at'])) continue;

            self::addField($columnDB, [
                'type' => 'text',
            ]);
        }
    }
}