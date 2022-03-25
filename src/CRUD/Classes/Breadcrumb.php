<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

class Breadcrumb {

    private array $breadcrumbs;

    public function __construct () {

        // TODO

    }

    /**
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        return $this->breadcrumbs;
    }
}