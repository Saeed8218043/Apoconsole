<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderrrc;
use DataTables;
use Carbon\Carbon;
use DB;


class TrqrmaController  extends Controller
{
    //

 
 

    public function datatableapi(Request $request)
    {
  
      //$model = Orders::query();
  
      
        $model = Orderrrc::get();
  

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
           return Carbon::parse($row->created_at)->format('d-m-Y ');  
        })
        
        
          ->addColumn('action', function($row)  {
          return view('pages.trqrma.action',['row'=>$row]);
        })
        
        
          ->addColumn('submit', function($row)  {
              if ($row->rma != NULL){
              return "<p style='color: green;' >RMA</p>";
          }  
           if ($row->refund != NULL){
              return "<p style='color: green;' >Refund</p>";
          }
              
          
              return "<p style='color: green;' >Cancel</p>";
          
         
        
        })
        
         ->addColumn('status', function($row)  {
            
           if ($row->rma != NULL){
               $a = 1;
          }  
           if ($row->refund != NULL){
               $a = 2;
          }
          if (!isset($a)){
              $a = 3;
          }
          
        
          
          if ($a == 1 && isset(json_decode($row->rma ,true)['id'] )){
            return "<p style='color: green;' >Success</p>";
          } elseif ($a == 1) {
              return "<p style='color: red;' >Error</p>";
          }
          
          
           if ($a == 2 && isset(json_decode($row->refund ,true)['id'] )){
            return "<p style='color: green;' >Success</p>";
          } elseif ($a == 2) {
              return "<p style='color: red;' >Error</p>";
          }
          
          
          
           if ($a == 3 && $row->cancel  ==  ''){
            return "<p style='color: green;' >Cancel Success</p>";
          } elseif ($a == 3) {
              return "<p style='color: red;' >Cancel Failed</p>";
          }
          
          
              
        })
        
        
         ->addColumn('view', function($row)  {
            
           if ($row->rma != NULL){
               $a = 1;
          }  
           if ($row->refund != NULL){
               $a = 2;
          }
          if (!isset($a)){
              $a = 3;
          }
          
           if ($a == 1){
              if (isset(json_decode($row->rma,true)['message'])){
               return '<p style="color: red;" ><strong>Error: </strong>'.json_decode($row->rma,true)['message'].'</p>';   
              } 
              if (isset(json_decode($row->rma,true)['id'])){
               return '<p><strong>RMA ID: </strong>'.json_decode($row->rma,true)['id'].'<br><strong>Unique ID: </strong>'.json_decode($row->rma,true)['uniqueId'].'</p>';   
              } 
           } 
            if ($a == 2){
              if (isset(json_decode($row->refund,true)['message'])){
               return '<p style="color: red;" ><strong>Error: </strong>'.json_decode($row->refund,true)['message'].'</p>';   
              } 
              if (isset(json_decode($row->refund,true)['id'])){
               return '<p><strong>Return ID: </strong>'.json_decode($row->refund,true)['id'].'<br><strong>Unique ID: </strong>'.json_decode($row->refund,true)['uniqueId'].'</p>';   
              } 
           } 
           
            if ($a == 3){
              if (isset(json_decode($row->cancel,true)['message'])){
               return '<p style="color: red;" ><strong>Error: </strong>'.json_decode($row->cancel,true)['message'].'</p>';   
              } 
              if ($row->rma == ''){
               return '<p>Cancel Success</p>';   
              } 
           } 
            
          
              
        })
        
        
        
        
        
        
        
        
        ->addColumn('checkbox',  function ($row) {
            
            if (isset(json_decode($row->vendor_json,true)['id'])){
              return '';  
            }
            
            
          return ' <div class="form-check form-check-sm form-check-custom form-check-solid">
      <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
    </div>';
        })
        
       
        ->rawColumns(['checkbox', 'action', 'status','status_message', 'amountt', 'date','part_no','submit','view'])
        ->make(true);
    }

    public function index()
    {
      $users = array();
   
      return view('pages.trqrma.main',['users'=>$users]);
    }



}
  


  
    
    

