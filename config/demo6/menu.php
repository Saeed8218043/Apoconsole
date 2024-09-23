<?php

use App\Core\Adapters\Theme;


return array(
    'demo6-aside' => array(
        // Dashboard
        ''     => array(
            "title"      => "Home",
            "icon"       => '<i class="bi bi-house fs-2"></i>',
            "attributes" => array(
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "path"       => "",
        ),


        //  'inventory'    => array(
        //     "title"      => "Inventory",
        //     "icon"       => '<i class="bi bi-layers fs-2"></i>',
        //     "classes"    => array(
        //         "item" => "py-2",
        //         "link" => "menu-center",
        //         "icon" => "me-0",
        //     ),
        //     "attributes" => array(
        //         "item" => array(
        //             "data-kt-menu-trigger"   => "click",
        //             "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
        //         ),
        //         'link' => array(
        //             "data-bs-trigger"   => "hover",
        //             "data-bs-dismiss"   => "click",
        //             "data-bs-placement" => "right",
        //         ),
        //     ),
        //     "arrow"      => false,
        //     "sub"        => array(
        //         "class" => "menu-sub-dropdown w-225px px-1 py-4",
        //         "items" => array(
        //             array(
        //                 'content' => '<span class="menu-section fs-5 fw-bolder">Inventory</span>',
        //             ),


        //             array(
        //                 'title'  => 'Trusted Parts',
        //                 'path'   => '/inventoryprice',
        //                 'bullet' => '<span class="bullet bullet-dot"></span>',
        //                 'permission' => 'inventoryprice.index',
        //             ),
        //             array(
        //                 'title'  => 'Auto Outlet',
        //                 'path'   => '/autooutlet',
        //                 'bullet' => '<span class="bullet bullet-dot"></span>',
        //                 'permission' => 'autooutlet',
        //             ),
        //             array(
        //                 'title'  => 'Globalbuy',
        //                 'path'   => '/globalby',
        //                 'bullet' => '<span class="bullet bullet-dot"></span>',
        //                 'permission' => 'globalby',
        //             ),
        //               array(
        //                 'title'  => 'Virtual Voyage',
        //                 'path'   => '/virtual_voyage',
        //                 'bullet' => '<span class="bullet bullet-dot"></span>',
        //                 'permission' => 'virtual_voyage',
        //             ),
        //               array(
        //                 'title'  => 'Hybrid',
        //                 'path'   => '/Hybrid',
        //                 'bullet' => '<span class="bullet bullet-dot"></span>',
        //                 'permission' => 'Hybrid',
        //             ),







        //         ),
        //     ),
        // ),

         'shopify'    => array(
            "title"      => "Shopify",
            "icon"       => '<i class="bi bi-cart-dash fs-2"></i>',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'content' => '<span class="menu-section fs-5 fw-bolder">Inventory</span>',
                    ),


                    array(
                        'title'  => 'Trusted Parts',
                        'path'   => '/inventoryprice',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'inventoryprice.index',
                    ),


                    array(
                        'content' => '<span class="menu-section fs-5 fw-bolder">Orders</span>',
                    ),
                    array(
                        'title'  => 'Shopify',
                        'path'   => '/shopify_order',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'shopify_order.index',
                    ),

                    array(
                        'title'  => 'Shopify Orders ',
                        'path'   => '/order_pf',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'order_pf.index',
                    ),




                ),
            ),
        ),

         'amazon'    => array(
            "title"      => "Amazon",
            "icon"       => '<i class="bi bi-amazon"></i>',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'content' => '<span class="menu-section fs-5 fw-bolder">Inventory</span>',
                    ),

                    array(
                        'title'  => 'Trusted Parts',
                        'path'   => '/inventoryprice',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'inventoryprice.index',
                    ),
                    array(
                        'title'  => 'Perfect fit',
                        'path'   => '/pf',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'autooutlet',
                    ),

                    array(
                        'content' => '<span class="menu-section fs-5 fw-bolder">Orders</span>',
                    ),

                    array(
                        'content' => '<span class="menu-section menu-item fs-6 fw-bolder" style="margin-left: 17px;">Trusted Parts</span>',
                    ),
                    array(
                        'title'  => 'UNIVERSAL',
                        'path'   => '/store/UNIVERSAL',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'store.UNIVERSAL',
                    ),
                    array(
                        'title'  => 'E-TRADE',
                        'path'   => '/store/E-TRADE',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'store.E-TRADE',
                    ),
                    array(
                        'title'  => 'EXPRESS MERCH',
                        'path'   => '/store/EXPRESS',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'store.Express',
                    ),
                    array(
                        'title'  => 'FLEX MERCH',
                        'path'   => '/store/Flex',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'store.Flex',
                    ),
                    array(
                        'title'  => 'HYBRID',
                        'path'   => '/store/HYBRID',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'store.HYBRID',
                    ),
                    array(
                        'title'  => 'EVOLUTION TRADER',
                        'path'   => '/store/EVOLUTION',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'store.EVOLUTION',
                    ),
                    array(
                        'title'  => 'HEALTH WISE',
                        'path'   => '/store/healthwise',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'store.healthwise',
                    ),

                    array(
                        'content' => '<span class="menu-section menu-item fs-6 fw-bolder" style="margin-left: 17px;">Perfect fit</span>',
                    ),

                ),
            ),
        ),

         'ebay'    => array(
            "title"      => "Ebay",
            "icon"       => '<i class="bi bi-bag-dash"></i>',
            // 'permission' => 'autooutlet',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'content' => '<span class="menu-section fs-5 fw-bolder">Inventory</span>',
                    ),

                    array(
                        'title'  => 'Hybrid inventory',
                        'path'   => '/hybrid-inventory',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'hybrid-inventory',
                    ),
                    array(
                        'title'  => 'Apex inventory',
                        'path'   => '/apex-inventory',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'apex-inventory',
                    ),
                    array(
                        'content' => '<span class="menu-section menu-item fs-6 fw-bolder" style="margin-left: 17px;">Trusted Parts</span>',
                    ),
                    array(
                        'content' => '<span class="menu-section menu-item fs-6 fw-bolder" style="margin-left: 17px;">Unity</span>',
                    ),
                    array(
                        'title'  => 'Unity parts',
                        'path'   => '/unityparts',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'unityparts.index',
                    ),

                    array(
                        'content' => '<span class="menu-section menu-item fs-6 fw-bolder" style="margin-left: 17px;">Perfect Fit</span>',
                    ),
                    array(
                        'title'  => 'Globalbuy',
                        'path'   => '/globalby',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'globalby',
                    ),
                      array(
                        'title'  => 'Virtual Voyage',
                        'path'   => '/virtual_voyage',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'virtual_voyage',
                    ),
                      array(
                        'title'  => 'Hybrid',
                        'path'   => '/Hybrid',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'Hybrid',
                    ),
                    array(
                        'title'  => 'Auto Outlet',
                        'path'   => '/autooutlet',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'autooutlet',
                    ),



                    array(
                        'content' => '<span class="menu-section fs-5 fw-bolder">Orders</span>',
                    ),
                    array(
                        'content' => '<span class="menu-section menu-item fs-6 fw-bolder" style="margin-left: 17px;">Trusted Parts</span>',
                    ),


                    array(
                        'title'  => 'AUTOSPARTOUTLET',
                        'path'   => '/store/AUTOSPARTOUTLET',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'store.AUTOSPARTOUTLET',
                    ),
                    array(
                        'title'  => 'CARCOMPONENTS',
                        'path'   => '/store/CARCOMPONENTS',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'store.CARCOMPONENTS',
                    ),
                    array(
                        'title'  => 'PARTSMYTH',
                        'path'   => '/store/PARTSMYTH',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'store.PARTSMYTH',
                    ),
                     array(
                        'title'  => 'Next Autopart',
                        'path'   => '/store/NEXTAUTOPART',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'store.Next',
                    ),
                    array(
                        'content' => '<span class="menu-section menu-item fs-6 fw-bolder" style="margin-left: 17px;">Perfect Fit</span>',
                    ),


                ),
            ),
        ),











        'warehouses' => array(
            "title"      => "Warehouses",
            "icon"       => '<i class="bi bi-shop fs-2"></i>',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'classes' => array('content' => ''),
                        'content' => '<span class="menu-section fs-5 fw-bolder">WareHouses List</span>',
                    ),


                    array(
                        'title'  => 'VA Warehouse',
                        'path'   => '/Pfwarehouse',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                          'permission' => 'warehouses.PF_wholesale',
                    ),
                    array(
                        'title'  => 'FL warehouse',
                        'path'   => '/FL',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                          'permission' => 'warehouses.FL',
                    ),
                    array(
                        'title'  => 'Essandent AO',
                        'path'   => '/Essandent_AO',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                          'permission' => 'warehouses.Essandent_AO',
                    ),
                    array(
                        'title'  => 'Essandent EVE',
                        'path'   => '/Essandent_EVE',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                          'permission' => 'warehouses.Essandent_EVE',
                    ),

                    array(
                        'title'  => 'PA Warehouse',
                        'path'   => '/PA_warehouse',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                          'permission' => 'warehouses.PA_warehouse',
                    ),

                    array(
                        'title'  => 'Va Essandent',
                        'path'   => '/VaEssandent',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                          'permission' => 'warehouses.VaEssandent',
                    ),


                     array(
                        'path'   => '/warehouse/order',
                          'permission' => 'warehouse.order',
                    ),
                     array(
                        'path'   => '/warehouse/inventory',
                          'permission' => 'warehouse.inventory',
                    ),


                    array(
                        'classes' => array('content' => ''),
                        'content' => '<hr></hr>',
                    ),






                ),
            ),
        ),
        'Return_warehouses' => array(
            "title"      => "<span class='text-center'>Return Warehouses</span>",
            "icon"       => '<i class="bi bi-shop-window fs-2"></i>',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'classes' => array('content' => ''),
                        'content' => '<span class="menu-section fs-5 fw-bolder">WareHouses List</span>',
                    ),

                    array(
                        'title'  => 'Warehouses List',
                        'path'   => '/warehouses/list',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                          'permission' => 'warehouses.list.index',
                    ),

                    array(
                        'title'  => 'Summary',
                        'path'   => '/warehouses/summary',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                          'permission' => 'warehouses.list.summary',
                    ),

                     array(
                        'path'   => '/warehouse/order',
                        // 'bullet' => '<span class="bullet bullet-dot"></span>',
                          'permission' => 'warehouse.order',
                    ),
                     array(
                        'path'   => '/warehouse/inventory',
                        // 'bullet' => '<span class="bullet bullet-dot"></span>',
                          'permission' => 'warehouse.inventory',
                    ),


                    array(
                        'classes' => array('content' => ''),
                        'content' => '<hr></hr>',
                    ),






                ),
            ),
        ),















        // Resources
        'resources' => array(
            "title"      => "Management",
            "icon"       => '<i class="bi bi-gear fs-2"></i>',
            "classes"    => array(
                "item" => "py-2",
                "link" => "menu-center",
                "icon" => "me-0",
            ),
            "attributes" => array(
                "item" => array(
                    "data-kt-menu-trigger"   => "click",
                    "data-kt-menu-placement" => Theme::isRTL() ? "left-start" : "right-start",
                ),
                'link' => array(
                    "data-bs-trigger"   => "hover",
                    "data-bs-dismiss"   => "click",
                    "data-bs-placement" => "right",
                ),
            ),
            "arrow"      => false,
            "sub"        => array(
                "class" => "menu-sub-dropdown w-225px px-1 py-4",
                "items" => array(
                    array(
                        'classes' => array('content' => ''),
                        'content' => '<span class="menu-section fs-5 fw-bolder">Management</span>',
                    ),


                    array(
                        'title' => 'User',
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
                        'path'       => '/user-management/users/list',
                          'permission' => 'user-management.user.list.index',
                    ),
                    array(
                        'title'  => 'Roles',
                        'path'   => '/user-management/roles/list',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                          'permission' => 'user-management.roles.list.index',
                    ),

                    array(
                        'title'  => 'All Trq(console) orders ',
                        'path'   => '/order',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'order.index',
                    ),
                    array(
                        'title'  => 'Unmatched Inventory',
                        'path'   => '/unmatchedinventoryprice',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'inventoryprice.index',
                    ),



                      array(
                        'title'  => 'PF Price Settings',
                        'path'   => '/pricesetting',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'pricesetting.index',
                    ),

                    array(
                        'title'  => 'Trusted parts mirror',
                        'path'   => '/vendors/trq',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                         'permission' => 'vendor_trq.index',
                    ),
                     array(
                        'title'  => 'Vendor',
                        'path'   => '/vendorlist',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                        'permission' => 'vendorlist.index',
                    ),

                    array(
                        'title'  => 'TRQ API',
                        'path'   => '/trq_settings',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'trq_settings.index',
                    ),


                    array(
                        'title'  => 'Settings',
                        'path'   => '/pf_order_setting',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                       'permission' => 'pf_order_setting.index',
                    ),

                ),
            ),
        ),





















    ),
);
