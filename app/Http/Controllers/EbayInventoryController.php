<?php

namespace App\Http\Controllers;

use App\Models\Pf;
use App\Models\InventoryPrice;
use App\Models\PfInventory;
use App\Models\PfKitInventory;
use App\Models\hybridInventoryItem;
use App\Models\hybridInventory;
use App\Models\PriceSetting;
use App\Models\VendorPercentage;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use DB;
use trqVendor;
use pfVendor;
include app_path('Http/Controllers/TrqTrait.php');



class EbayInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bulkdelete(Request $request){
        if (isset($request->list) && $request->list != '') {
          $list = explode(',', $request->list);

          hybridInventoryItem::whereIn('id', $list)->delete();
          hybridInventory::whereIn('item_no', $list)->delete();
        }
      }

      public function datatableapi(Request $request)
      {
        $search = false;
        $where = [];
        // Handle search filter
        if ($request->search['value']) {
            $where[] = 'hii.item LIKE "%'.$request->search['value'].'%"';
            $search = true;
        }
        if ($request->status!=null) {
            if($request->status ==='link'){
                $where[] = 'hi.link = ""';
            }else{
                $where[] = 'hi.status = '.$request->status.' AND hi.link!=""';
            }
        }

        if (count($where) > 0) {
            $whereClause = ' AND '.implode(' AND ', $where);
        } else {
            $whereClause = '';
        }
        DB::statement("
        UPDATE `hybrid_inventory` AS hi
        JOIN `vendor_percentage` AS vp ON vp.vendor = 'hybrid'
        SET
            hi.walmart_tax = hi.walmart_price * ((100 + vp.walmart_percentage) / 100),
            hi.pf_tax = hi.pf_price * ((100 + vp.pf_percentage) / 100)");

    DB::statement("
        UPDATE hybrid_inventory
            INNER JOIN pf ON
                (pf.SKU = hybrid_inventory.part_no COLLATE utf8mb4_general_ci) OR
                (pf.PARTSLINK = hybrid_inventory.part_no COLLATE utf8mb4_general_ci) OR
                (pf.OEM_NUMBER = hybrid_inventory.part_no COLLATE utf8mb4_general_ci)
            SET
                hybrid_inventory.pf_price = pf.PRICE,
                hybrid_inventory.pf_qty = pf.QTY;");
        $sql = "SELECT
                    hi.item_no,
                    hi.created_at,
                    hi.status,
                    hii.item as ksku,
                    hii.id as kid,
                    COALESCE(SUM(hi.percentage_original_price), 0) as koriginal_price,
                    COALESCE(SUM(hi.walmart_qty), 0) as kwalmart_qty,
                    COALESCE(SUM(hi.walmart_price), 0) as kwalmart_price,

                    COALESCE(SUM(hi.walmart_tax), 0) as kwalmart_tax,
                    COALESCE(SUM(hi.pf_tax), 0) as kpf_tax,

                    COALESCE(SUM(hi.pf_price), 0) as kpf_price,
                    COALESCE(SUM(hi.pf_qty), 0) as kpf_qty,
                    COALESCE(MIN(hi.profit), 0) as kprofit
                FROM
                    hybrid_inventory_items hii
                LEFT JOIN
                    hybrid_inventory hi
                ON
                    hi.item_no = hii.id
                WHERE
                    hi.item_no IS NOT NULL" . $whereClause . "
                GROUP BY
                    hi.item_no,
                    hii.item,
                    hii.id
                ORDER BY
                    hi.item_no DESC
                LIMIT ".$request->start.', '.$request->length;



$model = DB::select( DB::raw($sql) );
$filteredCountSql = "SELECT COUNT(DISTINCT hii.id) as count
FROM hybrid_inventory_items hii
LEFT JOIN hybrid_inventory hi ON hi.item_no = hii.id
WHERE hi.item_no IS NOT NULL".$whereClause;

$filteredCount = DB::select(DB::raw($filteredCountSql))[0]->count;

    $total = hybridInventoryItem::count();

    $_GET['id']=1;

        $res = DataTables::of($model)
          ->setRowId(function ($data) {
            return '';
          })
          // ->setRowClass(function ($user) {

          ->setRowData([

          ])



          ->editColumn('created_at', function ($row) {
             return Carbon::parse($row->created_at)->diffForHumans();
          })



        ->addColumn('detail', function ($row) {
            $res = '<div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5 ">
                    <thead>
                        <tr>
                            <th>Part Number</th>
                            <th style="width: 400px;">Link</th>
                            <th>walmart cost</th>
                            <th>walmart+Tax</th>
                            <th>walmart qty</th>
                            <th>PF cost</th>
                            <th>PF+Tax</th>
                            <th>Pf qty</th>
                            <th>Status</th>
                        </tr>
                    </thead><tbody>';
            $kcost = 0;
            $kqty = 0;
            $detail_inventory = DB::select(DB::raw("SELECT * FROM `hybrid_inventory` WHERE item_no=" . $row->kid));
            $check=false;
            foreach ($detail_inventory as $rec) {
                $part = $rec->part_no;
                $pf_inv = DB::table('pf')->where('SKU', 'LIKE', "%$part")
                    ->orWhere('PARTSLINK', 'LIKE', "%$part")
                    ->orWhere('OEM_NUMBER', 'LIKE', "%$part")
                    ->first();

                    $walmart_price =0;
                    if($rec->walmart_price <= 35){
                        $walmart_price = $rec->walmart_tax+7;
                        hybridInventory::where('id', $rec->id)
                        ->update(['walmart_tax' => $walmart_price]);
                    }else{
                        $walmart_price =$rec->walmart_tax;
                    }
                $currentCost = $rec->walmart_qty > 0 && $walmart_price < ($rec->pf_tax ?? 0)
                    ? $walmart_price
                    : ($rec->pf_tax ?? 0);
                $zero_check =VendorPercentage::where('vendor','hybrid')->first();
                $currentQty = $rec->walmart_qty > 0 && $walmart_price < ($rec->pf_tax ?? 0)
                    ? $rec->walmart_qty
                    : ($rec->pf_qty ?? 0);
                if($currentQty<$zero_check->zero_qty){
                    $check =true;
                }
                $kcost += $currentCost;
                $kqty += $currentQty;
                $statusColor= [
                    0 => 'badge badge-light',
                    1 => 'badge badge-danger',
                    2 => 'badge badge-dark',
                    3 => 'badge badge-warning',
                    4 => 'badge badge-secondary',
                    200 => 'badge badge-success',
                ];
                $color = $statusColor[$rec->status];
                $status = $rec->walmart_qty>0 ?'In stock':'Out of stock';
                $statusDescriptions = [
                    0 => 'Pending',
                    1 => 'Out of stock',
                    2 => 'Robot error',
                    3 => 'Invalid link',
                    4 => 'Part not exist',
                    200 => 'Working'
                ];

                $status = $rec->link===''? 'Link not exist':$statusDescriptions[$rec->status];
                $res .= '<tr>
                    <td>' . $rec->part_no . '</td>
                    <td><a href="' . $rec->link . '" target="_blank">' . $rec->link . '</a></td>
                    <td>' . round($rec->walmart_price??0,2) . '</td>
                    <td>' . round($walmart_price ?? 0, 2) . '</td>
                    <td>' . $rec->walmart_qty . '</td>
                    <td>' . round($pf_inv->PRICE ?? 0, 2) . '</td>
                    <td>' . round($rec->pf_tax ?? 0, 2) . '</td>
                    <td>' . ($pf_inv->QTY ?? 0) . '</td>
                    <td> <span class="'.$color.'">'.$status.'</span></td>
                </tr>';
            }
            $res .= '</tbody></table></div>';

            // Add kcost to the row data
            $row->kcost = number_format($kcost, 2);
            if($check===true){
                $row->kqty = 0;
            }else{
                $row->kqty = adjustKqtyHybrid($kqty);
            }
            return $res;
        })
        ->addColumn('kinventory', function ($row) {
            return $row->kqty;
        })
        ->editColumn('kcost', function ($row) {
            return $row->kcost ?? number_format(0, 2);
        })

        ->addColumn('sale_price', function ($row) {
            $vp = VendorPercentage::where('vendor','hybrid')->first();
            $sale_price = $row->kcost *((100+$vp->percentage)/100);
            $row->sale_price =$sale_price;
            return number_format($sale_price, 2);
        })

        ->editColumn('kprofit', function ($row) {
            $profit = $row->sale_price-$row->kcost;
            return number_format($profit, 2);
        })

        ->addColumn('gross', function ($row) {
            return $row->kcost ?? number_format(0, 2);
        })
        ->editColumn('status', function ($row) {
            $statusDescriptions = [
                0 => 'Pending',
                1 => 'Out of stock',
                2 => 'Robot error',
                3 => 'Invalid link',
                4 => 'Part not exist',
                200 => 'Working',
            ];

            $statusColor= [
                0 => 'badge badge-light',
                1 => 'badge badge-danger',
                2 => 'badge badge-dark',
                3 => 'badge badge-warning',
                4 => 'badge badge-secondary',
                200 => 'badge badge-success',
            ];
            // Fetch all parts for the current kit
            $detail_inventory = DB::select(DB::raw("SELECT * FROM `hybrid_inventory` WHERE item_no = " . $row->kid));

            $statusHtml = '';

            foreach ($detail_inventory as $rec) {
                $color = $statusColor[$rec->status];
               $status = $rec->link===''? 'Link not exist':$statusDescriptions[$rec->status];

                // Append each status to the HTML string
                $statusHtml .= '<span class="'.$color.'">'.$status.'</span> ';
            }

            // Return all statuses combined
            return $statusHtml;
        })

          ->addColumn('action', function($row)  {
            return view('pages.ebayInventory.action',['row'=>$row]);
          })


          ->addColumn('checkbox',  function ($row) {
            return ' <div class="form-check-sm form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" value="' . $row->kid . '" />
      </div>';
          })
          ->rawColumns(['checkbox', 'action', 'status', 'amountt', 'date','part_no','shopify_syned','detail'])
          ->skipPaging()
          ->make(true);

        //   $total = hybridInventoryItem::count();

          $content = json_decode($res->getcontent());
          $content->recordsTotal = $total;
          $content->recordsFiltered = $filteredCount;

          return response()->json($content);
      }





      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index(Request $request)
      {
        $users = array();
        $kit_inventory = hybridInventoryItem::count();
        $vendor = VendorPercentage::where('vendor','hybrid')->first();
        $percentage = $vendor->percentage;
        $walmart_percentage = $vendor->walmart_percentage;
        $pf_percentage = $vendor->pf_percentage;
        $zero_qty = $vendor->zero_qty;
        $latestKitInventory = hybridInventory::orderBy('id', 'asc')
        ->take(10)
        ->get()
        ->sortByDesc('updated_at')
        ->first();

        if ($latestKitInventory) {
            $latestUpdatedAtInPakistanTime = Carbon::parse($latestKitInventory->updated_at)
                ->setTimezone('Asia/Karachi')
                ->format('d-m-Y h:ia');
        }

        return view('pages.ebayInventory.main',['users'=>$users,'warehouse_name'=>$request->segment(1),'kit_inventory'=>$kit_inventory,'percentage'=>$percentage,'walmart_percentage'=>$walmart_percentage,'latestKitInventory'=>$latestUpdatedAtInPakistanTime,'pf_percentage'=>$pf_percentage,'zero_qty'=>$zero_qty]);
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

     public function get_hybrid_inventory(Request $request){
        $hybrid = hybridInventoryItem::find($request->id);
        return response()->json([
            'pf_kit'=>$hybrid->id,
            'pf_parts'=>$hybrid->kitInventory
        ]);
     }


     public function store(Request $request)
     {
         $warehouse_name = $request->warehouse_name;

         // Fetch the Walmart data for the given parts
         $walmart = HybridInventory::whereIn('part_no', $request->parts)->get()->keyBy('part_no');

          HybridInventory::where('item_no', $request->kit_id)->delete();

         foreach ($request->parts as $index => $part) {
             $part_data = DB::table('pf')
                 ->where('SKU', $part)
                 ->orWhere('PARTSLINK', $part)
                 ->orWhere('OEM_NUMBER', $part)
                 ->first();

                $status = $part_data===null?4:0;
             // Get the corresponding Walmart data for this part, if it exists
             $walmart_part = $walmart->get($part);

             $walmart_price = $walmart_part->walmart_price ?? 0;
             $walmart_qty = $walmart_part->walmart_qty ?? 0;

             HybridInventory::create([
                 'item_no' => $request->kit_id,
                 'part_no' => $part,
                 'status' => $status,
                 'walmart_price' => $walmart_price,
                 'walmart_qty' => $walmart_qty,
                 'pf_price' => $part_data->PRICE ?? 0,
                 'pf_qty' => $part_data->QTY ?? 0,
                 'link' => $request->links[$index]??''
             ]);
         }

         return response()->json(['message' => 'Inventory Successfully Updated'], 200);
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

        // $request->pricemasterrule = ($request->pricemasterrule == NULL) ? 0 : 1;
        // $coupon = InventoryPrice::find($id);

        // $coupon->sku  = $request->sku;
        // $coupon->part_no  = $request->part_no;
        // $coupon->cost  = $request->cost;
        // $coupon->qty  = $request->qty;
        // $coupon->fee  = $request->fee;
        // $coupon->commission  = $request->commission;
        // $coupon->shipping  = $request->shipping;
        // $coupon->profit  = $request->profit;
        // $coupon->vendor  = $request->vendor;
        // $coupon->pricemasterrule = $request->pricemasterrule;
        // $coupon->save();

        // DB::statement('UPDATE inventory_prices
        // RIGHT JOIN trq ON inventory_prices.part_no = trq.PartNumber
        // SET inventory_prices.found = 1,inventory_prices.cost = trq.price');

// DB::statement("UPDATE inventory_prices  SET inventory_prices.found = 0 WHERE inventory_prices.vendor = 2");


//          DB::statement("UPDATE inventory_prices
//  INNER JOIN pf ON inventory_prices.part_no = pf.PARTSLINK OR inventory_prices.part_no = pf.OEM_NUMBER OR inventory_prices.part_no = pf.SKU
//  SET inventory_prices.cost = pf.PRICE ,inventory_prices.qty = pf.QTY, inventory_prices.found = 1
//  WHERE inventory_prices.vendor = 2");

   if (1) {
     return response()->json(['message'=>'Inventory Successfully Updated'],200);
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
        $request->file->move(public_path('uploads/pf'), $fileName);



        $file = fopen(public_path('uploads').'/pf/'.$fileName,"r");
                $data['fields'] = fgetcsv($file);
                $data['file_name'] = $fileName;
            fclose($file);

       return response()->json(['data'=>$data,200]);


    }



    public function insertcsv(Request $request ){

        $file = fopen(public_path('uploads').'/pf/'.$request->file_name,"r");
         fgetcsv($file);
         $link = $request['link'];
         $part_no = $request['part_no'];
         $sku = $request['sku'];
         $kit_id = null;
while(! feof($file))
  {
      $data = fgetcsv($file);
      if ($data){
      $part_data = DB::table('pf')
                   ->where('SKU', $data[$part_no])
                   ->orWhere('PARTSLINK', $data[$part_no])
                   ->orWhere('OEM_NUMBER', $data[$part_no])
                   ->first();
      $status = $part_data===null?4:0;

          if ($data[0] == '' && !$kit_id){
              return response()->json(['message'=>'Error Invalid Kit!','type'=>'error'],200);
          }

          if ($data[1] == ''){
              return response()->json(['message'=>'Part Error!','type'=>'error'],200);
          }


          if ($data[0] != ''){
              $kit_id = hybridInventoryItem::create(

                    [
                        'item'   => $data[$sku],
                    ]
                );
          }


             $pf_prod = hybridInventory::create(

                 [
                    'part_no'   => $data[$part_no],
                    'item_no' => $kit_id->id,
                    'link' => $data[$link],
                    'status' => $status,
                    'walmart_price'=>0,
                    'walmart_qty' => 0,
                    'pf_price' => 0,
                    'pf_qty' => 0,
                ]
            );
    }

  }
            fclose($file);



        // DB::statement('UPDATE pf_inventory SET found = 0');

        // DB::statement("UPDATE pf_inventory
        // INNER JOIN pf ON pf.SKU = pf_inventory.part_no
        // SET pf_inventory.cost = pf.PRICE, pf_inventory.qty = pf.QTY, pf_inventory.found = 1;");

        // DB::statement("UPDATE pf_inventory
        // INNER JOIN pf ON pf.OEM_NUMBER = pf_inventory.part_no
        // SET pf_inventory.cost = pf.PRICE, pf_inventory.qty = pf.QTY, pf_inventory.found = 1;");

        // DB::statement("UPDATE pf_inventory
        // INNER JOIN pf ON pf.PARTSLINK = pf_inventory.part_no
        // SET pf_inventory.cost = pf.PRICE, pf_inventory.qty = pf.QTY, pf_inventory.found = 1;");


        // DB::statement("UPDATE pf_kit_inventory
        // SET pf_kit_inventory.price = (SELECT SUM(pf_inventory.cost + pf_inventory.fee + pf_inventory.shipping + pf_inventory.commission + pf_inventory.profit) FROM pf_inventory WHERE kit_id=pf_kit_inventory.id),
        // pf_kit_inventory.inventory = (SELECT SUM(pf_inventory.qty) FROM pf_inventory WHERE kit_id=pf_kit_inventory.id)");


        // DB::statement("UPDATE pf_kit_inventory
        // LEFT JOIN pf_inventory ON pf_inventory.kit_id = pf_kit_inventory.id
        // SET pf_kit_inventory.inventory = 0
        // WHERE pf_inventory.qty = 0");


        //    // Fetch all unique vendor names
        //    $vendors = PriceSetting::distinct()->pluck('vendor_name');

        //    foreach ($vendors as $vendorName) {
        //        // Fetch the price settings for the current vendor
        //        $priceSettings = PriceSetting::where('vendor_name', $vendorName)->get();

        //        foreach ($priceSettings as $setting) {
        //            $costAdjustment = 1; // Default no adjustment
        //            $percentage = (100 - $setting->profit) / 100;
        //            $costAdjustment = "1";
        //            if($setting['price_percentage']!=0){
        //                $costAdjustment = (100 + $setting['price_percentage'])/100;
        //            }

        //            // Update `inventory_prices`
        //            InventoryPrice::where('pricemasterrule', 1)
        //                ->update([
        //                    'original_price' => DB::raw('cost * ' . $costAdjustment),
        //                    'fee' => DB::raw('cost * ' . ($setting->fee / 100)),
        //                    'commission' => DB::raw('cost * ' . ($setting->commission / 100)),
        //                    'shipping' => DB::raw('cost * ' . ($setting->shipping / 100)),
        //                    'profit' => DB::raw('(original_price / '.$percentage .') - (original_price)'),
        //                ]);

        //            // Update `pf_inventory`
        //            PfInventory::where('pricemasterrule', 1)
        //                ->where('warehouse_name', $vendorName)
        //                ->update([
        //                    'original_price' => DB::raw('cost * ' . $costAdjustment),
        //                    'fee' => DB::raw('cost * ' . ($setting->fee / 100)),
        //                    'commission' => DB::raw('cost * ' . ($setting->commission / 100)),
        //                    'shipping' => DB::raw('cost * ' . ($setting->shipping / 100)),
        //                    'profit' => DB::raw('(original_price / '.$percentage .') - (original_price)'),
        //                ]);
        //        }
        //    }





        return response()->json(['message'=>'Record Inserted Succesfully!','type'=>"success"],200);


    }


    public function order_creating(Request $request)
    {
    //     $data = json_encode($request->all());
    //     InventoryPrice::create([
    //         'sku'          => $data,
    //         'part_no'      => '',
    //         'cost'         => 0,
    //          'qty'         => 0,
    //         'fee'          => 0,
    //         'commission'   => 0,
    //         'shipping'     => 0,
    //         'profit'       => 0,
    //   ]);
    //     echo "testing";

        // mail("muhammadali87115@gmail.com","Order Create",print_r($request,true));
    }





    public function vendor_csv(Request $request){
         if (file_exists('/home/apoconsole/app.apoconsole.com/public/pfvendorcsv/pf.csv')){
             unlink('/home/apoconsole/app.apoconsole.com/public/pfvendorcsv/pf.csv');
         }
        $request->validate([
            'file' => 'required|mimes:csv',
        ]);

        $fileName = 'pf.'.$request->file->extension();

        if (!in_array(explode('.',$request->file->getClientOriginalName())[count(explode('.',$request->file->getClientOriginalName()))-1], ['csv'])){
            return response()->json(['data'=>[],500]);
          }

        $request->file->move(public_path('pfvendorcsv'), $fileName);


        $servername = "localhost";
$username  = 'apoconsole_main';
 $database  = 'apoconsole_main';
$password   = 'iv$5iJ6lLoy]qOrU(}=gaStE';

// Create connection
$conn = new \mysqli($servername, $username, $password,$database);



        DB::statement("TRUNCATE pf");

        // dd("LOAD DATA local INFILE '/home/autoqete/public_html/miniapp/public/pfvendorcsv/pf.csv' INTO TABLE pf FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '\"' IGNORE 1 LINES");

         $conn->query("LOAD DATA local INFILE '/home/apoconsole/app.apoconsole.com/public/pfvendorcsv/pf.csv' INTO TABLE pf FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '' LINES TERMINATED BY '\n' IGNORE 1 LINES (@col1, @col2, @col3, @col4, @col5)
         set SKU = @col1, PARTSLINK = @col2, OEM_NUMBER=@col3, PRICE=@col4, QTY=@col5 ");


         DB::statement("UPDATE inventory_prices  SET inventory_prices.found = 0 WHERE inventory_prices.vendor = 2");


         DB::statement("UPDATE inventory_prices
 INNER JOIN pf ON inventory_prices.part_no = pf.PARTSLINK OR inventory_prices.part_no = pf.OEM_NUMBER OR inventory_prices.part_no = pf.SKU
 SET inventory_prices.cost = pf.PRICE ,inventory_prices.qty = pf.QTY, inventory_prices.found = 1
 WHERE inventory_prices.vendor = 2");

 return response()->json(['message'=>'Prices Updated Successfully']);



    }




























    public function pf_order_setting(){
      return view('pages.pf.setting.main');
    }



     public function pf_order_setting_save(Request $request){
         $request->validate([
            'pf_order_recipient_email' => 'required',
            'pf_order_smtp_host' => 'required',
            'pf_order_smtp_email' => 'required',
            'pf_order_smtp_password' => 'required',
            'pf_order_smtp_port' => 'required',
            'pf_order_smtp_type' => 'required',
             ]);


             \DB::table('settings')->where('key','LIKE','%pf_order_recipient_email%')->delete();

            $x=0;
        foreach($request->pf_order_recipient_email as $rec) {
          \App\Models\Setting::set('pf_order_recipient_email_'.$x++,$rec);
        }





        \App\Models\Setting::set('pf_order_smtp_host',$request->pf_order_smtp_host);
        \App\Models\Setting::set('pf_order_smtp_email',$request->pf_order_smtp_email);
        \App\Models\Setting::set('pf_order_smtp_password',$request->pf_order_smtp_password);
        \App\Models\Setting::set('pf_order_smtp_port',$request->pf_order_smtp_port);
        \App\Models\Setting::set('pf_order_smtp_type',$request->pf_order_smtp_type);





      return redirect()->back()->with(['success'=>'Setting Saved!']);
    }





    public function pf_calculator(Request $request){
         $dir = scandir("./cron/pf/");

        foreach($dir as $files){
            if (explode('.',$files)[count(explode('.',$files))-1] == 'zip'){
                $pf_invertory_file = $files;
            }
        }

        if ($pf_invertory_file){
            chdir("./cron/pf/");
            $file =  'zip://'.$pf_invertory_file.'#'.explode('.',$pf_invertory_file)[0].'.txt';
        }
        // dd(request()->all());
        // exit();

        $fp = fopen($file, 'r');
        if (!$fp) {
            exit("Vendor File Error\n");
        }
        $data = fgetcsv($fp, 0, "\t");
        // dd($data);
        $csv =[];
        while (($data = fgetcsv($fp, 0, "\t")) !== false) {
            $csv[] = $data;
        }

        $data = request()->all();

        $price=0;
        $shipping=0;
        $handling=0;
        $stock=0;

        foreach($data as $row){
            echo '<tr>';
            $pf=[];
            if ($row != null){
                $pf = $this->get_pf_csv($row,$csv);
            }

        if (isset($pf[0])) { $pf[0] = $pf[0]; } else { $pf[0]=''; }
        if (isset($pf[1])) { $pf[1] = $pf[1]; $price += $pf[1];  } else { $pf[1]=''; }
        if (isset($pf[2])) { $pf[2] = $pf[2]; if ($pf[2] > $shipping){ $shipping = $pf[2]; }  } else { $pf[2]=''; }
        if (isset($pf[3])) { $pf[3] = $pf[3]; $handling += $pf[3];  } else { $pf[3]=''; }
        if (isset($pf[4])) { $pf[4] = $pf[4]; $stock += $pf[4];  } else { $pf[4]=''; }
        echo '<td><input type="text" onpaste="pastexls(event)" value="'.($row).'" onchange="calculate_pf()" class="form-control" placeholder="Type Sku..." style="padding: 2px;max-width: 112px;"></td>';
        echo '<td>'.($pf[1]).'</td>';
        echo '<td>'.($pf[2]).'</td>';
        echo '<td>'.($pf[3]).'</td>';
        echo '<td>'.($pf[4]).'</td>';
        echo '</tr>';
        }

        $es = 0;

        $ts = $price+$shipping+$handling;

        if ($ts > 0){
            $es = $ts*1.13;
            $es = $es*1.13;
        }


        echo '<tr>';
        echo '<td>Estimated Cost: '.($price+$shipping+$handling).' <br>Estimated Price: '.(number_format($es,2)).'</td>';
        echo '<td>Total: '.($price).' </td>';
        echo '<td>Max: '.($shipping).'</td>';
        echo '<td>Total: '.($handling).'</td>';
        echo '<td>Total: '.($stock).'</td>';
        echo '</tr>';



        fclose($fp);

    }

    function pf_api(){
        $t = new pfVendor();

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://wosapiext.usautoparts.com/wosCustomerService.php");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'authorization: Bearer ' . $t->token,

            ));

            $response = curl_exec($ch);
            curl_close($ch);
            $collection = collect(json_decode($response, true));
            dd($collection);
        }

        function get_pf_csv($find,$csv){
            foreach($csv as $row){
           if (
               $find == $row[0] ||
               $find == $row[1] ||
               $find == $row[2] ||
               $find == $row[3] ||
               $find == $row[4]
               ){
            return [
                    $find,
                    $row[7],
                    $row[8],
                    $row[9],
                    $row[16]
                    ];
           }
       }
    }



    public function kit_export(Request $request)
    {
        $where= [];
        if ($request->status!=null) {
            if($request->status ==='link'){
                $where[] = 'hi.link = ""';
            }else{
                $where[] = 'hi.status = '.$request->status.' AND hi.link!=""';
            }
        }

        if (count($where) > 0) {
            $whereClause = ' AND '.implode(' AND ', $where);
        } else {
            $whereClause = '';
        }

        $model = DB::select(DB::raw("
            SELECT
                hi.item_no,
                hi.created_at,
                hii.item as ksku,
                hii.id as kid,
                COALESCE(SUM(hi.percentage_original_price), 0) as koriginal_price,
                COALESCE(SUM(hi.walmart_qty), 0) as kwalmart_qty,
                COALESCE(SUM(hi.walmart_price), 0) as kwalmart_price,
                COALESCE(SUM(hi.walmart_tax), 0) as kwalmart_tax,
                COALESCE(SUM(hi.pf_tax), 0) as kpf_tax,
                COALESCE(SUM(hi.pf_price), 0) as kpf_price,
                COALESCE(SUM(hi.pf_qty), 0) as kpf_qty,
                COALESCE(MIN(hi.profit), 0) as kprofit
            FROM
                hybrid_inventory_items hii
            LEFT JOIN
                hybrid_inventory hi ON hi.item_no = hii.id
            WHERE
                hi.item_no IS NOT NULL" . $whereClause . "
            GROUP BY
                hi.item_no, hii.item, hii.id
            ORDER BY hi.item_no DESC
        "));

        // Open memory stream for the CSV file
        $f = fopen('php://memory', 'w');
        fputcsv($f, ['Action', 'Item number', 'Title', 'Listing site', 'Currency', 'Start price', 'Available quantity', 'Custom label (SKU)','Status']);

        $kit = '';
        $kcost = 0;
        $kqty = 0;
        $parts = '';
        $check=false;
        $statusDescriptions = [
            0 => 'Pending',
            1 => 'Out of stock',
            2 => 'Robot error',
            3 => 'Invalid link',
            4 => 'Part not exist',
            200 => 'Working',
        ];


        $vp =VendorPercentage::where('vendor','hybrid')->first();
        foreach ($model as $line) {
            // Initialize the line parts before processing
            $lineParts = [];
            $detail_inventory = hybridInventory::where('item_no', $line->kid)->get();

            $statusHtml = [];


            foreach ($detail_inventory as $rec) {
                // Add part numbers to the lineParts array
                $lineParts[] = $rec->part_no;
                $status = $rec->link ==='' ? 'Link not exist' :$statusDescriptions[$rec->status] ;

                // Append each status to the HTML string
                $statusHtml[] .= $status;
                $walmart_price =0;
                if($rec->walmart_price <= 35){
                    $walmart_price = $rec->walmart_tax+7;
                }else{
                    $walmart_price =$rec->walmart_tax;
                }
                $currentCost = $rec->walmart_qty > 0 && $rec->walmart_tax< ($rec->pf_tax ?? 0)
                    ? $walmart_price
                    : ($rec->pf_tax ?? 0);

                $currentQty = $rec->walmart_qty > 0 && $rec->walmart_tax< ($rec->pf_tax ?? 0)
                    ? $rec->walmart_qty
                    : ($rec->pf_qty ?? 0);
                    if($currentQty<=$vp->zero_qty){
                        $check =true;
                    }

                    $kcost += $currentCost;
                    $kqty += $currentQty;
            }
            $sale_price = $kcost *((100+$vp->percentage)/100);
            $status = implode(',',$statusHtml);

            if($check ===true){
                $kqty = 0;
            }

            $parts = implode(',', $lineParts);

            if ($kit != $line->ksku) {
                // Adjust quantity using custom logic
                $adjustedQty = adjustKqtyHybrid($kqty);

                // Convert line object to array
                $lineArray = (array)$line;

                // Write to CSV
                fputcsv($f, [
                    'Revise',
                    $lineArray['ksku'],
                    '',
                    'US',
                    'USD',
                    number_format($sale_price,2),
                    $adjustedQty,
                    $parts,
                    $status
                ]);

                // Reset the cost and quantity for the next SKU
                $kcost = 0;
                $sale_price = 0;
                $kqty = 0;
                $check = false;
            }

            // Update the kit to the current SKU
            $kit = $line->ksku;
        }

        // Rewind the memory stream to the beginning
        fseek($f, 0);

        // Set headers for download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="Hybrid_kit_export.csv";');

        // Output the file content to the browser
        fpassthru($f);
    }

    public function parts_export(Request $request) {
        $where = [];

        if ($request->status != null) {
            if ($request->status === 'link') {
                $where[] = 'hybrid_inventory.link = ""';
            } else {
                $where[] = 'hybrid_inventory.status = ' . intval($request->status) . ' AND hybrid_inventory.link != ""';
            }
        }

        if (!empty($where)) {
            $whereClause = implode(' AND ', $where);
        } else {
            $whereClause = '';
        }

        $statusDescriptions = [
            0 => 'Pending',
            1 => 'Out of stock',
            2 => 'Robot error',
            3 => 'Invalid link',
            4 => 'Part not exist',
            200 => 'Working',
        ];
        $model = hybridInventory::with('kit')
        ->select('hybrid_inventory.*', 'hybrid_inventory_items.item as itemno')
        ->join('hybrid_inventory_items', 'hybrid_inventory.item_no', '=', 'hybrid_inventory_items.id');

    if (!empty($whereClause)) {
        $model->whereRaw($whereClause);
    }

    $model = $model->get();
        $f = fopen('php://memory', 'w');
        fputcsv($f, ['Item no', 'Sku', 'SourceLink','Walmart price','Walmart+Tax', 'Walmart Stock','PF price','PF+Tax', 'PF Stock','Status']);

        foreach ($model as $line) {
            $walmart_price =0;
                if($line->walmart_price <= 35){
                    $walmart_price = $line->walmart_tax+7;
                }else{
                    $walmart_price =$line->walmart_tax;
                }
            $status = $line->link ==='' ? 'Link not exist' :$statusDescriptions[$line->status] ;
            $part = $line->part_no;
            $pf_inv = DB::table('pf')->where('SKU', "$part")
                    ->orWhere('PARTSLINK', "$part")
                    ->orWhere('OEM_NUMBER',"$part")
                    ->first();
            $csv_data = [
                $line->itemno,
                $part,
                $line->link,
                $line->walmart_price??0,
                $walmart_price??0,
                $line->walmart_qty??0,
                $pf_inv->PRICE??0,
                $line->pf_tax??0,
                $pf_inv->QTY??0,
                $status,
            ];

            fputcsv($f, $csv_data);
        }

        fseek($f, 0);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="Hybrid_parts_export.csv";');
        fpassthru($f);
    }



}
