<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use DB;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
      public function datatableapi(Request $request)
      {
  
    
        //$model = Orders::query();
    
        
          $model = Tracking::orderBy('id','desc')->get();
       
    
        // $model = $model->pluck('orders');
        // dd($model);
         if (isset($request->vendor) && $request->vendor != '') {
          $model = InventoryPrice::where('vendor',$request->vendor)->orderBy('id','desc')->get();
        }
        // if (isset($request->email_verify) && $request->email_verify != '') {
        //   if ($request->email_verify == 'Verifyed') {
        //     $model->whereNotNull('email_verified_at');
        //   } else {
        //     $model->whereNull('email_verified_at');
        //   }
        // }
    
    $_GET['id']=1;
    
        return DataTables::of($model)
          ->setRowId(function ($data) {
            return '';
          })
          // ->setRowClass(function ($user) {

          ->setRowData([

          ])
   
 ->editColumn('part_no', function ($row) {
     if($row->found == 0 ){
          return  $row->part_no.'<i aria-hidden="true" style="color: red;display:contents" data-toggle="tooltip" data-theme="dark" title="No Record Found" class="fa fa-times-circle page_speed_256570326"></i>'; 
        }else{
            return  $row->part_no; 
        }
     
 
             
          })
          ->editColumn('created_at', function ($row) {
             return Carbon::parse($row->created_at)->diffForHumans();  
          })

          ->addColumn('total', function ($row) {
            return $row->cost+$row->fee+$row->commission+$row->shipping+$row->profit;  
         })
          ->addColumn('eqty', function ($row) {
               if($row->qty >= 5){
                   
                 return $row->max_qty;  
                 
               }else if($row->qty <=  $row->max_qty-1){
                   return $row->qty; 
               }
             
         })
    
           ->addColumn('gross', function ($row) {
            return $row->cost+$row->fee+$row->commission+$row->shipping;  
         })
     
          ->addColumn('action', function($row)  {
            return view('pages.inventoryprice.action',['row'=>$row]);
          })
          ->addColumn('checkbox',  function ($row) {
            return ' <div class="form-check form-check-sm form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
      </div>';
          })
          ->rawColumns(['checkbox', 'action', 'status', 'amountt', 'date','part_no'])
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
     
        return view('pages.tracking.main',['users'=>$users]);
      }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        
        $coupon = InventoryPrice::create([
            'sku'         => $request->sku,
            'part_no'          => $request->part_no,
            'cost'         => $request->cost,
            'qty'         => $request->qty,
            'fee'          => $request->fee,
            'commission'   => $request->commission,
            'shipping'     => $request->shipping,
            'profit'       => $request->profit, 
       ]);
         DB::statement('UPDATE inventory_prices 
        RIGHT JOIN trq ON inventory_prices.part_no = trq.PartNumber
        SET inventory_prices.found = 1,inventory_prices.cost = trq.price');
        
       if (isset($coupon->id)) {
         return response()->json(['message'=>'Niches Successfully Added'],200);
       } else {
         return response()->json(['message'=>'Unable To Process Request'],500);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventoryPrice  $inventoryPrice
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryPrice $inventoryPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryPrice  $inventoryPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryPrice $inventoryPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryPrice  $inventoryPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventoryPrice $inventoryPrice, $id)
    {
        $coupon = InventoryPrice::find($id);

        $coupon->sku  = $request->sku;
        $coupon->part_no  = $request->part_no;
        $coupon->cost  = $request->cost;
        $coupon->qty  = $request->qty;
        $coupon->fee  = $request->fee;
        $coupon->commission  = $request->commission;
        $coupon->shipping  = $request->shipping;
        $coupon->profit  = $request->profit;
        $coupon->save();
        
        DB::statement('UPDATE inventory_prices 
        RIGHT JOIN trq ON inventory_prices.part_no = trq.PartNumber
        SET inventory_prices.found = 1,inventory_prices.cost = trq.price');

   if (isset($coupon->id)) {
     return response()->json(['message'=>'Niche Successfully Updated'],200);
   } else {
     return response()->json(['message'=>'Unable To Process Request'],500);
   }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryPrice  $inventoryPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(InventoryPrice $inventoryPrice)
    {
        //
    }
    
    
    
    
    public function uploadcsv(Request $request){
       $request->validate([
            'file' => 'required|mimes:csv',
        ]);
  
        $fileName = time().'.'.$request->file->extension();  


        if (!in_array(explode('.',$request->file->getClientOriginalName())[count(explode('.',$request->file->getClientOriginalName()))-1], ['csv'])){
          return response()->json(['data'=>[],500]); 
        }
   
        $request->file->move(public_path('uploads'), $fileName);  
        
        
        
        $file = fopen(public_path('uploads').'/'.$fileName,"r");
                $data['fields'] = fgetcsv($file);
                $data['file_name'] = $fileName;
            fclose($file);
        
       return response()->json(['data'=>$data,200]); 
        
        
    }
    
    
    
    public function insertcsv(Request $request ){
       
        
        
        $file = fopen(public_path('uploads').'/'.$request->file_name,"r");
         fgetcsv($file);
         
         
             while(! feof($file))
  {
  $data = fgetcsv($file);
  
if ($request->sku == -1) { $sku = ''; } elseif (isset($data[$request->sku])) { $sku = $data[$request->sku]; } else { $sku = ''; }
if ($request->part_no == -1) { $part_no = ''; } elseif (isset($data[$request->part_no])) { $part_no = $data[$request->part_no]; } else { $part_no = ''; }
if ($request->cost == -1) { $cost = 0; } elseif (isset($data[$request->cost])) { $cost = $data[$request->cost]; } else { $cost = 0; }
if ($request->qty == -1) { $qty = 0; } elseif (isset($data[$request->qty])) { $qty = $data[$request->qty]; } else { $qty = 0; }
if ($request->fee == -1) { $fee = 0; } elseif (isset($data[$request->fee])) { $fee = $data[$request->fee]; } else { $fee = 0; }
if ($request->commission == -1) { $commission = 0; } elseif (isset($data[$request->commission])) { $commission = $data[$request->commission]; } else { $commission = 0; }
if ($request->shipping == -1) { $shipping = 0; } elseif (isset($data[$request->shipping])) { $shipping = $data[$request->shipping]; } else { $shipping = 0; }
if ($request->profit == -1) { $profit = 0; } elseif  (isset($data[$request->profit])) { $profit = $data[$request->profit]; } else { $profit = 0; }
  
  InventoryPrice::updateOrCreate(
        [
           'sku'   => $sku,
        ],
        [
           'part_no'     => $part_no,
           'cost'        => $cost,
           'qty'         => $qty,
           'fee'         => $fee,
           'commission'  => $commission,
           'shipping'    => $shipping,
           'profit'      => $profit
        ]
);
  
  
  
    
  
//   if (InventoryPrice::where('sku',$sku)->count() > 0){
//       $entry = InventoryPrice::where('sku',$sku)->first();
//       $entry->update([
//             'part_no'      => $part_no,
//             'cost'         => $cost,
//              'qty'         => $qty,
//             'fee'          => $fee,
//             'commission'   => $commission,
//             'shipping'     => $shipping,
//             'profit'       => $profit, 
//       ]);
      
//   } 
  
//   else {
      
//       InventoryPrice::create([
//             'sku'          => $sku,
//             'part_no'      => $part_no,
//             'cost'         => $cost,
//              'qty'         => $qty,
//             'fee'          => $fee,
//             'commission'   => $commission,
//             'shipping'     => $shipping,
//             'profit'       => $profit, 
//       ]);
      
//   }
  
  
  
  }
            fclose($file);
            
DB::statement('UPDATE inventory_prices 
RIGHT JOIN trq ON inventory_prices.part_no = trq.PartNumber
SET inventory_prices.found = 1,inventory_prices.cost = trq.price');
            
    
        
        
        return response()->json(['message'=>'Record Inserted Succesfully!'],200);
        
        
    }
    
    
    public function order_creating(Request $request)
    {
        $data = json_encode($request->all());
        InventoryPrice::create([
            'sku'          => $data,
            'part_no'      => '',
            'cost'         => 0,
             'qty'         => 0,
            'fee'          => 0,
            'commission'   => 0,
            'shipping'     => 0,
            'profit'       => 0, 
       ]);
        echo "testing";
        
        // mail("muhammadali87115@gmail.com","Order Create",print_r($request,true));
    }
    
    
    
    
    
}