<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use DB;

class VendorController extends Controller
{
     public function bulkdelete(Request $request){
        if (isset($request->list) && $request->list != '') {
          $list = explode(',', $request->list);
    
          Vendor::whereIn('id', $list)->delete();
        }
      }
    
     public function datatableapi(Request $request)
      {
    
        //$model = Orders::query();
    
        
          $model = Vendor::orderBy('id','desc');
       
    
        // $model = $model->pluck('orders');
        // dd($model);
         if (isset($request->vendor) && $request->vendor != '') {
          $model->where('vendor',$request->vendor);
        }
        
       
        
        
      
        // if (isset($request->email_verify) && $request->email_verify != '') {
        //   if ($request->email_verify == 'Verifyed') {
        //     $model->whereNotNull('email_verified_at');
        //   } else {
        //     $model->whereNull('email_verified_at');
        //   }
        // }
        
        
        $model = $model->orderBy('id','desc')->get();
    
    $_GET['id']=1;
    
        return DataTables::of($model)
          ->setRowId(function ($data) {
            return '';
          })
          // ->setRowClass(function ($user) {

          ->setRowData([

          ])
   
        
          ->editColumn('created_at', function ($row) {
             return Carbon::parse($row->created_at)->diffForHumans();  
          })

          
          ->addColumn('checkbox',  function ($row) {
            return ' <div class="form-check form-check-sm form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
      </div>';
          })
            ->addColumn('total', function($row)  {
          return view('pages.vendor.action',['row'=>$row]);
        })
          
          ->addColumn('action', function($row)  {
          return view('pages.vendor.action',['row'=>$row]);
        })
        
          ->rawColumns(['checkbox','total', 'action'])
          ->make(true);
          
          
          
      }
    
    public function index()
      {
        $users = array();
     
        return view('pages.vendor.main',['users'=>$users]);
      }
    
     public function store(Request $request)
    {
      //$request->name = ($request->name == NULL) ? 0 : 1;
      
        
        $vendor = Vendor::create(
        [
            'name'         => $request->name,
            
       ]);
      
        
       if (isset($vendor->id)) {
         return response()->json(['message'=>'Vendor Successfully Added'],200);
       } else {
         return response()->json(['message'=>'Unable To Process Request'],500);
       }
    }
    
    public function update(Request $request, $id)
    {
       // dd($id);
      $vendor = Vendor::find($id);
        $vendor->name  = $request->name;
        $vendor->save();
       
        
   if (isset($vendor->id)) {
         return response()->json(['success' => true, 'message' => __('Vendor Updated Successfully!!')]);

    //  return response()->json(['message'=>' Successfully Updated'],200);
   } else {
     return response()->json(['message'=>'Unable To Process Request'],500);
   }
    }
}
