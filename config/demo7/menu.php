<?php

return array(
    'aside_tabs' => array(
        array(
            'link'    => 'kt_aside_nav_tab_projects',
            'icon'    => 'icons/duotune/general/gen025.svg',
            'tooltip' => 'Projects',
            'view'    => 'layout/aside/__tab-contents/__projects',
        ),

        array(
            'link'    => 'kt_aside_nav_tab_menu',
            'icon'    => 'icons/duotune/finance/fin006.svg',
            'tooltip' => 'Menu',
            'view'    => 'layout/aside/__tab-contents/__menu',
        ),

        array(
            'link'    => 'kt_aside_nav_tab_subscription',
            'icon'    => 'icons/duotune/general/gen032.svg',
            'tooltip' => 'Subscription',
            'view'    => 'layout/aside/__tab-contents/__subscription',
        ),

        array(
            'link'    => 'kt_aside_nav_tab_tasks',
            'icon'    => 'icons/duotune/general/gen048.svg',
            'tooltip' => 'Tasks',
            'view'    => 'layout/aside/__tab-contents/__tasks',
        ),

        array(
            'link'    => 'kt_aside_nav_tab_notifications',
            'icon'    => 'icons/duotune/abstract/abs027.svg',
            'tooltip' => 'Notifications',
            'view'    => 'layout/aside/__tab-contents/__notifications',
        ),

        array(
            'link'    => 'kt_aside_nav_tab_authors',
            'icon'    => 'icons/duotune/files/fil005.svg',
            'tooltip' => 'Authors',
            'view'    => 'layout/aside/__tab-contents/__authors',
        ),
    ),


    // **************
    array(
        'title'      => 'User Management',
        'icon'       => array(
            'svg'  => theme()->getSvgIcon("demo1/media/icons/duotune/general/gen025.svg", "svg-icon-2"),
            'font' => '<i class="bi bi-layers fs-3"></i>',
        ),
        'classes'    => array('item' => 'menu-accordion'),
        'attributes' => array(
            "data-kt-menu-trigger" => "click",
        ),
        'sub'        => array(
            'class' => 'menu-sub-accordion menu-active-bg',
            'items' => array(
                array(
                    'title'      => 'User',
                    'path'       => '/user-management/users/list',
                    'bullet'     => '<span class="bullet bullet-dot"></span>',
                    'attributes' => array(
                        'link' => array(
                            "title"             => "Coming soon",
                            "data-bs-toggle"    => "tooltip",
                            "data-bs-trigger"   => "hover",
                            "data-bs-dismiss"   => "click",
                            "data-bs-placement" => "right",
                        ),
                    ),
                ),
                array(
                    'title'  => 'Roles',
                    'path'   => '/user-management/roles/list',
                    'bullet' => '<span class="bullet bullet-dot"></span>',
                ),
                array(
                    'title'  => 'Permission',
                    'path'   => '/user-management/users/permissions',
                    'bullet' => '<span class="bullet bullet-dot"></span>',
                ),
            ),
        ),
    ),

    





);
