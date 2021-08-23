<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin customization
    |--------------------------------------------------------------------------
    |
    |
    */

    'title' => 'BackStrap Admin',

    'logo' => 'BackStrap Admin',
    'logo_img' => '',

    /*
    |--------------------------------------------------------------------------
    | Register & Forgot Password
    |--------------------------------------------------------------------------
    |
    |
    */

    'register' => false,
    'forgot_password' => false,

    /*
    |--------------------------------------------------------------------------
    | Prefix & Routes
    |--------------------------------------------------------------------------
    |
    |
    */

    'prefix' => 'admin',

    'login_url' => 'login',
    'logout_url' => 'logout',
    'register_url' => null, // Default: register - TODO: Register
    'forgot_password_url' => null, // Default: forgot-password
    'password_reset_url' => null,  // Default: change-password

    'custom_home' => false,

    /*
    |--------------------------------------------------------------------------
    | Alerts & Notifications
    |--------------------------------------------------------------------------
    |
    |
    */

    'alert_success' => [
        'title' => 'Éxito',
        'text' => 'Cambios guardados con éxito',
        'icon' => 'success',
        'confirm_button_text' => 'Cerrar',
    ],
    'alert_error' => [
        'title' => 'Error',
        'text' => 'Ocurrió un error. Volvé a intentarlo',
        'icon' => 'error',
        'confirm_button_text' => 'Cerrar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Guard
    |--------------------------------------------------------------------------
    |
    |
    */

    'guard' => [
        'name' => 'backstrap_laravel',
        'driver' => 'session',
        'provider' => [
            'name' => 'backstrap_laravel_administrators',
            'driver' => 'eloquent',
        ],
        'passwords' => [
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'admin_model' => Rodrigorioo\BackStrapLaravel\Models\Administrator::class,

    /*
    |--------------------------------------------------------------------------
    | Menu
    |--------------------------------------------------------------------------
    |
    |
    */

    'menu' => [
        [
            'text' => 'Home',
            'url'  => 'admin',
            'icon' => 'la la-lg la-home',
            // 'can' => ['ver home'],
        ],
        'My account',
        [
            'text' => 'Perfil',
            'url'  => 'admin/profile',
            'icon' => 'la la-lg la-user',
        ],
        'General',
        [
            'text' => 'Administradores',
            'icon' => 'la la-lg la-users',
            'url' => 'admin/administrators',
        ],
        [
            'text' => 'Test Submenu',
            'icon' => 'la la-lg la-sitemap',
            'submenu' => [
                [
                    'shift' => 'ml-3',
                    'text' => 'Sub1',
                    'url'  => 'admin/submenu1',
                ],
                [
                    'shift' => 'ml-3',
                    'text' => 'Sub2',
                    'url'  => 'admin/submenu2',
                ],
                [
                    'shift' => 'ml-3',
                    'text' => 'Sub3',
                    'url'  => 'admin/submenu3',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Footer
    |--------------------------------------------------------------------------
    |
    |
    */

    'footer' => [
        'credits' => '&copy; 2019 Cristian Tabacitu.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    |
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@9',
                ],
            ],
        ],
    ],

];