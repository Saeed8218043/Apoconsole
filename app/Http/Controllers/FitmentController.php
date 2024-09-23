<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use DataTables;
use Carbon\Carbon;
use DB;
use App\Models\Fitment;

class FitmentController extends Controller
{
    //

    public function bulkdelete(Request $request)
    {
        if (isset($request->list) && $request->list != '') {
          $list = explode(',', $request->list);
    
          Order::whereIn('id', $list)->delete();
        }
    }

    public function datatableapi(Request $request)
    {
  
      //$model = Orders::query();
  
      
        $model = Fitment::orderBy('id','desc')->get();
  

        // json_decode($model
        
      // $model = $model->pluck('orders');
      // dd($model);
      //  if (isset($request->role_filter) && $request->role_filter != '') {
      //   $model->whereRelation('roles', 'name',  $request->role_filter);
      // }
      // if (isset($request->email_verify) && $request->email_verify != '') {
      //   if ($request->email_verify == 'Verifyed') {
      //     $model->whereNotNull('email_verified_at');
      //   } else {
      //     $model->whereNull('email_verified_at');
      //   }
      // }
  
  $_GET['id']=1;
  
      return DataTables::of($model)
        // ->setRowId(function ($data) {
            
        //   return $data;
        // })
        // ->setRowClass(function ($user) {

        ->setRowData([

        ])
 
// ->editColumn('part_no', function ($row) {
//    if($row->found == 0 ){
//         return  $row->part_no.'<i aria-hidden="true" style="color: red;display:contents" data-toggle="tooltip" data-theme="dark" title="No Record Found" class="fa fa-times-circle page_speed_256570326"></i>'; 
//       }else{
//           return  $row->part_no; 
//       }
   

           
//         })
        ->editColumn('created_at', function ($row) {
           return Carbon::parse($row->created_at)->diffForHumans();  
        })

        
    //     ->addColumn('eqty', function ($row) {
    //          if($row->qty >= 5){
                 
    //            return 5;  
               
    //          }else if($row->qty <= 4){
    //              return $row->qty; 
    //          }
           
    //    })
  
    //      ->addColumn('gross', function ($row) {
    //       return $row->cost+$row->fee+$row->commission+$row->shipping;  
    //    })
   
       
        ->addColumn('checkbox',  function ($row) {
          return ' <div class="form-check form-check-sm form-check-custom form-check-solid">
      <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
    </div>';
        })
        
        
       
       
 
       
       
        ->rawColumns(['checkbox', 'action', 'status', 'amountt', 'date','part_no'])
        ->make(true);
    }

    public function index()
    {
      $users = array();
   
      return view('pages.fitment.main',['users'=>$users]);
    }

 
   














































}
