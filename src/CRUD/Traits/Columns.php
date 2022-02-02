<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Traits;

use Illuminate\Support\Facades\Schema;
use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Column;

trait Columns {

    public function getColumns (): array {
        return $this->columns;
    }

    public function setColumns ($setColumns) {

        $columns = $this->getColumns();

        foreach($setColumns as $setColumnName => $setColumn) {

            if(isset($columns[$setColumnName])) {

                foreach($setColumn as $dataName => $dataValue) {
                    $columns[$setColumnName][$dataName] = $dataValue;
                }
            }

        }

        $this->columns = $columns;
    }

    public function deleteColumn($columnName) {
        unset($this->columns[$columnName]);
    }

    public function addColumn ($columnName, $type) {

        $name = ucwords(str_replace('_', ' ', $columnName));
//        if(!array_key_exists('name', $data)) {
//            $data['name'] = $name;
//        }

        $this->columns[$columnName] = new Column($columnName, $name, $type);
    }

    public function addColumnsFromDB ($modelClass) {

        $table = $modelClass->getTable();

        $columnsDB = Schema::getColumnListing($table);

        foreach($columnsDB as $columnDB) {

            $type = 'text';

            if(in_array($columnDB, ['deleted_at', 'updated_at'])) continue;

            if($columnDB == 'created_at') $type = 'datetime';

            $this->addColumn($columnDB, $type);
        }
    }

}