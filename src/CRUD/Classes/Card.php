<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

use Rodrigorioo\BackStrapLaravel\CRUD\Traits\Fields;

class Card {

    use Fields;

    private string $name = '';
    private string $classes = '';
    private $fields = [];

    public function __construct ($name, $classes = '') {

        $this->setName($name);
        $this->setClasses($classes);
    }

    public function render () {

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
}