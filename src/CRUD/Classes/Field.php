<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

use Illuminate\Http\Request;

class Field
{

    private string $fieldName = "";
    private string $name;
    private string $classes = "";
    private array $data = [];

    public function __construct ($fieldName, $name, $classes, $data) {
        $this->setFieldName($fieldName);
        $this->setName($name);
        $this->setClasses($classes);
        $this->setData($data);
    }

    protected function getExtraData ($errors) : array {

        $inputExtraData = [];

        // Classes
        $inputExtraData['class'] = ($errors->has($this->getFieldName()) ? 'is-invalid ' : ''). $this->getFieldClass().' '.$this->getClasses();

        // Add extra data
        if(array_key_exists('required', $this->getData())) {
            $inputExtraData['required'] = 'required';
        }

        if(array_key_exists('placeholder', $this->getData())) {
            $inputExtraData['placeholder'] = $this->getData()['placeholder'];
        }

        return $inputExtraData;
    }

    // Override functions

    public function render ($errors, $model = null) {

    }

    public function getValue (Request $request, $defaultValue = null) {
        return $request->{$this->getFieldName()};
    }

    public function getFieldClass () : string {
        return 'form-control';
    }

    public function getErrorMessage ($errors) : string {
        return '<span class="error invalid-feedback">'.$errors->first($this->getFieldName()).'</span>';
    }

    /**
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * @param string $fieldName
     */
    public function setFieldName(string $fieldName): void
    {
        $this->fieldName = $fieldName;
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
    public function getClasses(): string
    {
        return $this->classes;
    }

    /**
     * @param string $classes
     */
    public function setClasses(string $classes): void
    {
        $this->classes = $classes;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }



}