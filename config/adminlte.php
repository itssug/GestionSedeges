<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'sedeges',
    'title_prefix' => 'sedeges | ',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Admin</b>sedeges',
    'logo_img' => 'vendor/adminlte/dist/img/SEDEGESLOGOBLACK.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Sedeges',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/SEDEGESLOGOBLACK.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-teal', //color cambiar
    'usermenu_image' => true, //foto del usuario
    'usermenu_desc' => true, // rol del usuario metodos
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null, //sidebar arriba
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => 'bg-white',
    'classes_brand_text' => 'text-teal font-weight-bold',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-teal elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => true,
        ],
        // [
        //     'type' => 'fullscreen-widget',
        //     'topnav_right' => true,
        // ],

        //Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        // [
        //     'text' => 'blog',
        //     'url' => 'admin/blog',
        //     'can' => 'manage-blog',  // Aquí se muestra solo si el usuario tiene permiso para manejar el blog
        // ],
        // [
        //     'text' => 'pages',
        //     'url' => 'admin/pages',
        //     'icon' => 'far fa-fw fa-file',
        //     'label' => 4,
        //     'label_color' => 'success',
        // ],
        ['header' => 'Administración'],

        // Gestión de Usuarios (visible solo para Administradores)
        [
            'text' => 'Gestión de Usuarios',
            'url' => '#',
            'icon' => 'fas fa-fw fa-user',
            'can' => 'is-admin',  // Solo visible si el usuario es Administrador
            'submenu' => [

                [
                    'text' => 'Usuarios',
                    'icon' => 'bi bi-person-fill',
                    'url' => 'usuarios',
                    'can' => 'is-admin',  // Solo visible para Administradores
                ],
                // [
                //     'text' => 'Personal sedeges',
                //     'icon' => 'bi bi-person-check',
                //     'url' => 'personal',
                //     'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
                // ],

                // Adoptantes (visible solo para Adoptantes)
                [
                    'text' => 'Adoptantes',
                    'url' => 'adoptantes',
                    'icon' => 'fas fa-fw fa-user',
                    'can' => 'is-adoptante',  // Solo visible para Adoptantes
                ],

                [
                    'text' => 'Responsables legales',
                    'url' => 'resp_legales',
                    'icon' => 'bi bi-person-badge',
                    'can' => 'is-admin',
                ],
                [
                    'text' => 'Roles',
                    'url' => 'roles',
                    'icon' => 'bi bi-dot',
                    'can' => 'is-admin',  // Solo visible para Administradores
                ],
            ],


        ],
         [
            'text' => 'Requerimientos',
            'url' => '#',
            'icon' => 'bi bi-archive-fill',
            'can' => 'is-admin',
            'submenu' => [

                [
                    'text' => 'Requisitos',
                    'icon' => 'bi bi-back ',
                    'url' => 'tramites',
                    'can' => 'is-admin',  // Solo visible para Administradores
                ],
                [
                    'text' => 'Entregables',
                    'icon' => 'bi bi-calendar',
                    'url' => 'tramites_adoptantes',
                    'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
                ],

            ],


        ],





        // sedeges (visible solo para Personal sedeges)
        ['header' => 'Administración SEDEGES'],

        [
            'text' => 'División Niñez y Adolescencia',
            'url' => '#',
            'icon' => 'bi bi-person-bounding-box',
            'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
            'submenu' => [
                [
                    'text' => 'Centros de Acogida',
                    'icon' => 'bi bi-house-heart',
                    'url' => 'centros',
                    'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
                ],
                [
                    'text' => 'Niñez y adolescencia',
                    'icon' => 'bi bi-flower3',
                    'url' => 'nnas',
                    'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
                ],
                [
                    'text' => 'Evaluaciones Psicológicas NNA',
                    'icon' => 'bi bi-emoji-smile',
                    'url' => 'evaluacionesPsi',
                    'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
                ],

                [
                    'text' => 'Evaluaciones Médicas NNA',
                    'icon' => 'bi bi-heart-pulse-fill',
                    'url' => 'evaluacionesMed',
                    'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
                ],

                [
                    'text' => 'Repositorio de Documentos',
                    'icon' => 'bi bi-file-earmark-text',
                    'url' => 'documentosNnas',
                    'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
                ],

            ],

        ],


        [
            'text' => 'Cursos de Preparación',
            'url' => '#',
            'icon' => 'bi bi-file-earmark-fill',
            'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
            'submenu' => [
                [
                    'text' => 'Capacitaciones',
                    'icon' => 'bi bi-journals',
                    'url' => 'capacitaciones',
                    'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
                ],

                [
                    'text' => 'Asistencias',
                    'icon' => 'bi bi-check-circle-fill',
                    'url' => 'asistencias',
                    'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
                ],
            ],
        ],


        // [
        //     'text' => 'sedeges',
        //     'url' => '#',
        //     'icon' => 'bi bi-buildings',
        //     'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
        //     'submenu' => [
        //         [
        //             'text' => 'Roles sedeges',
        //             'icon' => 'bi bi-file-earmark-person-fill',
        //             'url' => 'roles_personal',
        //             'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
        //         ],
        //         // [
        //         //     'text' => 'Personal sedeges',
        //         //     'icon'=> 'bi bi-person-check',
        //         //     'url' => 'personal',
        //         //     'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
        //        [
        //             'text' => 'Capacitaciones',
        //             'url' => 'capacitaciones',
        //             'can' => 'is-personal-sedeges',  // Solo visible para Personal sedeges
        //         ],  // ],



        //     ],
        // ],

        // Responsables Legales (visible solo para Responsables Legales)





        //     [
        //         'text' => 'change_password',
        //         'url' => 'admin/settings',
        //         'icon' => 'fas fa-fw fa-lock',
        //     ],
        //     [
        //         'text' => 'multilevel',
        //         'icon' => 'fas fa-fw fa-share',
        //         'submenu' => [
        //             [
        //                 'text' => 'level_one',
        //                 'url' => '#',
        //             ],
        //             [
        //                 'text' => 'level_one',
        //                 'url' => '#',
        //                 'submenu' => [
        //                     [
        //                         'text' => 'level_two',
        //                         'url' => '#',
        //                     ],
        //                     [
        //                         'text' => 'level_two',
        //                         'url' => '#',
        //                         'submenu' => [
        //                             [
        //                                 'text' => 'level_three',
        //                                 'url' => '#',
        //                             ],
        //                             [
        //                                 'text' => 'level_three',
        //                                 'url' => '#',
        //                             ],
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //             [
        //                 'text' => 'level_one',
        //                 'url' => '#',
        //             ],
        //         ],
        //     ],
        //     ['header' => 'labels'],
        //     [
        //         'text' => 'important',
        //         'icon_color' => 'red',
        //         'url' => '#',
        //     ],
        //     [
        //         'text' => 'warning',
        //         'icon_color' => 'yellow',
        //         'url' => '#',
        //     ],
        //     [
        //         'text' => 'information',
        //         'icon_color' => 'cyan',
        //         'url' => '#',
        //     ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
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
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],

        'CustomCSS' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/adminlte/dist/css/custom.css',
                ],
            ],
        ],


        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'FontAwesome' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
                ],
            ],
        ],

        'BootstrapIcons' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
                ],
            ],
        ],


        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
