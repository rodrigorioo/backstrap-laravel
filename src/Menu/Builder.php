<?php

namespace Rodrigorioo\BackStrapLaravel\Menu;

class Builder {

    public static function getMenu () {

        $menu = '';

        $menuList = config('backstrap_laravel.menu');

        foreach($menuList as $menuItem) {

            if(is_array($menuItem)) {

                // Is a menu option
                $menu .= self::getMenuOption($menuItem);

            } else {

                // Is title
                $menu .= '<li class="nav-title">'.$menuItem.'</li>';
            }
        }

        return $menu;
    }

    public static function getMenuOption($menuItem) {

        $subMenu = (isset($menuItem['submenu'])) ? $menuItem['submenu'] : false;
        $icon = (isset($menuItem['icon'])) ? $menuItem['icon'] : false;

        return '
                    <li class="nav-item '.(($subMenu) ? "nav-dropdown" : "").'">
                        <a class="nav-link '.(($subMenu) ? "nav-dropdown-toggle" : "").'" href="'.((isset($menuItem['url'])) ? url($menuItem['url']) : "#").'">
                            <i class="nav-icon '.(($icon) ? $icon : "").'"></i> 
                            '.$menuItem['text'].'
                        </a>
                        '.(($subMenu) ? self::getSubmenu($subMenu) : "").'
                    </li>
        ';
    }

    public static function getSubmenu($subMenuItems) {

        $subMenu = '';

        $subMenu = '<ul class="nav-dropdown-items">';

        foreach($subMenuItems as $subMenuItem) {
            $subMenu .= self::getMenuOption($subMenuItem);
        }

        $subMenu .= '</ul>';

        return $subMenu;
    }
}