<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

class Model {

    private $modelClass;
    private $modelInstance;
    private string $modelName;
    private string $modelNamePlural;

    public function __construct ($model) {

        $this->modelClass = $model;

        // Model names
        // if($this->modelName == '') {

            $explodeModel = explode("\\", $model);

            $this->modelName = $explodeModel[count($explodeModel) - 1];

            // if($this->modelNamePlural == '') {
                $this->modelNamePlural = ltrim(preg_replace('/[A-Z]/', ' $0', $this->modelName)).'s';
            // }
        // }

        $this->modelInstance = new $model;
    }

    /**
     * @return mixed
     */
    public function getModelClass()
    {
        return $this->modelClass;
    }

    /**
     * @return mixed
     */
    public function getModelInstance()
    {
        return $this->modelInstance;
    }
    /**
     * @return mixed|string
     */
    public function getModelName()
    {
        return $this->modelName;
    }

    /**
     * @param mixed|string $modelName
     */
    public function setModelName($modelName): void
    {
        $this->modelName = $modelName;
    }

    /**
     * @return string
     */
    public function getModelNamePlural(): string
    {
        return $this->modelNamePlural;
    }

    /**
     * @param string $modelNamePlural
     */
    public function setModelNamePlural(string $modelNamePlural): void
    {
        $this->modelNamePlural = $modelNamePlural;
    }

}