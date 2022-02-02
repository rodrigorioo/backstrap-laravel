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

                    switch($dataName) {
                        case 'type': $columns[$setColumnName]->setType($dataValue); break;
                    }
                }

            } else {
                $columns[] = $this->createColumnClass(
                    $setColumnName,
                    $setColumn['type'],
                );
            }

        }

        $this->columns = $columns;
    }

    public function deleteColumn($columnName) {
        unset($this->columns[$columnName]);
    }

    public function createColumnClass ($columnName, $type) {
        $name = ucwords(str_replace('_', ' ', $columnName));

        return new Column($columnName, $name, $type);
    }

    public function createColumn ($columnName, $type) {

        $this->columns[$columnName] = $this->createColumnClass($columnName, $type);
    }

    public function addColumnsFromDB ($modelClass) {

        $table = $modelClass->getTable();

        $columnsDB = Schema::getColumnListing($table);

        foreach($columnsDB as $columnDB) {

            $type = 'text';

            if(in_array($columnDB, ['deleted_at', 'updated_at'])) continue;

            if($columnDB == 'created_at') $type = 'datetime';

            $this->createColumn($columnDB, $type);
        }
    }

}