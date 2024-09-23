<?php

use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\Documentation\ReferencesController;
use App\Http\Controllers\Logs\AuditLogsController;
use App\Http\Controllers\Logs\SystemLogsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usermanagement\UserController;
use App\Http\Controllers\Usermanagement\RolesTableController;
use App\Http\Controllers\Usermanagement\PermissionTableController;
use App\Http\Controllers\ImportdataController;
use App\Http\Controllers\InventoryPriceController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\UnityPriceController;
use App\Http\Controllers\PriceSettingController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\EbayInventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PfOrderController;
use App\Http\Controllers\FitmentController;
use App\Http\Controllers\FtpController;
use App\Http\Controllers\UpsController;
use App\Http\Controllers\ScrapperController;
use App\Http\Controllers\ApexInventoryController;
use App\Http\Controllers\VaWarehouseController;
use App\Http\Controllers\TrqController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\EbayController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PfController;
use App\Http\Controllers\TrqrmaController;
use App\Http\Controllers\ShippoController;
use App\Http\Controllers\WarehouseListController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ShopifyController;
use App\Http\Controllers\MailBox\MailBoxController;
use App\Http\Controllers\MailBox\MailBoxSettingsController;
use App\Http\Controllers\EbayAuthController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



$menu = theme()->getMenu();
array_walk($menu, function ($val) {
    if (isset($val['path'])) {
        $route = Route::get($val['path'], [PagesController::class, 'index']);

        // Exclude documentation from auth middleware
        if (!Str::contains($val['path'], 'documentation')) {
            $route->middleware('auth');
        }
    }
});

Route::get('/trackShipment', [ShippoController::class, 'trackShipment']);
Route::get('/label_shippo_download', [ShippoController::class, 'label_download']);
Route::get('/update-trackShipment', [ShippoController::class, 'Update_trackShipment']);
Route::get('/getInventory', [EbayAuthController::class, 'getInventory']);
Route::get('/getFulfillment', [EbayAuthController::class, 'getFulfillment']);
Route::get('/grant_code_auth', [EbayController::class, 'grant_code_auth']);
Route::get('/get_item/{item}', [EbayController::class, 'get_item']);
Route::get('/fetchAccessToken', [EbayController::class, 'fetchAccessToken']);
Route::get('/updateInventory', [EbayController::class, 'updateInventory']);


Route::get('/scrape', [ScrapperController::class, 'scrape']);


Route::get('/transfer-latest-file', [FtpController::class, 'transferLatestFile']);
Route::GET('/checkConnection', [FtpController::class,'checkConnection'])->name('checkConnection');

Route::GET('/update_orders', [OrderController::class,'update_orders'])->name('update_orders');
Route::GET('/update_all_orders', [OrderController::class,'all_orders'])->name('update_all_orders');
Route::GET('/shopify_update_orders', [OrderController::class,'shopify_update_orders'])->name('shopify_update_orders');
Route::POST('/updateCsvPercentage', [CsvController::class,'updateCsvPercentage'])->name('updateCsvPercentage');
Route::GET('/updateCsvWithSalePrice', [CsvController::class,'updateCsvWithSalePrice'])->name('updateCsvWithSalePrice');
Route::GET('/exportToCsv', [OrderController::class,'exportToCsv'])->name('exportToCsv');
Route::GET('/exportCsvToday', [OrderController::class,'exportCsvToday'])->name('exportCsvToday');
Route::GET('/exportCsvMonth', [OrderController::class,'exportCsvMonth'])->name('exportCsvMonth');
Route::POST('/exportCsvFiltered', [OrderController::class,'exportCsvFiltered'])->name('exportCsvFiltered');




Route::get('/run_dash', [DasboardController::class , 'run']);
Route::get('/trq_tracking', [TrqController::class , 'trq_tracking']);



Route::get('/', [DasboardController::class , 'index'])->middleware('auth');

Route::get('/home',function(){
    return view('pages.Quantum.index');
})->name('home');


// Documentations pages
Route::prefix('documentation')->group(function () {
    Route::get('getting-started/references', [ReferencesController::class, 'index']);
    Route::get('getting-started/changelog', [PagesController::class, 'index']);
});


Route::get('/formatFile', [PfController::class,'formatFile']);

Route::middleware('auth')->group(function () {
    Route::GET('/get_profit_sheet', [OrderController::class,'get_profit_sheet'])->name('get_profit_sheet');
    Route::POST('/edit_profit_sheet', [OrderController::class,'edit_profit_sheet'])->name('edit_profit_sheet');

    Route::GET('/store/AUTOSPARTOUTLET', [OrderController::class,'getStoreData'])->name('store.AUTOSPARTOUTLET');
    Route::POST('/orderSelectStore', [OrderController::class,'orderSelectStore'])->name('orderSelectStore');
Route::GET('/store/CARCOMPONENTS', [OrderController::class,'getStoreData'])->name('store.CARCOMPONENTS');
Route::GET('/store/PARTSMYTH', [OrderController::class,'getStoreData'])->name('store.PARTSMYTH');
Route::GET('/store/parts_traders', [OrderController::class,'getStoreData'])->name('store.parts_traders');
Route::GET('/store/E-TRADE', [OrderController::class,'getStoreData'])->name('store.E-TRADE');
Route::GET('/store/UNIVERSAL', [OrderController::class,'getStoreData'])->name('store.UNIVERSAL');
Route::GET('/store/HYBRID', [OrderController::class,'getStoreData'])->name('store.HYBRID');
Route::GET('/store/Flex', [OrderController::class,'getStoreData'])->name('store.Flex');
Route::GET('/store/EVOLUTION', [OrderController::class,'getStoreData'])->name('store.EVOLUTION');
Route::GET('/store/healthwise', [OrderController::class,'getStoreData'])->name('store.healthwise');
Route::GET('/store/EXPRESS', [OrderController::class,'getStoreData'])->name('store.Express');
Route::GET('/store/NEXTAUTOPART', [OrderController::class,'getStoreData'])->name('store.Next');
    // Account pages
    Route::prefix('account')->group(function () {
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::put('settings/email', [SettingsController::class, 'changeEmail'])->name('settings.changeEmail');
        Route::put('settings/password', [SettingsController::class, 'changePassword'])->name('settings.changePassword');
    });

    // Logs pages
    Route::prefix('log')->name('log.')->group(function () {
        Route::resource('system', SystemLogsController::class)->only(['index', 'destroy']);
        Route::resource('audit', AuditLogsController::class)->only(['index', 'destroy']);
    });

});

// User Managment Pages
 Route::group(['middleware' => ['auth','permission']], function () {
    Route::prefix('user-management')->name('user-management.')->group(function () {
    Route::resource('/users/permissions', PermissionTableController::class);
    Route::POST('/users/permission-data',  [PermissionTableController::class,'datatableapi'])->name('permissions.datatableapi');
    Route::POST('/users/permission-delete',  [PermissionTableController::class,'bulkdelete'])->name('permissions.bulkdelete');
    Route::name('user')->resource('users/list', UserController::class);
    Route::POST('user-data',  [UserController::class,'datatableapi'])->name('user.list.datatableapi');
    Route::POST('user-delete',  [UserController::class,'bulkdelete'])->name('user.list.bulkdelete');
    Route::name('roles')->resource('/roles/list', RolesTableController::class);



});


Route::resource('/inventoryprice', InventoryPriceController::class);
Route::POST('/inventoryprice/datatableapi',  [InventoryPriceController::class,'datatableapi'])->name('inventoryprice.datatableapi');
Route::POST('/inventoryprice/bulkdelete',  [InventoryPriceController::class,'bulkdelete'])->name('inventoryprice.bulkdelete');

Route::resource('/unityparts', UnityPriceController::class);
Route::POST('/unityinventory/datatableapi',  [UnityPriceController::class,'datatableapi'])->name('unityinventory.datatableapi');

Route::resource('/hybrid-inventory', EbayInventoryController::class);
Route::post('/hybrid-inventory', [EbayInventoryController::class, 'store'])->name('hybrid-inventory.store');
Route::post('/hybrid-inventory/upload-csv', [EbayInventoryController::class,'uploadcsv'])->name('hybrid.upload-csv');
Route::post('/hybrid-inventory/insert-csv', [EbayInventoryController::class,'insertcsv'])->name('hybrid.insert-csv');
Route::POST('/hybrid-inventory/datatableapi',  [EbayInventoryController::class,'datatableapi'])->name('hybrid.datatableapi');
Route::POST('/hybrid-inventory/bulkdelete',  [EbayInventoryController::class,'bulkdelete'])->name('hybrid.bulkdelete');
Route::get('/get_hybrid_inventory', [EbayInventoryController::class,'get_hybrid_inventory'])->name('get_hybrid_inventory');
Route::get('/hybrid_export_inventory',  [EbayInventoryController::class,'kit_export'])->name('hybrid.export_inventory');
Route::get('/hybrid_parts_export',  [EbayInventoryController::class,'parts_export'])->name('hybrid.parts_export');
Route::POST('/hybrid-inventory/vendor_csv',  [PfController::class,'vendor_csv'])->name('hybrid.vendor_csv');

Route::resource('/apex-inventory', ApexInventoryController::class);
Route::post('/apex-inventory', [ApexInventoryController::class, 'store'])->name('apex-inventory.store');
Route::post('/apex-inventory/upload-csv', [ApexInventoryController::class,'uploadcsv'])->name('apex.upload-csv');
Route::post('/apex-inventory/insert-csv', [ApexInventoryController::class,'insertcsv'])->name('apex.insert-csv');
Route::POST('/apex-inventory/datatableapi',  [ApexInventoryController::class,'datatableapi'])->name('apex.datatableapi');
Route::POST('/apex-inventory/bulkdelete',  [ApexInventoryController::class,'bulkdelete'])->name('apex.bulkdelete');
Route::get('/get_apex_inventory', [ApexInventoryController::class,'get_apex_inventory'])->name('get_apex_inventory');
Route::get('/apex_export_inventory',  [ApexInventoryController::class,'kit_export'])->name('apex.export_inventory');
Route::get('/apex_parts_export',  [ApexInventoryController::class,'parts_export'])->name('apex.parts_export');
// Route::POST('/apex-inventory/vendor_csv',  [PfController::class,'vendor_csv'])->name('hybrid.vendor_csv');

Route::resource('/pf', PfController::class);
Route::get('/autooutlet', [PfController::class, 'index'])->name('autooutlet');
Route::post('/autooutlet', [PfController::class, 'store']);

Route::get('/globalby', [PfController::class, 'index'])->name('globalby');
Route::post('/globalby', [PfController::class, 'store']);

Route::get('/Hybrid', [PfController::class, 'index'])->name('Hybrid');
Route::post('/Hybrid', [PfController::class, 'store']);
Route::get('/virtual_voyage', [PfController::class,'index'])->name('virtual_voyage');
Route::post('/virtual_voyage', [PfController::class, 'store']);

Route::get('/pf_api', [PfController::class,'pf_api'])->name('pf_api');
Route::get('/get_pf_inventory', [PfController::class,'get_pf_inventory'])->name('pf.get_pf_inventory');
Route::POST('/pf/datatableapi',  [PfController::class,'datatableapi'])->name('pf.datatableapi');
Route::POST('/pf/bulkdelete',  [PfController::class,'bulkdelete'])->name('pf.bulkdelete');

Route::post('/pf/upload-csv', [PfController::class,'uploadcsv'])->name('pf.upload-csv');
Route::post('/pf/insert-csv', [PfController::class,'insertcsv'])->name('pf.insert-csv');

Route::POST('/pf/vendor_csv',  [PfController::class,'vendor_csv'])->name('pf.vendor_csv');

Route::get('/pf_export_inventory',  [PfController::class,'export_inventory'])->name('pf.export_inventory');


Route::resource('/vendorlist', VendorController::class);
Route::POST('/vendorlist/datatableapi',  [VendorController::class,'datatableapi'])->name('vendorlist.datatableapi');
Route::POST('/vendorlist/bulkdelete',  [VendorController::class,'bulkdelete'])->name('vendorlist.bulkdelete');

Route::get('/unmatchedinventoryprice', function (){
    $users = array();

        return view('pages.unmatchedinventory.main',['users'=>$users]);
});


// Route::get('/order/autospartoutlet', [OrderController::class,'autospartoutlet'])->name('order.autospartoutlet');


Route::resource('/order', OrderController::class);
Route::get('/shopify_order',  [OrderController::class,'shopify_order'])->name('shopify_order.index');
Route::POST('/order/datatableapi',  [OrderController::class,'datatableapi'])->name('order.datatableapi');
Route::POST('/shopify_order/datatableapi',  [OrderController::class,'datatableapi'])->name('shopify_order.datatableapi');
Route::POST('/order/bulkdelete',  [OrderController::class,'bulkdelete'])->name('order.bulkdelete');
Route::POST('/orderupload-csv', [OrderController::class,'uploadcsv'])->name('orderupload-csv');
Route::POST('/orderinsert-csv', [OrderController::class,'insertcsv'])->name('orderinsert-csv');
Route::POST('/csv_punch_order', [OrderController::class,'csv_punch_order'])->name('csv_punch_order');
Route::POST('/orderinsert-single', [OrderController::class,'insertsingleorder'])->name('order.insertsingleorder');
Route::POST('/get_rma', [OrderController::class,'get_rma'])->name('get_rma');
Route::POST('/get_detail', [OrderController::class,'get_detail'])->name('get_detail');
Route::POST('/order_refund', [OrderController::class,'order_refund'])->name('order_refund');
Route::POST('/order_cancel', [OrderController::class,'order_cancel'])->name('order_cancel');




// Email Box System Inside Console
Route::get('/mailbox', [MailBoxController::class,'index'])->name('mailbox.index');
Route::get('/mailboxdata', [MailBoxController::class,'mailboxdata'])->name('mailbox.data');
Route::resource('/mailbox_setting', MailBoxSettingsController::class);





Route::resource('/fitment', FitmentController::class);
Route::POST('/fitment/datatableapi',  [FitmentController::class,'datatableapi'])->name('fitment.datatableapi');
Route::POST('/fitment/bulkdelete',  [FitmentController::class,'bulkdelete'])->name('fitment.bulkdelete');




Route::resource('/order_rrc', TrqrmaController::class);
Route::POST('/order_rrc/datatableapi',  [TrqrmaController::class,'datatableapi'])->name('order_rrc.datatableapi');




Route::GET('/import',  [ImportdataController::class,'importdata']);
// Route::resource('import', ImportdataController::class);
Route::resource('users', UsersController::class);
Route::get('/phpinfo', function() {
    return phpinfo();
});



Route::resource('/pricesetting', PriceSettingController::class);
Route::POST('/pricesetting/datatableapi',  [PriceSettingController::class,'datatableapi'])->name('pricesetting.datatableapi');
Route::POST('/pricesetting/bulkdelete',  [PriceSettingController::class,'bulkdelete'])->name('pricesetting.bulkdelete');


Route::resource('/tracking', TrackingController::class);
Route::POST('/tracking/datatableapi',  [TrackingController::class,'datatableapi'])->name('tracking.datatableapi');


Route::post('/upload-csv', [InventoryPriceController::class,'uploadcsv'])->name('upload-csv');
Route::post('/insert-csv', [InventoryPriceController::class,'insertcsv'])->name('insert-csv');
Route::post('/order_creating', [InventoryPriceController::class,'order_creating'])->name('order_creating');


// Vendors Routes
Route::get('/vendors/trq', [TrqController::class,'index'])->name('vendor_trq.index');
Route::post('/vendors/trq_orders', [TrqController::class,'trq_orders'])->name('trq_orders');


Route::post('/vendors/check_stock', [TrqController::class,'vendor_check_stock'])->name('vendor_check_stock');


Route::post('/trqOperation', [TrqController::class, 'trqOperation'])->name('trqOperation');
// Route::post('/vendors/trq_rma', [TrqController::class,'trqrma'])->name('trqrma');
// Route::post('/vendors/trq_refund', [TrqController::class,'trqrefund'])->name('trqrefund');
Route::post('/vendors/trq_cancel', [TrqController::class,'trqcancel'])->name('trqcancel');




Route::POST('fetchUPSApi/{tracking}',  [UpsController::class,'fetchUPSApi'])->name('fetchUPSApi');


Route::name('warehouses')->resource('/warehouses/list', WarehouseListController::class);
Route::POST('/warehouses/datatableapi',  [WarehouseListController::class,'datatableapi'])->name('warehouses.list.datatableapi');
Route::POST('/warehouses/bulkdelete',  [WarehouseListController::class,'bulkdelete'])->name('warehouses.list.bulkdelete');



Route::get('/warehouse-report/{report}',  [WarehouseController::class,'warehouse_report_csv'])->name('warehouse.report');


Route::get('/warehouse/{warehouse}', [WarehouseController::class,'index']);
Route::post('/warehouse/{warehouse}', [WarehouseController::class,'store'])->name('{warehouse}.store');
Route::put('/warehouse/{warehouses_id}/{warehouse}', [WarehouseController::class,'update'])->name('{warehouse}.update');
Route::put('/warehouse/{warehouses_id}/ship/{warehouse}', [WarehouseController::class,'ship'])->name('{warehouse}.ship');
Route::POST('/warehouse/{warehouse}/datatableapi',  [WarehouseController::class,'datatableapi'])->name('warehouse.datatableapi');
Route::POST('/warehouse/{warehouse}/bulkdelete',  [WarehouseController::class,'bulkdelete'])->name('warehouse.bulkdelete');

Route::get('/Pfwarehouse', [WarehouseController::class,'Pfwarehouse'])->name('warehouses.PF_wholesale');
Route::get('/Essandent_AO', [WarehouseController::class,'Pfwarehouse'])->name('warehouses.Essandent_AO');
Route::get('/Essandent_EVE', [WarehouseController::class,'Pfwarehouse'])->name('warehouses.Essandent_EVE');
Route::get('/PA_warehouse', [WarehouseController::class,'Pfwarehouse'])->name('warehouses.PA_warehouse');
Route::get('/FL', [WarehouseController::class,'Pfwarehouse'])->name('warehouses.FL');
Route::get('/warehouse/inventory/{warehouse}', [WarehouseController::class,'inventory'])->name('warehouse.inventory');

Route::POST('/pf_datatableapi',  [WarehouseController::class,'pf_datatableapi'])->name('pf_warehouse.datatableapi');
Route::POST('/pf_warehouse_store',  [WarehouseController::class,'pf_warehouse_store'])->name('pf_warehouse.store');
Route::PUT('/pf_warehouse_edit',  [WarehouseController::class,'pf_warehouse_edit'])->name('pf_warehouse.edit');
Route::POST('/pf_warehouse',  [WarehouseController::class,'pf_warehouse_delete'])->name('pf_warehouse.delete');
Route::post('/pf_warehouse/insert-csv', [WarehouseController::class,'insertcsv'])->name('pf_warehouse.insert-csv');


Route::controller(VaWarehouseController::class)->group(function () {

    Route::get('/VaEssandent','index')->name('warehouses.VaEssandent');
    Route::get('/va-orders','inventory_orders')->name('va.orders');
    Route::get('/va-returns','returns_index')->name('va.returns');
    Route::POST('/va_datatableapi', 'datatableapi')->name('va_warehouse.datatableapi');
    Route::POST('/va_warehouse_store', 'store')->name('va_warehouse.store');
    Route::PUT('/va_warehouse_edit', 'edit')->name('va_warehouse.edit');
    Route::POST('/va_warehouse',  'delete')->name('va_warehouse.delete');


    Route::get('/va_report', 'va_report')->name('va.report');
    Route::get('/download_orders', 'va_report')->name('va.download.orders');

    Route::get('/va-approval','inventory_approval')->name('va.inventory_approval');
    Route::POST('/va/approval/datatableapi',  'approval_datatableapi')->name('approval.datatableapi');
    Route::POST('/va/approval/store',  'approval_store')->name('approval.store');
    Route::PUT('/va/approval/edit',  'approval_edit')->name('approval.edit');
    Route::POST('/va/approval/delete',  'approval_delete')->name('va.approval.delete');
    Route::POST('/va/approval/approve',  'approval_approve')->name('approval.approve');

    Route::POST('/va/approval/store', 'inventory_store')->name('va.approval.store');
    Route::POST('/va-order-store', 'order_store')->name('va.order.store');
    Route::PUT('/va-order-edit', 'orders_edit')->name('va.order.edit');
    Route::POST('/va-reOrder','reOrder')->name('va.reOrder');
    Route::POST('/order-delete',  'order_delete')->name('order.delete');

    Route::post('/order-label-download','order_label_download')->name('order.label.download');

    Route::POST('/va-datatableapi', 'orders_datatableapi')->name('va.datatableapi');


});

Route::get('/va/download_labels',  [VaWarehouseController::class,'download_labels'])->name('download_labels');

Route::get('/warehouse/returns/{warehouse}', [WarehouseController::class,'returns_index'])->name('returns.index');
Route::POST('/reOrder', [WarehouseController::class,'reOrder'])->name('reOrder');
Route::POST('/open_return', [WarehouseController::class,'open_return'])->name('open_return');
Route::POST('/warehouse/order/returns',  [WarehouseController::class,'returns'])->name('returns.datatableapi');

Route::get('/warehouse/orders/{warehouse}', [WarehouseController::class,'Pfwarehouse_orders'])->name('warehouse.order');
Route::POST('/warehouse/order/warehouse_orders',  [WarehouseController::class,'warehouse_orders'])->name('warehouse.order.datatableapi');
Route::POST('/warehouse/order/store',  [WarehouseController::class,'warehouse_order_store'])->name('warehouse.order.store');
Route::PUT('/warehouse/edit',  [WarehouseController::class,'warehouse_edit'])->name('warehouse.edit');
Route::POST('/warehouse/order/delete',  [WarehouseController::class,'warehouse_order_delete'])->name('warehouse_order.delete');
Route::POST('/return/delete',  [WarehouseController::class,'return_delete'])->name('return.delete');
Route::POST('/return/approve',  [WarehouseController::class,'return_approve'])->name('return.approve');
Route::PUT('/return/edit',  [WarehouseController::class,'return_edit'])->name('return.edit');
Route::POST('/return/bulk_ship',  [WarehouseController::class,'open_bulk_return'])->name('return.bulk_ship');

Route::POST('/inventory/datatableapi',  [WarehouseController::class,'inventory_datatableapi'])->name('inventory.datatableapi');
Route::POST('/inventory/store',  [WarehouseController::class,'inventory_store'])->name('inventory.store');
Route::PUT('/inventory/edit',  [WarehouseController::class,'inventory_edit'])->name('inventory.edit');
Route::POST('/inventory/delete',  [WarehouseController::class,'approval_delete'])->name('approval.delete');
Route::POST('/inventory/approve',  [WarehouseController::class,'inventory_approve'])->name('inventory.approve');
Route::POST('/inventory/bulk_ship',  [WarehouseController::class,'inventory_bulk_ship'])->name('inventory.bulk_ship');
Route::POST('/inventory/get_parts_data',  [WarehouseController::class,'get_parts_data'])->name('inventory.get_parts_data');
Route::get('/download_labels',  [WarehouseController::class,'download_labels'])->name('download_labels');


Route::get('/warehouses/summary', [WarehouseListController::class,'summary'])->name('warehouses.list.summary');
Route::get('/summary_csv_download', [WarehouseListController::class,'summary_csv_download'])->name('summary.csv.download');
Route::POST('/download_orders_csv', [WarehouseListController::class,'download_orders_csv'])->name('download.orders.csv');
Route::get('/download_orders_report', [WarehouseListController::class,'download_orders_report'])->name('download.orders.report');
Route::get('/download_returns_report', [WarehouseListController::class,'download_returns_report'])->name('download.returns.report');
Route::post('/summary-label-download', [WarehouseListController::class,'summary_label_download'])->name('summary.label.download');


Route::get('/warehouses/del_image', [WarehouseController::class,'del_image'])->name('warehouses.list.delimage');


Route::get('/warehouses/del_inlabel', [WarehouseController::class,'del_inlabel'])->name('warehouses.list.delinlabel');



Route::get('/pf_order_setting', [PfController::class,'pf_order_setting'])->name('pf_order_setting.index');

Route::post('/pf_order_setting', [PfController::class,'pf_order_setting_save'])->name('pf_order_setting.store');

Route::get('/trq_settings', [TrqController::class,'trq_settings_get'])->name('trq_settings.index');
Route::post('/trq_settings', [TrqController::class,'trq_settings_save'])->name('trq_settings.store');

Route::resource('/order_pf', PfOrderController::class);
Route::POST('/order_pf/datatableapi',  [PfOrderController::class,'datatableapi'])->name('order_pf.datatableapi');
Route::POST('/order_pf/bulkdelete',  [PfOrderController::class,'bulkdelete'])->name('order_pf.bulkdelete');

Route::POST('/order_pf/send_mail',  [PfOrderController::class,'send_mail'])->name('order_pf.send_mail');
 });

Route::post('/vendors/trq_order', [TrqController::class,'show'])->middleware('cors');


// Route::middleware('cors')->group(function () {
//     Route::options('/product', function(){
//         return 'hello';
//     });
//     Route::get('/hi', function(){
//         return 'hello';
//     });
// });
// Route::get('/findbrand', function (){
//     $sku = 'ACA80035';
//     $data = DB::table('trq')->where('PartNumber','LIKE','%'.$sku.'%')->first();
//     dd($data);
// });



Route::middleware('cors')->group(function () {
    Route::get('/product', [ShopifyController::class, 'product']);
});



Route::get('/test',  function(){
    //  DB::statement("UPDATE `inventory_prices` SET `profit`= 10 LIMIT 100");
    // $shopify_syned = DB::table('shopify_product_details')->select('sku')->get()->pluck('sku')->toArray();
    // dd($shopify_syned);
});


Route::get('/download/{name}',  function($name){
    if (file_exists('./cron/trq_inventory/'.$name)){

        header('Content-type: audio/mp3');
        header('Content-disposition: attachment; filename='.$name.'');
        readfile('./cron/trq_inventory/'.$name);
        exit();

    } elseif(file_exists('./cron/unity/'.$name)){
        header('Content-type: audio/mp3');
        header('Content-disposition: attachment; filename='.$name.'');
        readfile('./cron/unity/'.$name);
        exit();
    } else{
        return redirect()->back();
    }
})->name('download');

Route::get('/downloadtrack/{name}',  function($name){
    if (file_exists('./cron/Tracking/'.$name)){


        header('Content-type: audio/mp3');
        header('Content-disposition: attachment; filename='.$name.'');
        readfile('./cron/Tracking/'.$name);
        exit();



    } else {
        return redirect()->back();
    }
})->name('downloadtrack');


Route::get('/downloadpf/{name}',  function($name){
    if (file_exists('./cron/pf/'.$name)){


        header('Content-type: audio/mp3');
        header('Content-disposition: attachment; filename='.$name.'');
        readfile('./cron/pf/'.$name);
        exit();



    } else {
        return redirect()->back();
    }
})->name('downloadpf');




Route::post('/calculate_pf', [PfController::class,'pf_calculator'])->name('calculate_pf');


/**
 * Socialite login using Google service
 * https://laravel.com/docs/8.x/socialite
 */
Route::get('/auth/redirect/{provider}', [SocialiteLoginController::class, 'redirect']);

require __DIR__.'/auth.php';
