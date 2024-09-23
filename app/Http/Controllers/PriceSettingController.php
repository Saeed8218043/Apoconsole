<?php

namespace App\Http\Controllers;

use App\Models\InventoryPrice;
use App\Models\PriceSetting;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use DB;

class PriceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */

          public function bulkdelete(Request $request){
        if (isset($request->list) && $request->list != '') {
          $list = explode(',', $request->list);

          PriceSetting::whereIn('id', $list)->delete();
        }
      }

            public function datatableapi(Request $request)
      {

          $model = PriceSetting::orderBy('id','desc')->get();


         if (isset($request->vendor) && $request->vendor != '') {
          $model = InventoryPrice::where('vendor',$request->vendor)->orderBy('id','desc')->get();
        }

    $_GET['id']=1;

        return DataTables::of($model)
          ->setRowId(function ($data) {
            return '';
          })

          ->setRowData([

          ])

 ->editColumn('vendor_id', function ($row) {
    if($row->vendor_name ==="globalby"){
        return "globalbuy";
    }else{
        return $row->vendor_name;
    }
          })

          ->editColumn('vendor', function ($row) {
     return $row->vendor_id;

          })

          ->editColumn('fee', function ($row) {
                 return $row->fee."%";
          })

         ->editColumn('commission', function ($row) {
                 return $row->commission."%";
          })

          ->editColumn('shipping', function ($row) {
                 return $row->shipping."%";
          })
          ->editColumn('price_percentage', function ($row) {
                 return $row->price_percentage."%";
          })

          ->editColumn('profit', function ($row) {
                 return $row->profit."%";
          })

          ->editColumn('created_at', function ($row) {
             return Carbon::parse($row->created_at)->diffForHumans();
          })
    ->addColumn('action', function($row)  {
            return view('pages.pricesetting.action',['row'=>$row]);
          })

          ->addColumn('checkbox',  function ($row) {
            return ' <div class="form-check form-check-sm form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
      </div>';
          })

          ->rawColumns(['checkbox', 'action'])
          ->make(true);
      }


      public function index()
      {
        $users = array();

        return view('pages.pricesetting.main',['users'=>$users]);
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



        $price = PriceSetting::where('id',$request->vendor_id);

          $price -> update([
        'fee'          => $request->fee,
        'commission'   => $request->commission,
        'shipping'     => $request->shipping,
        'profit'       => $request->profit,
        'price_percentage'       => $request->price_percentage,
        'quantity'     => $request->max_qty
    ]);

    DB::select(DB::raw("UPDATE `inventory_prices` SET `fee`= (`cost` * ".($request->fee/100).") ,`commission`= (`cost` * ".($request->commission/100).") ,`shipping`= (`cost` * ".($request->shipping/100).") ,`profit`= (`cost` * ".($request->profit/100).")  WHERE vendor=".$request->vendor_id." AND pricemasterrule=1"));

    //   $all = InventoryPrice::where('vendor',$request->vendor_id)->where('found',1)->get();

    //     foreach($all as $inventory){
    //           $inventory->update_master_price();
    //     }



        return response()->json(['message'=>'Prices Applied Successfully!',200]);

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









}
