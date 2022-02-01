<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

class Validation {

    public string $fieldName = '';
    public array $rules = [];
    public string $attribute = '';
    public array $messages = [];
    public $prepare = null;

    public function __construct ($fieldName, $rules, $attribute, $messages, $prepare = null) {
        $this->setFieldName($fieldName);
        $this->setRules($rules);
        $this->setAttribute($attribute);
        $this->setMessages($messages);
        $this->setPrepare($prepare);
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
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     */
    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }

    /**
     * @return string
     */
    public function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * @param string $attribute
     */
    public function setAttribute(string $attribute): void
    {
        $this->attribute = $attribute;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param array $messages
     */
    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }

    /**
     * @return null
     */
    public function getPrepare()
    {
        return $this->prepare;
    }

    /**
     * @param null $prepare
     */
    public function setPrepare($prepare): void
    {
        $this->prepare = $prepare;
    }
}