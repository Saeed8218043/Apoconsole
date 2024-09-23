<?php
return array(
    '' => array(
        'title'       => 'Dashboard',
        'description' => '',
        //'view'        => 'index',
        'layout'      => array(
            'page-title' => array(
                'description' => true,
                'breadcrumb'  => false,
            ),
        ),
        'assets'      => array(
            'custom' => array(
                'js' => array(),
            ),
        ),
    ),

    'login'           => array(
        'title'  => 'Login',
        'assets' => array(
            'custom' => array(
                'js' => array(
                    'js/custom/authentication/sign-in/general.js',
                ),
            ),
        ),
        'layout' => array(
            'main' => array(
                'type' => 'blank', // Set blank layout
                'body' => array(
                    'class' => theme()->isDarkMode() ? '' : 'bg-body',
                ),
            ),
        ),
    ),
    'register'        => array(
        'title'  => 'Register',
        'assets' => array(
            'custom' => array(
                'js' => array(
                    'js/custom/authentication/sign-up/general.js',
                ),
            ),
        ),
        'layout' => array(
            'main' => array(
                'type' => 'blank', // Set blank layout
                'body' => array(
                    'class' => theme()->isDarkMode() ? '' : 'bg-body',
                ),
            ),
        ),
    ),
    'forgot-password' => array(
        'title'  => 'Forgot Password',
        'assets' => array(
            'custom' => array(
                'js' => array(
                    'js/custom/authentication/password-reset/password-reset.js',
                ),
            ),
        ),
        'layout' => array(
            'main' => array(
                'type' => 'blank', // Set blank layout
                'body' => array(
                    'class' => theme()->isDarkMode() ? '' : 'bg-body',
                ),
            ),
        ),
    ),

    'log' => array(
        'audit'  => array(
            'title'  => 'Audit Log',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js'  => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
        'system' => array(
            'title'  => 'System Log',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js'  => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
    ),

    'account' => array(
        'overview' => array(
            'title'  => 'Account Overview',
            'view'   => 'account/overview/overview',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/widgets.js',
                    ),
                ),
            ),
        ),

        'settings' => array(
            'title'  => 'Account Settings',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/account/settings/profile-details.js',
                        'js/custom/account/settings/signin-methods.js',
                        'js/custom/modals/two-factor-authentication.js',
                    ),
                ),
            ),
        ),
    ),

    'users'         => array(
        'title' => 'User List',

        '*' => array(
            'title' => 'Show User',

            'edit' => array(
                'title' => 'Edit User',
            ),
        ),
    ),

    // Documentation pages
    'documentation' => array(
        '*' => array(
            'assets' => array(
                'vendors' => array(
                    'css' => array(
                        'plugins/custom/prismjs/prismjs.bundle.css',
                    ),
                    'js'  => array(
                        'plugins/custom/prismjs/prismjs.bundle.js',
                    ),
                ),
                'custom'  => array(
                    'js' => array(
                        'js/custom/documentation/documentation.js',
                    ),
                ),
            ),

            'layout' => array(
                'base'    => 'docs', // Set base layout: default|docs

                // Content
                'content' => array(
                    'width'  => 'fixed', // Set fixed|fluid to change width type
                    'layout' => 'documentation'  // Set content type
                ),
            ),
        ),

        'getting-started' => array(
            'overview' => array(
                'title'       => 'Overview',
                'description' => '',
                'view'        => 'documentation/getting-started/overview',
            ),

            'build' => array(
                'title'       => 'Gulp',
                'description' => '',
                'view'        => 'documentation/getting-started/build/build',
            ),

            'multi-demo' => array(
                'overview' => array(
                    'title'       => 'Overview',
                    'description' => '',
                    'view'        => 'documentation/getting-started/multi-demo/overview',
                ),
                'build'    => array(
                    'title'       => 'Multi-demo Build',
                    'description' => '',
                    'view'        => 'documentation/getting-started/multi-demo/build',
                ),
            ),

            'file-structure' => array(
                'title'       => 'File Structure',
                'description' => '',
                'view'        => 'documentation/getting-started/file-structure',
            ),

            'customization' => array(
                'sass'       => array(
                    'title'       => 'SASS',
                    'description' => '',
                    'view'        => 'documentation/getting-started/customization/sass',
                ),
                'javascript' => array(
                    'title'       => 'Javascript',
                    'description' => '',
                    'view'        => 'documentation/getting-started/customization/javascript',
                ),
            ),

            'dark-mode' => array(
                'title' => 'Dark Mode Version',
                'view'  => 'documentation/getting-started/dark-mode',
            ),

            'rtl' => array(
                'title' => 'RTL Version',
                'view'  => 'documentation/getting-started/rtl',
            ),

            'troubleshoot' => array(
                'title' => 'Troubleshoot',
                'view'  => 'documentation/getting-started/troubleshoot',
            ),

            'changelog' => array(
                'title'       => 'Changelog',
                'description' => 'version and update info',
                'view'        => 'documentation/getting-started/changelog/changelog',
            ),

            'updates' => array(
                'title'       => 'Updates',
                'description' => 'components preview and usage',
                'view'        => 'documentation/getting-started/updates',
            ),

            'references' => array(
                'title'       => 'References',
                'description' => '',
                'view'        => 'documentation/getting-started/references',
            ),
        ),

        'general' => array(
            'datatables'   => array(
                'overview' => array(
                    'title'       => 'Overview',
                    'description' => 'plugin overview',
                    'view'        => 'documentation/general/datatables/overview/overview',
                ),
            ),
            'remove-demos' => array(
                'title'       => 'Remove Demos',
                'description' => 'How to remove unused demos',
                'view'        => 'documentation/general/remove-demos/index',
            ),
        ),

        'configuration' => array(
            'general'     => array(
                'title'       => 'General Configuration',
                'description' => '',
                'view'        => 'documentation/configuration/general',
            ),
            'menu'        => array(
                'title'       => 'Menu Configuration',
                'description' => '',
                'view'        => 'documentation/configuration/menu',
            ),
            'page'        => array(
                'title'       => 'Page Configuration',
                'description' => '',
                'view'        => 'documentation/configuration/page',
            ),
            'npm-plugins' => array(
                'title'       => 'Add NPM Plugin',
                'description' => 'Add new NPM plugins and integrate within webpack mix',
                'view'        => 'documentation/configuration/npm-plugins',
            ),
        ),
    ),

    // ************************
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
        //inventory price
    'inventoryprice' => array(
        'title'  => 'Trusted Parts',
        // 'view'   => 'user-management/users/list',
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

    'hybrid-inventory' => array(
        'title'  => 'Hybrid Inventory',
        // 'view'   => 'user-management/users/list',
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

    'apex-inventory' => array(
        'title'  => 'Apex Inventory',
        // 'view'   => 'user-management/users/list',
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


    'pf' => array(
        'title'  => 'Perfect Fit',
        // 'view'   => 'user-management/users/list',
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

    'autooutlet' => array(
        'title'  => 'Auto Outlet',
        // 'view'   => 'user-management/users/list',
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

    'globalby' => array(
        'title'  => 'Globalbuy',
        // 'view'   => 'user-management/users/list',
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
    'virtual_voyage' => array(
        'title'  => 'Virtual Voyage',
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
            ),
        ),
    ),

    'Hybrid' => array(
        'title'  => 'Hybrid',
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
            ),
        ),
    ),

    'VaEssandent' => array(
        'title'  => 'Va Essandent',
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
            ),
        ),
    ),

    'va-approval' => array(
        'title'  => 'Va Approval',
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
            ),
        ),
    ),

    'Pfwarehouse' => array(
        'title'  => 'VA warehouse',
    ),
    'va-orders' => array(
        'title'  => 'VA Essandent Orders',
    ),

    'VaEssandent' => array(
        'title'  => 'VA Essandent',
    ),

    'Essandent_AO' => array(
        'title'  => 'Essandent_AO',
    ),

    'Essandent_EVE' => array(
        'title'  => 'Essandent_EVE',
    ),
    'FL' => array(
        'title'  => 'FL warehouse',
    ),

    'PA_warehouse' => array(
        'title'  => 'PA Warehouse',
    ),

    'pf_order_setting' => array(
        'title'  => 'Perfect Fit Order Settings',
        // 'view'   => 'user-management/users/list',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),


                // 'demo1-child' => array(

                // ),
            ),
        ),
    ),


    'trq_settings' => array(
        'title'  => 'Trusted Parts Settings',
        // 'view'   => 'user-management/users/list',
        'assets' => array(
            'custom' => array(
                'css' => array(
                    'plugins/custom/datatables/datatables.bundle.css',
                ),


                // 'demo1-child' => array(

                // ),
            ),
        ),
    ),


    'order_pf' => array(
        'title'  => 'Perfect Fit Orders',
        // 'view'   => 'user-management/users/list',
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

       //inventory price
    'vendorlist' => array(
        'title'  => 'Vendor',
        // 'view'   => 'user-management/users/list',
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

    'unmatchedinventoryprice' => array(
        'title'  => 'Unmatched Inventory',
        // 'view'   => 'user-management/users/list',
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

    'pricesetting' => array(
        'title'  => 'Price Setting',
        // 'view'   => 'user-management/users/list',
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

          //inventory price
          'order' => array(
            'title'  => 'Order',
            // 'view'   => 'user-management/users/list',
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


         'order_rrc' => array(
            'title'  => 'Order RMA Refund Cancel',
            // 'view'   => 'user-management/users/list',
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


        // vendor
        'vendors' => array(
        'trq' => array(
            'title'  => 'Order',
            // 'view'   => 'user-management/users/list',
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
        ),

        //Fitment
        'fitment' => array(
            'title'  => 'Fitment',
            // 'view'   => 'user-management/users/list',
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

        //Fitment
        'warehouses' => array(
           'list' => array(
            'title'  => 'Warehouses List',
            // 'view'   => 'user-management/users/list',
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
        ),



        //tracking
          'tracking' => array(
            'title'  => 'Tracking',
            // 'view'   => 'user-management/users/list',
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
);
