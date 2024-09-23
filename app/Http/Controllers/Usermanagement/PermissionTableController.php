<?php

namespace App\Http\Controllers\Usermanagement;

use App\DataTables\Usermanagement\PermissionsDataTable;
use Illuminate\Http\Request;
//use App\DataTables\Logs\AuditLogsDataTable;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use DataTables;
class PermissionTableController extends Controller
{

    public function datatableapi(Request $request){
        $model = Permission::get();

     if (isset($request->role_filter) && $request->role_filter != '') {
     $model = Permission::where('module_name',  $request->role_filter)->get();
    }
    return DataTables::of($model)
      ->setRowId(function ($row) {
        return $row->id;
      })
      ->addColumn('checkbox', function ($data) {
        return ' <div class="form-check form-check-sm form-check-custom form-check-solid">
    <input class="form-check-input" type="checkbox" value="' . $data->id . '" />
  </div>';
      })
      ->addColumn('function', function ( $data) {
              return $data->name;
      })
      ->addColumn('created',  function ($row) {
        return $row->created_at->format('d M, Y H:i:s');
      })
      
      ->editColumn('action', function ($row) {

          return view('pages.user-management.permissions._action-menu', ['model' => $row]);
      })
      ->rawColumns(['checkbox', 'action','status'])
      ->make(true);
    } 

    public function bulkdelete(Request $request){
    if (isset($request->list) && $request->list != '') {
      $list = explode(',', $request->list);
      Permission::whereIn('id', $list)->delete();
    }
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        
        if (isset($_GET['createdefault'])){
            $this->creatdefault();
            
        }
        
        
        

        // dd(Permission::where('module_name',  'System Log')->get());
        $filter = Permission::distinct()->select('module_name')->orderBy('module_name')->get();
         // return $dataTable->render('pages.user-management.permissions.list');
         return view('pages.user-management.permissions.new',['filter'=>$filter]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $activity = Permission::find($id);
    //     $activity->delete();
    //      return redirect()->back()->with('success' , 'Permission Deleted Successfully');  
    // }

    public function store(Request $request){
        if (Permission::where('name' , $request->get('name'))->exists()) {
          return response()->json(['message' => 'Permission Already Exists!'],403);
        }

         if (Permission::where('module_name' ,$request->get('module_name'))->where('friendly_name' , $request->get('friendly_name'))->exists()) {
          return response()->json(['message' => 'Permission Name Already Exists!'],403);
        }


        Permission::create([
           'name' => $request->name,
           'guard_name' => 'web',
           'module_name' => $request->module_name,
           'friendly_name' => $request->friendly_name
        ]);

       


      return response()->json(['message' => 'Permission Added Successfully','redirect'=>route('user-management.permissions.index')],200);
    }




    public function update(Request $request,$id){

     

         if (Permission::where('id' ,'!=', $id)->where('name' , $request->get('name'))->exists()) {
          return response()->json(['message' => 'Permission Already Exists!'],403);
        }

         if (Permission::where('id' ,'!=', $id)->where('module_name' ,$request->get('module_name'))->where('friendly_name' , $request->get('friendly_name'))->exists()) {
          return response()->json(['message' => 'Permission Name Already Exists!'],403);
        }
         $per = Permission::find($id);
           $per->name = $request->name;
           $per->module_name = $request->module_name;
            $per->friendly_name = $request->friendly_name;

        $per->save();
        return response()->json(['message' => 'Permission Updated Successfully','redirect'=>route('user-management.permissions.index')],200);
    }
    
    
    
    
    
    
    
    
    
    
    // ------------------------------------------------------------------------
    
    public function creatdefault(){
        
        
        
        
$per = [
// ['Spatie','healthCheck','ignition.healthCheck'],
// ['Spatie','executeSolution','ignition.executeSolution'],
// ['Spatie','updateConfig','ignition.updateConfig'],
// ['profits','profits','profits'],


// ['Spatie Log','Menu','log.system.index'],
// ['Spatie Log','Delete','log.system.destroy'],
// ['Spatie Log','Show','log.audit.index'],
// ['Spatie Log','Delete','log.audit.destroy'],

// ['PriceSettings','Menu','pricesetting.index'],

// ['Settings','update','settings.update'],
// ['Settings','changeEmail','settings.changeEmail'],
// ['Settings','changePassword','settings.changePassword'],
// ['Settings','Menu','settings.index'],

['User Permissions', 'Menu', 'user-management.permissions.index'],
['User Permissions', 'create', 'user-management.permissions.create'],
['User Permissions', 'store', 'user-management.permissions.store'],
['User Permissions', 'show', 'user-management.permissions.show'],
['User Permissions', 'edit', 'user-management.permissions.edit'],
['User Permissions', 'update', 'user-management.permissions.update'],
['User Permissions', 'destroy', 'user-management.permissions.destroy'],
['User Permissions', 'List', 'user-management.permissions.datatableapi'],
['User Permissions' ,'bulkdelete' ,'user-management.permissions.bulkdelete'],
['User','create','user-management.user.list.create'],
['User','store','user-management.user.list.store'],
['User','show','user-management.user.list.show'],
['User','edit','user-management.user.list.edit'],
['User','update','user-management.user.list.update'],
['User','delete','user-management.user.list.destroy'],
['User','List','user-management.user.list.datatableapi'],
['User','delete','user-management.user.list.bulkdelete'],
['User','Menu','user-management.user.list.index'],
['User Roles','Menu','user-management.roles.list.index'],
['User Roles','create','user-management.roles.list.create'],
['User Roles','store','user-management.roles.list.store'],
['User Roles','show','user-management.roles.list.show'],
['User Roles','edit','user-management.roles.list.edit'],
['User Roles','update','user-management.roles.list.update'],
['User Roles','delete','user-management.roles.list.destroy'],
['Inventoryprice','create','inventoryprice.create'],
['Inventoryprice','store','inventoryprice.store'],
['Inventoryprice','show','inventoryprice.show'],
['Inventoryprice','edit','inventoryprice.edit'],
['Inventoryprice','update','inventoryprice.update'],
['Inventoryprice','destroy','inventoryprice.destroy'],
['Inventoryprice','List','inventoryprice.datatableapi'],
['Inventoryprice','delete','inventoryprice.bulkdelete'],
['Inventoryprice','Menu','inventoryprice.index'],
['Orders','Create','order.create'],
['Orders','Store','order.store'],
['Orders','Single Show','order.show'],
['Orders','Edit','order.edit'],
['Orders','Update','order.update'],
['Orders','Delete','order.destroy'],
['Orders','List','order.datatableapi'],
['Orders','Delete','order.bulkdelete'],
['Orders','Menu','order.index'],
['Orders','Order Csv','orderupload-csv'],
['Orders','Order Csv','orderinsert-csv'],
['Orders','Order Creating','order_creating'],

['User','Menu','users.index'],
['User','create','users.create'],
['User','store','users.store'],
['User','show','users.show'],
['User','edit','users.edit'],
['User','update','users.update'],
['User','delete','users.destroy'],
['Pricesetting Module','create','pricesetting.create'],
['Pricesetting Module','store','pricesetting.store'],
['Pricesetting Module','show','pricesetting.show'],
['Pricesetting Module','edit','pricesetting.edit'],
['Pricesetting Module','update','pricesetting.update'],
['Pricesetting Module','delete','pricesetting.destroy'],
['Pricesetting Module','List Show','pricesetting.datatableapi'],
['Pricesetting Module','delete','pricesetting.bulkdelete'],
['Inventry csv','Csv','upload-csv'],
['Inventry csv','Csv','insert-csv'],

['TRQ Vendor','Trq Orders','trq_orders'],
['TRQ Vendor','Trq Check Stock','vendor_check_stock'],
['TRQ Vendor','Trq RMA','trqrma'],
['TRQ Vendor','Trq Refund','trqrefund'],
['TRQ Vendor','Trq Cancel','trqcancel'],
['System','system','register'],
['System','system','login'],
['System','system','password.request'],
['System','system','password.email'],
['System','system','password.reset'],
['System','system','password.update'],
['System','system','verification.notice'],
['System','system','verification.verify'],
['System','system','verification.send'],
['System','system','password.confirm'],
['System','system','logout']
];
        
        
        foreach($per as $p){
          
            
            
            Permission::create([
          'name' => $p[2],
          'guard_name' => 'web',
          'module_name' => $p[0],
          'friendly_name' => $p[1]
        ]);  
        }
        
        die();
        
      

        
        
    }
    
    
    
    
    
    
    
    
}


