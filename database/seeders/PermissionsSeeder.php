<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $data = $this->data();

       
        // print_test($data);
        foreach ($data as $value) {

            $permission = Permission::create([
                'name' => $value['name'],
                'friendly_name' => $value['friendly_name'],
                'module_name' => $value['module_name'],
            ]);


            if (isset($value['for'])) {
                foreach ($value['for'] as $key => $val) {
                    if (is_array($val)) {
                        if (in_array($value['function_name'], $val)) {

                            $dd = Role::select('id')->where('name',  $key)->first();
                            if (isset($dd->id)) {
                                $role = Role::find($dd->id);

                                $role->save();

                                $role->givePermissionTo($permission);
                            }
                        }
                    } else {
                        $dd = Role::select('id')->where('name',  $val)->first();
                        if (isset($dd->id)) {
                            $role = Role::find($dd->id);

                            $role->save();

                            $role->givePermissionTo($permission);
                        }
                    }
                }
            }
        }
        // Permission::create([
        //     'name' => 'user-management.user.userdata',
        //     'friendly_name' => 'User List api',
        // ]);
        // Permission::create([
        //     'name' => 'user-management.user.userdata',
        //     'friendly_name' => 'User List api',
        // ]);
        // ------create permission for Domains Verification



        //-----------------------

        //--------------------manual define permissions
        // Permission::create([
        //         'name' => 'system.index',
        //         'friendly_name' => 'System module',
        //     ]);
        // Permission::create([
        //         'name' => 'account.index',
        //         'friendly_name' => 'Account module',
        //     ]);
        //----------------------------------------------


    }

    public function data()
    {
        $data = [];
        //Admin, Affiliated (Seller/Buyer), Non-Affiliated (Seller/Buyer), Back office
        // list of model permission
        $model = array(
            [
                'name' => 'user-management.roles.list',
                'friendly_name' => 'User Role Management',
                'for' => array('Admin')
            ],
            [
                'name' => 'user-management.permissions',
                'friendly_name' => 'UserPermission Management',
                'for' => array('Admin')
            ],
            [
                'name' => 'user-management.user.list',
                'friendly_name' => 'User List Management',
                'for' => array('Admin')
            ],

            // [
            //     'name' => 'log.audit',
            //     'friendly_name' => 'Audit Log',
            //     'for' => array('Admin')
            // ],

            // [
            //     'name' => 'log.system',
            //     'friendly_name' => 'System Log',
            //     'for' => array('Admin')
            // ],

            // [
            //     'name' => 'account.settings',
            //     'friendly_name' => 'settings',
            //     'for' => array(
            //         'Admin',
            //         'Affiliated (Seller/Buyer)',
            //         'Non-Affiliated (Seller/Buyer)',
            //         'Back office'
            //     )
            // ],

            // [
            //     'name' => 'support-center.overview',
            //     'friendly_name' => 'Overview',
            //     'for' => array(
            //         'Admin',
            //         'Affiliated (Seller/Buyer)',
            //         'Non-Affiliated (Seller/Buyer)',
            //         'Back office'
            //     )

            // ],

            // [
            //     'name' => 'support-center.tickets.list',
            //     'friendly_name' => 'Tickets List',
            //     'for' => array(
            //         'Admin',
            //         'Affiliated (Seller/Buyer)',
            //         'Non-Affiliated (Seller/Buyer)',
            //         'Back office'
            //     )
            // ],

            // // ['name'=>'support-center.tickets.view' ,'friendly_name'=> 'Tickets View'],

            // [
            //     'name' => 'support-center.tutorial.list',
            //     'friendly_name' => 'Turorial List',
            //     'for' => array(
            //         'Admin',
            //         'Affiliated (Seller/Buyer)',
            //         'Non-Affiliated (Seller/Buyer)',
            //         'Back office'
            //     )
            // ],

            // // ['name'=>'support-center.tutorial.post' , 'friendly_name'=> 'Tutorial Post'],

            // [
            //     'name' => 'support-center.faq',
            //     'friendly_name' => 'FAQs',
            //     'for' => array(
            //         'Admin',
            //         'Affiliated (Seller/Buyer)',
            //         'Non-Affiliated (Seller/Buyer)',
            //         'Back office'
            //     )
            // ],

            // [
            //     'name' => 'support-center.contact-us',
            //     'friendly_name' => 'Contact Us',
            //     'for' => array(
            //         'Admin',
            //         'Affiliated (Seller/Buyer)',
            //         'Non-Affiliated (Seller/Buyer)',
            //         'Back office'
            //     )
            // ],

            // [
            //     'name' => 'support-center.tickets.solution',
            //     'friendly_name' => 'Tickets Solution',
            //     'for' => array(
            //         'Admin',
            //         'Affiliated (Seller/Buyer)',
            //         'Non-Affiliated (Seller/Buyer)',
            //         'Back office'
            //     )
            // ],

            // [
            //     'name' => 'add-domain',
            //     'friendly_name' => 'Links and Domains Management',
            //     'for' => array(
            //         'Affiliated (Seller/Buyer)',
            //         'Non-Affiliated (Seller/Buyer)',
            //     )
            // ],

            // [
            //     'name' => 'buy-domain',
            //     'friendly_name' => 'Buy Domain',
            //     'for' => array(
            //         'Affiliated (Seller/Buyer)',
            //         'Non-Affiliated (Seller/Buyer)',
            //     )
            // ],
            // [
            //     'name' => 'link-orders',
            //     'friendly_name' => 'Link Orders',
            //     'for' => array(
            //         'Affiliated (Seller/Buyer)',
            //         'Non-Affiliated (Seller/Buyer)',
            //     )
            // ],
            // [
            //     'name' => 'search',
            //     'friendly_name' => 'Ticket Search',
            //     'for' => array(
            //         'Admin',
            //         'Affiliated (Seller/Buyer)',
            //         'Non-Affiliated (Seller/Buyer)',
            //         'Back office'
            //     )
            // ],
            // [

            //     'name' => 'coupons',
            //     'friendly_name' => 'Discount and Coupons',
            //     'for' => array(
            //         'Admin',
            //         'Back office'
            //     )
            // ],
            // [
            //     'name' => 'emails',
            //     'friendly_name' => 'Bulk Emails',
            //     'for' => array(
            //         'Admin',
            //         'Back office'
            //     )
            // ],
            // [

            //     'name' => 'user-management.affiliation.list',
            //     'friendly_name' => 'Affliation',
            //     'for' => array(
            //         'Admin',
            //         'Back office'
            //     )
            // ],


            // [

            //     'name' => 'e-wallet',
            //     'friendly_name' => 'E Wallet',
            //     'for' => array(
            //         'Admin',
            //         'Affiliated (Seller/Buyer)',
            //         'Non-Affiliated (Seller/Buyer)',
            //         'Back office'
            //     )
            // ],
            


            // [

            //     'name' => 'comission_report',
            //     'friendly_name' => 'Comission Report',
            //     'for' => array(
            //         'Admin',
            //         'Back office'
            //     )
            // ],

            


            // [

            //     'name' => 'used_coupons',
            //     'friendly_name' => 'Coupons Report',
            //     'for' => array(
            //         'Admin',
            //         'Back office'
            //     )
            // ],


            


            // [

            //     'name' => 'emails_log',
            //     'friendly_name' => 'Email Logs',
            //     'for' => array(
            //         'Admin',
            //         'Back office'
            //     )
            // ],


            //  [

            //     'name' => 'niches',
            //     'friendly_name' => 'Links Niches',
            //     'for' => array(
            //         'Admin',
            //         'Back office'
            //     )
            // ],




            //  [

            //     'name' => 'verify-domain',
            //     'friendly_name' => 'Verify Domain',
            //     'for' => array(
            //         'Admin',
            //         'Back office'
            //     )
            // ],


            





        );

        foreach ($model as $value) {
            foreach ($this->crudActions($value) as $action) {
                $data[] = $action;
            }
        }

        return $data;
    }

    public function crudActions($name)
    {
        // 
        $actions = [];
        // list of permission actions

        $crud = [
            'store' => 'Save',
            'index' => 'List',
            'update' => 'Update',
            'destroy' => 'Delete',
            'show' => 'Show',
            'edit' => 'Edit',
            'create' => 'Create',
            'datatableapi' => 'UserData',
            'bulkdelete' => 'BulkDelete'
        ];

        foreach ($crud as $key => $value) {

            $arr = [
                'name' => $name['name'] . '.' . $key,

                'function_name' => $key,

                'friendly_name' => ucfirst($value),

                'module_name' =>  $name['friendly_name'],



            ];
            if (isset($name['for'])) {
                $arr['for'] = $name['for'];
            }
            $actions[] = $arr;
        }

        return $actions;
    }
}
