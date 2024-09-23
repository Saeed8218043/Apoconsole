<?php

namespace App\Http\Controllers;

use App\Models\Pf;
use App\Models\InventoryPrice;

use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use DB;
use App\Models\Order;
use Mail;
use App\Mail\DefaultTemplate;

class PfOrderController extends Controller
{
  
    
    
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
  
        $w = '"shipping_lines":[{"id":';
        $a = '"vendor":"AUTOOUTLET"';
        $model = Order::orderBy('id','desc')->where('order_json', 'LIKE', "%{$w}%")->where('order_json', 'LIKE', "%{$a}%")->get();
  

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

        ->addColumn('sku', function ($row) {
            if (isset(json_decode($row->order_json,true)['line_items'][0])){
              $row = json_decode($row->order_json,true)['line_items'][0]['sku'];
          return $row;   
            }
             
       })
       ->addColumn('name', function ($row) {
           if (isset(json_decode($row->order_json,true)['line_items'][0])){
             $row = json_decode($row->order_json,true)['line_items'][0]['sku'];
          return $row;    
           }
            
       })
       
       
       ->addColumn('phone', function ($data) {              $data = json_decode($data->order_json,true);       return (isset($data['shipping_address']['phone'])) ? $data['shipping_address']['phone'] : '' ;         } )
->addColumn('shippingName', function ($data) {              $data = json_decode($data->order_json,true);       return (isset($data['shipping_address']['first_name'])) ? $data['shipping_address']['first_name']." ".$data['shipping_address']['last_name'] : '' ;                                          } )
->addColumn('shippingAddress1', function ($data) {          $data = json_decode($data->order_json,true);       return (isset($data['shipping_address']['address1'])) ? $data['shipping_address']['address1'] : '' ;                                          } )
->addColumn('shippingAddress2', function ($data) {          $data = json_decode($data->order_json,true);       return (isset($data['shipping_address']['address2'])) ? $data['shipping_address']['address2'] : '';                                           } )
->addColumn('shippingPostalCode', function ($data) {        $data = json_decode($data->order_json,true);       return (isset($data['shipping_address']['zip'])) ? explode('-', $data['shipping_address']['zip'])[0] : ''          ;                                           } )
->addColumn('shippingCity', function ($data) {              $data = json_decode($data->order_json,true);       return (isset($data['shipping_address']['city'])) ? $data['shipping_address']['city'] : ''    ;                                           } )
->addColumn('shippingCountry', function ($data) {           $data = json_decode($data->order_json,true);       return (isset($data['shipping_address']['country_code'])) ? $data['shipping_address']['country_code'] : ''     ;                                           } )
->addColumn('shippingRegion', function ($data) {            $data = json_decode($data->order_json,true);       return (isset($data['shipping_address']['province_code'])) ? $data['shipping_address']['province_code'] : '' ;                                           } )
       
       
    
       
        ->addColumn('city', function ($row) {
            if (isset(json_decode($row->order_json,true)['shipping_address']['city'])){
             $row = json_decode($row->order_json,true)['shipping_address']['city'];
          return $row;    
            }
             
       })
   ->addColumn('zip', function ($row) {
       if(isset(json_decode($row->order_json,true)['shipping_address']['province_code'])){
           $row = json_decode($row->order_json,true)['shipping_address']['province_code'];
          return $row;   
       }
           
       })
       
       ->addColumn('price', function ($row) {
           if (isset(json_decode($row->order_json,true)['line_items'][0]['price'])){
             $row = json_decode($row->order_json,true)['line_items'][0]['price'];
             return $row;     
           }
       
   })
   
    ->addColumn('shipper_name', function ($row) {
           if (isset(json_decode($row->order_json,true)['shipping_address']['first_name'])){
             $row = json_decode($row->order_json,true)['shipping_address']['first_name']." ".json_decode($row->order_json,true)['shipping_address']['last_name'];
             return $row;     
           }
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
   
        ->addColumn('action', function($row)  {
          return view('pages.order.pforder.action',['row'=>$row]);
        })
        ->addColumn('checkbox',  function ($row) {
            
           if ($row->vendor_json == 'email_sent'){
             
            return '';      
            }
            
            
          return ' <div class="form-check form-check-sm form-check-custom form-check-solid">
      <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
    </div>';
        })
        
        
        ->addColumn('shipping_method', function ($row) {
            $row = 'Standard';
          return $row;  
       })
       
          ->addColumn('country_code', function ($row) {
              if (isset(json_decode($row->order_json,true)['shipping_address']['province_code'])){
                $row = json_decode($row->order_json,true)['shipping_address']['province_code'];
                return $row;     
              }
           
       })
         ->addColumn('address', function ($row) {
             if (isset(json_decode($row->order_json,true)['shipping_address']['address1'])){
              $row = json_decode($row->order_json,true)['shipping_address']['address1'];
                return $row;     
             }
            
       })
        ->addColumn('address2', function ($row) {
            if (isset(json_decode($row->order_json,true)['shipping_address']['address2'])){
               $row = json_decode($row->order_json,true)['shipping_address']['address2'];
                return $row;    
            }
           
       })
         ->addColumn('currency', function ($row) {
            $row = '$';
          return $row;  
       })
            ->addColumn('po_number', function ($row) {
                 if (isset(json_decode($row->order_json,true)['ponumber'])  ){
              //$row = "<p style='color: red' >".json_decode($row->order_json,true)['ponumber']."</p>";
                return json_decode($row->order_json,true)['ponumber'];    
            } else {
                return json_decode($row->order_json,true)['name'];
            }
             
          
       })
       
          
        ->addColumn('contact_email', function ($row) {
            $row = json_decode($row->order_json,true)['shipping_address']['first_name'];
          return $row;  
       }) 
       
      
        ->addColumn('payment_name', function ($row) {
            if (isset(json_decode($row->order_json,true)['payment_gateway_names'][0])){
              $row = json_decode($row->order_json,true)['payment_gateway_names'][0];
          return $row;    
            }
            
       })
       
         ->addColumn('province_code', function ($row) {
             if (isset(json_decode($row->order_json,true)['shipping_address']['province_code'])){
               $row = json_decode($row->order_json,true)['shipping_address']['province_code'];
                 return $row;     
             }
           
       })
       
        ->addColumn('vendor', function ($row) {
            if (isset(json_decode($row->order_json,true)['line_items'][0])){
              
            }
            
       }) 
       
        ->addColumn('variant', function ($row) {
            if (isset(json_decode($row->order_json,true)['line_items'][0])){
              
            }
           
       }) 
       ->addColumn('total', function ($row) {
            if (isset(json_decode($row->vendor_json,true)['orderTotal'])){
             $row = json_decode($row->vendor_json,true)['orderTotal'];
            return $row;      
            }
           
       }) 
        ->addColumn('trq_id', function ($row) {
            if (isset(json_decode($row->vendor_json,true)['id'])){
             $row = json_decode($row->vendor_json,true)['id'];
            return $row;      
            }
           
       }) 
       ->addColumn('status', function ($row) {
           
         
           
            if ($row->vendor_json == 'email_sent'){
             $row = "<p style='color: blue;' >Order Punched</p>";
            return $row;      
            }
           
       }) 
       
       
       ->addColumn('status_message', function ($row) {
           
           
            if ($row->vendor_json == 'email_sent'){
             $row = "<p style='color: blue;' >Order Punched</p>";
            return $row;      
            }
           
           
       }) 
       
       
        ->addColumn('items', function ($row) {
           
          if (isset(json_decode($row->order_json,true)['line_items'])){
              $row = json_decode($row->order_json,true)['line_items'];
                  return $row;    
            }
           
       }) 
       
        ->rawColumns(['checkbox', 'action', 'status','status_message', 'amountt', 'date','part_no','po_number'])
        ->make(true);
    }
      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
        $users = array();
     
        return view('pages.order.pforder.main',['users'=>$users]);
      }
    
    
    
    
    
    public function send_mail(Request $request){
         $order  = $request;
         
         
         if ($request->type == 'new_order'){
             return $this->new_order_send_mail($request);
         }
         
        $order = Order::find($request->order_id);
        $order_json = json_decode($order->order_json,true);
        
        
        
        if (!isset($order_json['ponumber'])){
            $w = '"shipping_lines":[{"id":';
            $a = '"vendor":"AUTOOUTLET"';
            $lastorder = \App\Models\Order::orderBy('id','desc')->where('order_json', 'LIKE', "%{$w}%")->where('order_json', 'LIKE', "%{$a}%")->get();
            $n=0;
            foreach  ($lastorder as $a ){
                if (isset(json_decode($a->order_json,true)['ponumber']) &&  explode('-',json_decode($a->order_json,true)['ponumber'])[0] == 'g' && (int)explode('-',json_decode($a->order_json,true)['ponumber'])[1] > $n){
                  $n = (int)explode('-',json_decode($a->order_json,true)['ponumber'])[1];   
                }   
            }
            
            
            if (!isset(explode('-',$request->ponumber)[0]) || explode('-',$request->ponumber)[0] != 'g'){
                return response()->json(['message' => 'Sorry Invalid Po Number!'],500);
            }
            
            if (!isset(explode('-',$request->ponumber)[1])){
                return response()->json(['message' => 'Sorry Invalid Po Number!'],500);
            }
            
            foreach  ($lastorder as $a){
                if (isset(json_decode($a->order_json,true)['ponumber']) &&   explode('-',json_decode($a->order_json,true)['ponumber'])[1] == explode('-',$request->ponumber)[1]){
                   return response()->json(['message' => 'Sorry Po Number already Used!'],500); 
                }   
            }  
        }
        
        
        
        $order_json['ponumber'] = (isset($order_json['ponumber'])) ? $order_json['ponumber'] : $request->ponumber;
      
         
         
       //  return view('emails.default')->with(['order' => $order]);
       
       
      
       
       
       
       
       
       
       
       config(['mail.mailers.smtp.host' =>   \App\Models\Setting::get('pf_order_smtp_host','')     ]);
        config(['mail.mailers.smtp.port' =>         \App\Models\Setting::get('pf_order_smtp_port','')     ]);
        config(['mail.mailers.smtp.username' =>         \App\Models\Setting::get('pf_order_smtp_email','')     ]);
        config(['mail.mailers.smtp.password' =>         \App\Models\Setting::get('pf_order_smtp_password','')     ]);
        config(['mail.from.address' =>         \App\Models\Setting::get('pf_order_smtp_email','')     ]);
        config(['mail.from.name' =>         'genXsupply'    ]);
        
        
       
        Mail::to($request->recipient_email)->send(new DefaultTemplate($order,$request->recipient_email,[$request->cc_email,$request->cc_name],$order_json['ponumber']) );
        
        
        
          $order = Order::find($request->order_id);
          
          $order_json = json_decode($order->order_json,true);
          
          
           $order_json['ponumber'] = (isset($order_json->ponumber)) ? $order_json->ponumber : $request->ponumber;
          
          
          $order_json['shipping_address'] = 
  array (
    'first_name' => $request->shippingName,
    'address1' => $request->shippingAddress1,
    'phone' => $request->phone,
    'city' => $request->shippingCity,
    'zip' => $request->shippingPostalCode,
    'province' => ' ',
    'country' => $request->shippingCountry,
    'last_name' => ' ',
    'address2' => $request->shippingAddress2,
    'company' => NULL,
    'latitude' => 38.6298052,
    'longitude' => -77.3267664,
    'name' => ' ',
    'country_code' => $request->shippingCountry,
    'province_code' => $request->shippingRegion,
  );
          
          
          
          
          
        $order->update([
           'vendor_json' => 'email_sent',
           'order_json' => $order_json
          ]); 
        
        
        
        return response()->json(['message'=>'Order Send Successfully!']);
        
  
    } 
    
    
    
    public function new_order_send_mail($request){
        
        
        
        $w = '"shipping_lines":[{"id":';
        $a = '"vendor":"AUTOOUTLET"';
        $lastorder = \App\Models\Order::orderBy('id','desc')->where('order_json', 'LIKE', "%{$w}%")->where('order_json', 'LIKE', "%{$a}%")->get();
        $n=0;
        foreach  ($lastorder as $a ){
         if (isset(json_decode($a->order_json,true)['ponumber']) &&  explode('-',json_decode($a->order_json,true)['ponumber'])[0] == 'g' && (int)explode('-',json_decode($a->order_json,true)['ponumber'])[1] > $n){
          $n = (int)explode('-',json_decode($a->order_json,true)['ponumber'])[1];   
        }   
        }
        
        
        if (!isset(explode('-',$request->ponumber)[0]) || explode('-',$request->ponumber)[0] != 'g'){
            return response()->json(['message' => 'Sorry Invalid Po Number!'],500);
        }
        
        if (!isset(explode('-',$request->ponumber)[1])){
            return response()->json(['message' => 'Sorry Invalid Po Number!'],500);
        }
        
        foreach  ($lastorder as $a){
         if (isset(json_decode($a->order_json,true)['ponumber']) &&   explode('-',json_decode($a->order_json,true)['ponumber'])[1] == explode('-',$request->ponumber)[1]){
           return response()->json(['message' => 'Sorry Po Number already Used!'],500); 
        }   
        }
        
        
       
        
        
        $data = $this->pf_shopify_json($request);
        
        $data = json_encode($data);

      $order = Order::create([
          'shop_url' => "autospartoutlet.myshopify.com",
          'order_json' => $data,
        //   'vendor_json' => $order_vendor_response 
          ]); 
          
             $request->qty = $request->quantity;
         
          
          
         
        config(['mail.mailers.smtp.host' =>   \App\Models\Setting::get('pf_order_smtp_host','')     ]);
        config(['mail.mailers.smtp.port' =>         \App\Models\Setting::get('pf_order_smtp_port','')     ]);
        config(['mail.mailers.smtp.username' =>         \App\Models\Setting::get('pf_order_smtp_email','')     ]);
        config(['mail.mailers.smtp.password' =>         \App\Models\Setting::get('pf_order_smtp_password','')     ]);
        config(['mail.from.address' =>         \App\Models\Setting::get('pf_order_smtp_email','')     ]);
        config(['mail.from.name' =>         'genXsupply'    ]);
        
        
       
        Mail::to($request->recipient_email)->send(new DefaultTemplate($request,$request->recipient_email,[$request->cc_email,$request->cc_name],$request->ponumber) );
        
        
        
        $order->update([
           'vendor_json' => 'email_sent' 
          ]); 
        
        
        
        return response()->json(['message'=>'Order Send Successfully!']);
        
          
          
          
     
    }
  
  
  
  
  
    
function pf_shopify_json($data,$extra = null){
$items = array();
$qty = $data->quantity;
$q=0;
foreach ($data->items as $i) {
   
  array_push($items,['sku'=>$i,'vendor'=>'AUTOOUTLET','quantity'=>$qty[$q]]);
  $q++;
}

$json = array (
    'ponumber' => (isset($data->ponumber)) ? $data->ponumber : '',
    'type' => 'pf_new_order_form',
  'extra' => $extra,
  'name' => 'poNumber',
  'line_items' => $items,
  'shipping_address' => 
  array (
    'first_name' => $data->shippingName,
    'address1' => $data->shippingAddress1,
    'phone' => (isset($data->phone)) ? $data->phone : '',
    'city' => $data->shippingCity,
    'zip' => $data->shippingPostalCode,
    'province' => ' ',
    'country' => $data->shippingCountry,
    'last_name' => ' ',
    'address2' => $data->shippingAddress2,
    'company' => NULL,
    'latitude' => 38.6298052,
    'longitude' => -77.3267664,
    'name' => ' ',
    'country_code' => $data->shippingCountry,
    'province_code' => $data->shippingRegion,
  ),
  'shipping_lines' => 
  array (
    0 => 
    array (
      'id' => 3801517949120,
      'carrier_identifier' => NULL,
      'code' => 'Standard',
      'delivery_category' => NULL,
      'discounted_price' => '0.00',
      'discounted_price_set' => 
      array (
        'shop_money' => 
        array (
          'amount' => '0.00',
          'currency_code' => 'USD',
        ),
        'presentment_money' => 
        array (
          'amount' => '0.00',
          'currency_code' => 'USD',
        ),
      ),
      'phone' => NULL,
      'price' => '0.00',
      'price_set' => 
      array (
        'shop_money' => 
        array (
          'amount' => '0.00',
          'currency_code' => 'USD',
        ),
        'presentment_money' => 
        array (
          'amount' => '0.00',
          'currency_code' => 'USD',
        ),
      ),
      'requested_fulfillment_service_id' => NULL,
      'source' => 'shopify',
      'title' => 'Standard',
      'tax_lines' => 
      array (
      ),
      'discount_allocations' => 
      array (
      ),
    ),
  ),
);

$data = $json;



return $data;
}


    
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}