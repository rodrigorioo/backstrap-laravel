<?php

namespace Rodrigorioo\BackStrapLaravel\Traits;

trait Breadcrumbs {

    private static function generateItem ($breadcrumbItem, $active) : string {

        // Make the breadcrumb
        $breadcrumb = '<li class="breadcrumb-item '.$active.'">';

        if(isset($breadcrumbItem['url'])) {
            $breadcrumb .= '<a href="'.$breadcrumbItem['url'].'">'.$breadcrumbItem['text'].'</a>';
        } else {
            $breadcrumb .= $breadcrumbItem['text'];
        }

        $breadcrumb .= '</li>';

        return $breadcrumb;
    }

    public static function breadcrumbs ($breadcrumbsItems = []) : string {

        $breadcrumbs = (count($breadcrumbsItems) > 0) ? '<ol class="breadcrumb">' : '';

        foreach($breadcrumbsItems as $iBreadCrumbItem => $breadcrumbItem) {

            // If no have items
            if(count($breadcrumbItem) === 0) continue;

            // If is the last, put active
            $active = ($iBreadCrumbItem == count($breadcrumbsItems) - 1) ? "active" : "";

            // If is a single item
            if(isset($breadcrumbItem['text'])) {

                $breadcrumbs .= self::generateItem($breadcrumbItem, $active);

            } else {

                // If each item contains other sub items
                foreach($breadcrumbItem as $breadcrumbSubItem) {
                    $breadcrumbs .= self::generateItem($breadcrumbSubItem, $active);
                }
            }

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