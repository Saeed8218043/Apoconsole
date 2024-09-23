<?php

namespace App\Http\Controllers\Usermanagement;

use Illuminate\Http\Request;
//use App\DataTables\Logs\AuditLogsDataTable;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Barryvdh\Reflection\DocBlock\Tag\ThrowsTag;



class RolesTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

     $data['roles']= Role::with(['users','permissions'])->get();

        $data['permissions'] = Permission::orderBy('module_name')->orderBy('friendly_name')->get();
        
        return view('pages.user-management.roles.list',['data'=>$data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $role = Role::find($id);
         $role->delete();
          return redirect()->back()->with('success' , 'Role Deleted Successfully!');  
    }

    public function store(Request $request){
        // print_r($request->all());
        // return ;
        if (Role::where('name' , $request->get('name'))->exists()) {
            return redirect()->back()->with('error' , 'Name Already Exists!');
        }
         

         
         $role = Role::create(['name' => $request->get('name')]);
        $role->syncPermissions($request->get('permission'));

      //  Permission::create($request->only('name'));
       return redirect()->back()->with('success' , 'Role Added Successfully!');  
    }


   


    public function show(Request $request,$id){
      $data = Role::where('id',$id)->with(['users','permissions'])->first();
      
      
         $data['permissionss'] = Permission::orderBy('module_name')->orderBy('friendly_name')->get();
        
         
        return view('pages.user-management.roles.view',['data'=>$data]);
    }


    public function update(Request $request,$id){
        if (Role::where('id' ,'!=', $id)->where('name' , $request->get('name'))->count() > 0) {
            
            return redirect()->back()->with('error' , 'Name Already Exists!');
        }

        // print_r($request->all());
        $role = Role::find($id);
        $role->name = $request->get('name');
        $role->save();
        $role->syncPermissions($request->get('permission'));

      //  Permission::create($request->only('name'));
       return redirect()->back()->with('success' , 'Role Updated Successfully!');  
    }
}
