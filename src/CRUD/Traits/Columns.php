<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Traits;

use Illuminate\Support\Facades\Schema;
use Rodrigorioo\BackStrapLaravel\CRUD\Classes\Column;

trait Columns {

    public function getColumns (): array {
        return $this->columns;
    }

    public function setColumns (array $setColumns) : void {

        $columns = $this->getColumns();

        foreach($setColumns as $setColumnName => $setColumn) {

            if(isset($columns[$setColumnName])) {

                foreach($setColumn as $dataName => $dataValue) {

                    switch($dataName) {
                        case 'type': $columns[$setColumnName]->setType($dataValue); break;
                    }
                }

            } else {
                $columns[$setColumnName] = $this->createColumnClass(
                    $setColumnName,
                    $setColumn['type'],
                );
            }

        }

        $this->columns = $columns;
    }

    public function deleteColumn(string $columnName) {
        unset($this->columns[$columnName]);
    }

    public function createColumnClass (string $columnName, string $type) : Column
    {
        $name = ucwords(str_replace('_', ' ', $columnName));

        return new Column($columnName, $name, $type);
    }

    public function createColumn (string $columnName, string $type) {

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