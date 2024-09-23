<?php

namespace App\Http\Controllers;

use App\Models\InventoryPrice;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use DB;
use App\Models\Vendor;
use App\Models\VendorPercentage;

class InventoryPriceController extends Controller
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
        //$model = Orders::query();
        $shopify_syned = DB::table('shopify_product_details')->select('sku')->get()->pluck('sku')->toArray();
        //   $model = new InventoryPrice();
        $where =[];


        // $model = $model->pluck('orders');
        $search =false;
        if (isset($request->search['value']) && $request->search['value'] != ''){
          $where[] =  'sku LIKE "%'.$request->search['value'].'%"';
          $search = true;
        }
         if (isset($request->vendor) && $request->vendor != '') {
             $where[] =  'vendor = '.$request->vendor;
          }

          if (isset($request->found) && $request->found != '') {
        //   $model->where('found',$request->found);
        $where[] =  'found = '.$request->found;
        }

        if (count($where) > 0){
            $where = implode(' AND ',$where);
        }
        $where .= " ORDER BY id DESC ";
        $where .= " LIMIT ".$request->start.', '.$request->length;
        $sql='';
           if($request->mapped==0){
            $sql = "SELECT * FROM `inventory_prices` WHERE mapped>0 AND ".$where;
          }elseif($request->mapped==1){
            $sql = "SELECT * FROM `inventory_prices` WHERE mapped=0 AND ".$where;
          }else{
            $sql='SELECT * FROM `inventory_prices` WHERE '.$where;
          }

          $model = DB::select(DB::raw($sql));

        // dd($model);
        // if (isset($request->email_verify) && $request->email_verify != '') {
        //   if ($request->email_verify == 'Verifyed') {
        //     $model->whereNotNull('email_verified_at');
        //   } else {
        //     $model->whereNull('email_verified_at');
        //   }
        // }


        // $model = $model->orderBy('id','desc')->get();

    $_GET['id']=1;

        $res = DataTables::of($model)
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

          ->editColumn('vendor', function ($row) {

     if($row->vendor == 1 ){
          return 'TRQ';
        }else{
            return  'LKQ';
        }

          })

           ->editColumn('vendor_id', function ($row) {
    return $row->vendor;


          })

          ->addColumn('total', function ($row) {
            return number_format($row->cost+$row->fee+$row->commission+$row->shipping+$row->profit,2);
         })
          ->addColumn('eqty', function ($row) {
               if($row->qty >= 5){

                 return $row->max_qty;

               }else if($row->qty <=  $row->max_qty-1){
                   return $row->qty;
               }

         })
         ->addColumn('mapped', function ($row) {
          return $row->mapped;
       })
           ->addColumn('gross', function ($row) {
            return number_format($row->cost+$row->fee+$row->commission+$row->shipping,2);
         })

          ->addColumn('action', function($row)  {
            return view('pages.inventoryprice.action',['row'=>$row]);
          })
          ->addColumn('checkbox',  function ($row) {
            return ' <div class="form-check-sm form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
      </div>';
          })
          ->rawColumns(['checkbox', 'action', 'status', 'amountt', 'date','part_no','shopify_syned'])
          ->skipPaging()
          ->make(true);


          $total = InventoryPrice::count();

          $content = json_decode($res->getcontent());
          $content->recordsTotal = $total;
          if ($search){
           $content->recordsFiltered = count($model);
          }else {
          $content->recordsFiltered = $total;
          }
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
       $percentage = VendorPercentage::where('vendor','trq')->first();
       $percentage = $percentage->percentage;
        return view('pages.inventoryprice.main',['users'=>$users, 'vendor'=>$vendor,'percentage'=>$percentage]);
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

  }
            fclose($file);



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
