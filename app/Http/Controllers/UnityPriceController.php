<?php
namespace App\Http\Controllers;

use App\Models\InventoryPrice;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use DB;
use App\Models\Vendor;
use App\Models\Unity;

class UnityPriceController extends Controller
{
    
    function __construct()
    {
       ini_set('max_execution_time', -1);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bulkdelete(Request $request){
        if (isset($request->list) && $request->list != '') {
          $list = explode(',', $request->list);
    
          InventoryPrice::whereIn('id', $list)->delete();
        }
      }
    
    
         public function datatableapi(Request $request)
      {
    
        $where = '';

        $search = false;
        
        // Check if there is a search query
        if (isset($request->search['value']) && $request->search['value'] != '') {
            $where .= ' WHERE part_number LIKE "%' . $request->search['value'] . '%"';
            $search = true;
        }
        
        $where .= " ORDER BY updated_at DESC ";
        
        // Pagination parameters
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage + 1; // Calculate the current page
        
        $offset = ($page - 1) * $perPage;
        
        $sql = 'SELECT * FROM `unity` ' . $where . ' LIMIT ' . $perPage . ' OFFSET ' . $offset;
        
        $model = DB::select(DB::raw($sql));
        
        $res = DataTables::of($model)
            ->editColumn('part_number', function ($row) {
                return $row->part_number;
            })
            ->editColumn('qoc', function ($row) {
                return $row->qoc;
            })
            ->editColumn('cost', function ($row) {
                return $row->cost;
            })
            ->rawColumns(['part_number', 'qoc', 'cost'])
            ->make(true);
        
        // Get total records count
        $total = Unity::count();
        
        // Create the response content
        $content = json_decode($res->getcontent());
        $content->recordsTotal = $total;
        
        // Set recordsFiltered based on whether there is a search query or not
        $content->recordsFiltered = $search ? count($model) : $total;
        
        return response()->json($content);
        
      }
      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
        $users = array();
        $vendor = Vendor::get();
        //dd($vendor);
        return view('pages.unityprice.main',['users'=>$users, 'vendor'=>$vendor]);
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
      $request->pricemasterrule = ($request->pricemasterrule == NULL) ? 0 : 1;
      
        
        $coupon = InventoryPrice::updateOrCreate(
        [
           'sku'   => $request->sku,
        ],
        [
            'sku'         => $request->sku,
            'part_no'       => $request->part_no,
            'cost'         => $request->cost,
            'qty'         => $request->qty,
            'fee'          => $request->fee,
            'commission'   => $request->commission,
            'shipping'     => $request->shipping,
            'profit'       => $request->profit,
            'vendor'       => $request->vendor,
            'pricemasterrule' => $request->pricemasterrule
       ]);
        //  DB::statement('UPDATE inventory_prices 
        // RIGHT JOIN trq ON inventory_prices.part_no = trq.PartNumber
        // SET inventory_prices.found = 1,inventory_prices.cost = trq.price');
        
        
       DB::statement("UPDATE inventory_prices SET found = 0");

DB::statement("UPDATE inventory_prices 
INNER JOIN trq ON inventory_prices.part_no = trq.PartNumber
SET inventory_prices.cost = trq.price ,inventory_prices.qty = trq.stock, inventory_prices.found = 1");


     $coupon = InventoryPrice::find($coupon->id);

    $coupon->update_master_price();

        
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
        
        $request->pricemasterrule = ($request->pricemasterrule == NULL) ? 0 : 1;
        $coupon = InventoryPrice::find($id);

        $coupon->sku  = $request->sku;
        $coupon->part_no  = $request->part_no;
        $coupon->cost  = $request->cost;
        $coupon->qty  = $request->qty;
        $coupon->fee  = $request->fee;
        $coupon->commission  = $request->commission;
        $coupon->shipping  = $request->shipping;
        $coupon->profit  = $request->profit;
        $coupon->vendor  = $request->vendor;
        $coupon->pricemasterrule = $request->pricemasterrule;
        $coupon->save();
        
        // DB::statement('UPDATE inventory_prices 
        // RIGHT JOIN trq ON inventory_prices.part_no = trq.PartNumber
        // SET inventory_prices.found = 1,inventory_prices.cost = trq.price');
        
        DB::statement("UPDATE inventory_prices SET found = 0");

DB::statement("UPDATE inventory_prices 
INNER JOIN trq ON inventory_prices.part_no = trq.PartNumber
SET inventory_prices.cost = trq.price ,inventory_prices.qty = trq.stock, inventory_prices.found = 1");

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

        if (!in_array(explode('.',$request->file->getClientOriginalName())[count(explode('.',$request->file->getClientOriginalName()))-1], ['csv'])){
          return response()->json(['data'=>[],500]); 
        }
  
        $fileName = time().'.'.$request->file->extension();  
   
        $request->file->move(public_path('uploads'), $fileName);  
        
        
        
        $file = fopen(public_path('uploads').'/'.$fileName,"r");
                $data['fields'] = fgetcsv($file);
                $data['file_name'] = $fileName;
            fclose($file);
        
       return response()->json(['data'=>$data,200]); 
        
        
    }
    
    
    
    public function insertcsv(Request $request ){
       return response()->json(['message'=>'Unable To Process Request'],500);
        $request->pricemasterrule = ($request->pricemasterrule == NULL) ? 0 : 1;
        
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
           'profit'      => $profit,
           'pricemasterrule'    =>  $request->pricemasterrule,
           'vendor'      => $request->vendor
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
            
// DB::statement('UPDATE inventory_prices 
// RIGHT JOIN trq ON inventory_prices.part_no = trq.PartNumber
// SET inventory_prices.found = 1,inventory_prices.cost = trq.price');


DB::statement("UPDATE inventory_prices SET found = 0");

DB::statement("UPDATE inventory_prices 
INNER JOIN trq ON inventory_prices.part_no = trq.PartNumber
SET inventory_prices.cost = trq.price ,inventory_prices.qty = trq.stock, inventory_prices.found = 1");
            
    
        
        
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
