<?php

namespace Rodrigorioo\BackStrapLaravel\Traits;

trait Breadcrumbs {

    public static function breadcrumbs ($breadcrumbsItems = []) : string {

        $breadcrumbs = (count($breadcrumbsItems) > 0) ? '<ol class="breadcrumb">' : '';

        foreach($breadcrumbsItems as $iBreadCrumbItem => $breadcrumbItem) {

            $active = ($iBreadCrumbItem == count($breadcrumbsItems) - 1) ? "active" : "";

            $breadcrumbs .= '<li class="breadcrumb-item '.$active.'">';

            if(isset($breadcrumbItem['url'])) {
                $breadcrumbs .= '<a href="'.$breadcrumbItem['url'].'">'.$breadcrumbItem['text'].'</a>';
            } else {
                $breadcrumbs .= $breadcrumbItem['text'];
            }

            $breadcrumbs .= '</li>';
        }

        $breadcrumbs .= (count($breadcrumbsItems) > 0) ? '</ol>' : '';

        return $breadcrumbs;
    }

    public static function getHomeBreadcrumb() : array {

        $prefix = config('backstrap_laravel.prefix');

        return [
            'text' => 'Home',
            'url' => url($prefix),
        ];
    }
}