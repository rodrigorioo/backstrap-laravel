<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

use Rodrigorioo\BackStrapLaravel\CRUD\Traits\Fields;

class Card {

    use Fields;

    private string $id = '';
    private string $name = '';
    private string $cardClass = '';
    private string $headerClass = '';
    private string $bodyClass = '';

    private array $fields = [];

    public function __construct ($id, $name, $cardClass = '', $headerClass = '', $bodyClass = '') {

        $this->setId($id);
        $this->setName($name);
        $this->setCardClass($cardClass);
        $this->setHeaderClass($headerClass);
        $this->setBodyClass($bodyClass);
    }

    public function render () {

    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
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
    public function getCardClass(): string
    {
        return $this->cardClass;
    }

    /**
     * @param string $cardClass
     */
    public function setCardClass(string $cardClass): void
    {
        $this->cardClass = $cardClass;
    }

    /**
     * @return string
     */
    public function getHeaderClass(): string
    {
        return $this->headerClass;
    }

    /**
     * @param string $headerClass
     */
    public function setHeaderClass(string $headerClass): void
    {
        $this->headerClass = $headerClass;
    }

    /**
     * @return string
     */
    public function getBodyClass(): string
    {
        return $this->bodyClass;
    }

    /**
     * @param string $bodyClass
     */
    public function setBodyClass(string $bodyClass): void
    {
        $this->bodyClass = $bodyClass;
    }
}