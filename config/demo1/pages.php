<?php
return array(
    'documentation' => array(
        // Apply for all documentation pages
        '*' => array(
            // Layout
            'layout' => array(
                // Aside
                'aside' => array(
                    'display'  => true, // Display aside
                    'theme'    => 'light', // Set aside theme(dark|light)
                    'minimize' => false, // Allow aside minimize toggle
                    'menu'     => 'documentation' // Set aside menu type(main|documentation)
                ),

                'header' => array(
                    'left' => 'page-title',
                ),

                'toolbar' => array(
                    'display' => false,
                ),

                'page-title' => array(
                    'layout'            => 'documentation',
                    'description'       => false,
                    'responsive'        => true,
                    'responsive-target' => '#kt_header_nav' // Responsive target selector
                ),
            ),
        ),
    ),
    'user-management' => array(

        // affiliation
        'affiliation' => array(
            'list' => array(
                'title'  => 'Affiliation',
                // 'view'   => 'user-management/affiliation/list',
                'assets' => array(
                    'custom' => array(
                        'css' => array(
                            'plugins/custom/datatables/datatables.bundle.css',
                        ),
                        'js' => array(
                            'js/custom/widgets.js',
                        ),
                        'demo7-child' => array(
                            'plugins/custom/datatables/datatables/datatables.bundle.js',
                        ),
                    ),
                ),
            ),
        ),
        // end affiliation

        'users' => array(
            'list' => array(
                'title'  => 'User List',
                'view'   => 'user-management/users/list',
                'assets' => array(
                    'custom' => array(
                        'css' => array(
                            'plugins/custom/datatables/datatables.bundle.css',
                        ),
                        'js' => array(
                            'js/custom/widgets.js',
                            'plugins/custom/datatables/datatables.bundle.js',
                            
                        ),
                        'js' => array(
                            'js/custom/widgets.js',
                            'plugins/custom/datatables/datatables.bundle.js',
                            
                        ),
                        // 'demo1-child' => array(
                           
                        // ),
                    ),
                ),
            ),
            'permissions' => array(
                'title'  => 'Permissions',
                // 'view'   => 'user-management/permissions/list',
                'assets' => array(
                    'custom' => array(
                        'css' => array(
                            'plugins/custom/datatables/datatables.bundle.css',

                        ),
                        'js' => array(
                            'js/custom/widgets.js',
                            'plugins/custom/datatables/datatables.bundle.js',
                            
                        ),
                        
                        'demo7-child' => array(
                            'plugins/custom/datatables/datatables.bundle.js',
                            // 'apps/user-management/users/list/table.js', 
                        ),
                    ),
                ),
            ),
        ),

        'roles' => array(
            'list' => array(
                'title'  => 'Roles list',
                //'view'   => 'user-management/roles/list',
                'assets' => array(
                    'custom' => array(
                        'js' => array(
                            'js/custom/widgets.js',
                            'plugins/custom/datatables/datatables.bundle.js',
                            
                        ),
                        'demo7-child' => array(
                            'user-management/roles/list/update-role.js',

                        ),
                    ),
                ),
            ),
            'view' => array(
                'title'  => 'Roles view',
                // 'view'   => 'user-management/roles/view/1',
                'assets' => array(
                    'custom' => array(
                        'js' => array(
                            'js/custom/widgets.js',
                            'plugins/custom/datatables/datatables.bundle.js',
                        ),
                        'demo7-child' => array(
                            'user-management/roles/view/update-role.js',
                            'user-management/roles/view/view.js',
                            'user-management/users/list/table.js',
                            'user-management/users/list/export-users.js',

                        ),
                    ),
                ),
            ),

        ),

    ),
);
