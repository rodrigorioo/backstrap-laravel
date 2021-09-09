<?php

namespace Rodrigorioo\BackStrapLaravel\Traits\CRUD;

use Illuminate\Support\Facades\Schema;

trait Columns {

    protected static $columns = [];

    public static function addColumn ($columnName, $data) {

        $name = ucwords(str_replace('_', ' ', $columnName));
        if(!array_key_exists('name', $data)) {
            $data['name'] = $name;
        }

        self::$columns[$columnName] = $data;
    }

    public static function getColumns () {
        return self::$columns;
    }

    public static function setColumns ($setColumns) {

        $columns = self::$columns;

        foreach($setColumns as $setColumnName => $setColumn) {

            if(isset($columns[$setColumnName])) {

                foreach($setColumn as $dataName => $dataValue) {
                    $columns[$setColumnName][$dataName] = $dataValue;
                }
            }

        }

        self::$columns = $columns;
    }

    public static function addColumnsFromDB ($modelClass) {

        $table = $modelClass->getTable();

        $columnsDB = Schema::getColumnListing($table);

        foreach($columnsDB as $columnDB) {

            $type = 'text';

            if($columnDB == 'updated_at') continue;
            if($columnDB == 'created_at') $type = 'datetime';

            self::addColumn($columnDB, [
                'type' => $type,
            ]);
        }
    }

}