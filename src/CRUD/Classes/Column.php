<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

use Carbon\Carbon;

class Column {

    private string $columnName;
    private string $name;
    private string $type;

    public function __construct ($columnName, $name, $type) {
        $this->setColumnName($columnName);
        $this->setName($name);
        $this->setType($type);
    }

    public function parseValue($value) {

        $parsedValue = null;

        switch($this->getType()) {

            case 'datetime':

                $parsedValue = Carbon::parse($value)->format('d/m/Y H:i:s');
                break;

            case 'date':

                $parsedValue = Carbon::parse($value)->format('d/m/Y');
                break;

            case 'image':

                $parsedValue = '<img src="'.asset($value).'" class="img-fluid" style="max-height: 35px;">';
                break;

            default:

                $parsedValue = $value;
                break;
        }

        return $parsedValue;
    }

    /**
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }

    /**
     * @param string $columnName
     */
    public function setColumnName(string $columnName): void
    {
        $this->columnName = $columnName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

}