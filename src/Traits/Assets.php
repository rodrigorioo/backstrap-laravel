<?php

namespace Rodrigorioo\BackStrapLaravel\Traits;

trait Assets {

    public static function getCSS () : string {

        $plugins = '';

        $configPlugins = config('backstrap_laravel.plugins');

        foreach($configPlugins as $configPlugin) {

            if($configPlugin['active']) {

                foreach($configPlugin['files'] as $file) {

                    if($file['type'] == 'css') {
                        $plugins .= '<link rel="stylesheet" href="'.$file['location'].'">';
                    }
                }
            }
        }

        return '
            <link rel="stylesheet" href="'.asset('vendor/backstrap_laravel/@coreui/icons/css/coreui-icons.min.css').'">
            <link rel="stylesheet" href="'.asset('vendor/backstrap_laravel/flag-icon-css/css/flag-icon.min.css').'">
            <link rel="stylesheet" href="'.asset('vendor/backstrap_laravel/font-awesome/css/font-awesome.min.css').'">
            <link rel="stylesheet" href="'.asset('vendor/backstrap_laravel/simple-line-icons/css/simple-line-icons.css').'">
            <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

            <link href="'.asset('vendor/backstrap_laravel/css/style.css').'" rel="stylesheet">
            <link href="'.asset('vendor/backstrap_laravel/pace-progress/css/pace.min.css').'" rel="stylesheet">
            
            '.$plugins.'
        ';
    }

    public static function getJS () : string {

        $plugins = '';

        $configPlugins = config('backstrap_laravel.plugins');

        foreach($configPlugins as $configPlugin) {

            if($configPlugin['active']) {

                foreach($configPlugin['files'] as $file) {

                    if($file['type'] == 'js') {
                        $plugins .= '<script src="'.$file['location'].'"></script>';
                    }
                }
            }
        }

        return '
            <script src="'.asset('vendor/backstrap_laravel/jquery/js/jquery.min.js').'"></script>
            <script src="'.asset('vendor/backstrap_laravel/popper.js/js/popper.min.js').'"></script>
            <script src="'.asset('vendor/backstrap_laravel/bootstrap/js/bootstrap.min.js').'"></script>
            <script src="'.asset('vendor/backstrap_laravel/pace-progress/js/pace.min.js').'"></script>
            <script src="'.asset('vendor/backstrap_laravel/perfect-scrollbar/js/perfect-scrollbar.min.js').'"></script>
            <script src="'.asset('vendor/backstrap_laravel/@coreui/coreui/js/coreui.min.js').'"></script>
            
            <script src="'.asset('vendor/backstrap_laravel/chart.js/js/Chart.min.js').'"></script>
            <script src="'.asset('vendor/backstrap_laravel/@coreui/coreui-plugin-chartjs-custom-tooltips/js/custom-tooltips.min.js').'"></script>

            <script src="'.asset('vendor/backstrap_laravel/js/main.js').'"></script>
            
            '.$plugins.'
        ';
    }

}