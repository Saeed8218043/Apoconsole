<?php

namespace App\Http\Controllers;

use App\Models\Pf;
use App\Models\InventoryPrice;
use App\Models\PfInventory;
use App\Models\PfKitInventory;
use App\Models\PriceSetting;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DB;
use trqVendor;
use pfVendor;
include app_path('Http/Controllers/TrqTrait.php');



class PfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bulkdelete(Request $request){
        if (isset($request->list) && $request->list != '') {
          $list = explode(',', $request->list);

          PfKitInventory::whereIn('id', $list)->delete();
          PfInventory::whereIn('kit_id', $list)->delete();
        }
      }


      public function datatableapi(Request $request)
      {
        // dd($request->all());

        $shopify_syned = DB::table('shopify_product_details')->select('sku')->get()->pluck('sku')->toArray();

        $where = [];

        $search = false;
        if ($request->search['value'] != '') {
            $where[] = 'pf_kit_inventory.sku LIKE "%'.$request->search['value'].'%"';
            $search = true;
        }

        // Check if warehouse filter is set and not empty
        if (isset($request->warehouse_name) && $request->warehouse_name != '') {
            $where[] = 'pf_kit_inventory.warehouse_name = "'.$request->warehouse_name.'"';
        }

        if (count($where) > 0) {
            $where = ' WHERE '.implode(' AND ', $where);
        } else {
            $where = '';
        }
        $warehouse_name = $request->warehouse_name;

        $sql = "SELECT pf_inventory.*,
                pf_kit_inventory.sku as ksku,
                pf_kit_inventory.id as kid,
                pf_kit_inventory.price as kprice,
                pf_kit_inventory.inventory as kinventory,
                SUM(pf_inventory.cost) as kcost,
                SUM(pf_inventory.original_price) as koriginal_price,
                MIN(pf_inventory.qty) as kqty,
                SUM(pf_inventory.commission) as kcommission,
                MAX(pf_inventory.shipping) as kshipping,
                SUM(pf_inventory.handling) as khandling,
                SUM(pf_inventory.profit) as kprofit
                FROM `pf_kit_inventory`
        LEFT JOIN pf_inventory on pf_inventory.kit_id = pf_kit_inventory.id
        ".$where." AND pf_inventory.warehouse_name = '$warehouse_name'
        GROUP BY pf_inventory.kit_id
        ORDER BY pf_inventory.kit_id DESC
        LIMIT ".$request->start.', '.$request->length;



$model = DB::select( DB::raw($sql) );




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

            //  return  get_vendor($row->vendor);
    //  if($row->vendor == 1 ){
    //       return 'TRQ';
    //     }else{
    //         return  'LKQ';
    //     }

          })

           ->editColumn('vendor_id', function ($row) {
    return $row->vendor;


          })


          ->editColumn('created_at', function ($row) {
             return Carbon::parse($row->created_at)->diffForHumans();
          })


          ->editColumn('kcost', function ($row) {
             return number_format($row->kcost,2);
          })
          ->editColumn('koriginal_price', function ($row) {
             return number_format($row->koriginal_price,2);
          })
          ->editColumn('khandling', function ($row) {
             return number_format($row->khandling,2);
          })
          ->editColumn('kshipping', function ($row) {
             return number_format($row->kshipping,2);
          })
          ->editColumn('kprofit', function ($row) {
             return number_format($row->kprofit,2);
          })

          ->addColumn('total', function ($row) {
            return number_format($row->koriginal_price+$row->kcommission+$row->khandling+$row->kshipping+$row->kprofit,2);
         })

         ->addColumn('shopify_syned', function ($row) use ($shopify_syned) {
               if(in_array($row->sku,$shopify_syned)){
                 return '<span style="color: green;" >success</span>';
               }else if($row->qty <=  $row->max_qty-1){
                   return '<span style="color: orange;" >Pending</span>';
               }

         })
          ->addColumn('eqty', function ($row) {

                   return $row->kqty;


         })
         ->addColumn('kinventory', function ($row) use ($warehouse_name) {


            if ($warehouse_name === 'virtual_voyage') {
                return  adjustKqtyVirtualVoyage($row->kqty);
            } elseif($warehouse_name === 'Hybrid') {
                 return adjustKqtyHybrid($row->kqty);
            }else {
                return adjustKqtyDefault($row->kqty);
            }
         })

           ->addColumn('gross', function ($row) {
            return number_format($row->koriginal_price+$row->kcommission+$row->kshipping+$row->khandling,2);
         })

          ->addColumn('detail', function($row) use ($warehouse_name) {
              $res = '<div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5 ">
                    <thead>
                        <tr>
                            <th>Part Number</th>
                            <th>Cost</th>
                            <th>Original Price</th>
                            <th>Shipping</th>
                            <th>handling</th>
                            <th>Inventory</th>
                        </tr>
                    </thead><tbody>';
                    $detail_inventory = DB::select( DB::raw("SELECT * FROM `pf_inventory` WHERE kit_id=".$row->kid." AND warehouse_name='$warehouse_name'") );
                    foreach($detail_inventory as $rec){
                       $res .= '<tr>
                            <td>'.$rec->part_no.'</td>
                            <td>'.$rec->cost.'</td>
                            <td>'.round($rec->original_price,2).'</td>
                            <td>'.$rec->shipping.'</td>
                            <td>'.$rec->handling.'</td>
                            <td>'.$rec->qty.'</td>
                        </tr>';
                    }



                $res .= '</tbody>

                </table>
            </div>';

            return $res;
          })

          ->addColumn('action', function($row)  {
            // dd($row);
            return view('pages.pf.action',['row'=>$row]);
          })


          ->addColumn('checkbox',  function ($row) {
            return ' <div class="form-check-sm form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" value="' . $row->kid . '" />
      </div>';
          })
          ->rawColumns(['checkbox', 'action', 'status', 'amountt', 'date','part_no','shopify_syned','detail'])
          ->skipPaging()
          ->make(true);

          $total = PfKitInventory::where('warehouse_name',$request->warehouse_name)->count();

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
      public function index(Request $request)
      {
        $users = array();
        $kit_inventory = PfKitInventory::where('warehouse_name',$request->segment(1))->count();
        $latestKitInventory = PfKitInventory::where('warehouse_name', $request->segment(1))
                                    ->orderBy('created_at', 'desc')
                                    ->first();
        // dd($kit_inventory);
        return view('pages.pf.main',['users'=>$users,'warehouse_name'=>$request->segment(1),'latestKitInventory'=>$latestKitInventory,'kit_inventory'=>$kit_inventory]);
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

     public function get_pf_inventory(Request $request){
        $pf = PfKitInventory::find($request->id);
        return response()->json([
            'pf_kit'=>$pf->id,
            'pf_parts'=>$pf->kitInventory
        ]);
     }


    public function store(Request $request)
    {
        // $kit= PfKitInventory::find($request->kit_id);
        $warehouse_name = $request->warehouse_name;
        // $parts = $kit->kitInventory;
         PfInventory::where('kit_id',$request->kit_id)->delete();
         $ps = PriceSetting::where('vendor_name',$warehouse_name)->first();
        foreach($request->parts as $part){
            $part_data= DB::table('pf')->where('SKU',$part)->orWhere('PARTSLINK',$part)->orWhere('OEM_NUMBER',$part)->first();
            if(!$part_data){
            return response()->json(['message'=>"Part ($part) didn't exist"],500);
            }
            $percentage = (100 - $ps->profit)/100;
            $price_percentage = (100 + $ps->price_percentage)/100;
            $sale_price = $part_data->PRICE /$percentage;
            $original_price = $part_data->PRICE * $price_percentage;
            $profit= $sale_price-$part_data->PRICE;
            PfInventory::create([
                'kit_id'=>$request->kit_id,
                'part_no'=>$part,
                'sku'=>$part,
                'cost'=>$part_data->PRICE??0,
                'original_price'=>$original_price,
                'warehouse_name'=>$warehouse_name,
                'qty'=>$part_data->QTY??0,
                'fee'=>0,
                'commission'=>0,
                'shipping'=>$part_data->shipping_fee,
                'handling'=>$part_data->handling,
                'profit'=>$profit,
            ]);
        }
        $kit_data = PfInventory::where('kit_id', $request->kit_id)
        ->select(DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(cost) as total_cost'))
        ->first();
        $kitInventory = PfKitInventory::find($request->kit_id);

        if ($kitInventory) {
            $kitInventory->update([
                'inventory' => $kit_data->total_qty,
                'price' => $kit_data->total_cost,
            ]);
        }

        return response()->json(['message'=>'Inventory Successfully Updated'],200);

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
            'file' => 'required|mimetypes:text/csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,text/plain',
        ]);

        $fileExtension = $request->file->getClientOriginalExtension();

        if ($fileExtension === 'csv' || $fileExtension === 'xlsx' || $fileExtension === 'xls') {
            $fileName = time().'.'.$fileExtension;
            $request->file->move(public_path('uploads/pf'), $fileName);

            if ($fileExtension === 'csv') {
                $file = fopen(public_path('uploads/pf/'.$fileName), "r");
                $data['fields'] = fgetcsv($file);
                fclose($file);
            } else {
                $spreadsheet = IOFactory::load(public_path('uploads/pf/'.$fileName));
                $worksheet = $spreadsheet->getActiveSheet();
                $data['fields'] = $worksheet->toArray()[0];
            }

            $data['file_name'] = $fileName;

        } else {
            return response()->json(['error' => 'Unsupported file type'], 400);
        }

        return response()->json(['data' => $data], 200);
    }




    public function insertcsv(Request $request ){
        if($request->file_name ==="single"){
            if ($request->item != ''){
                $kit_id = PfKitInventory::create(

                        [
                            'sku'   => $request->item,
                            'warehouse_name'=>$request->warehouse_name,
                        'price'     => 0,
                        'inventory' => 0
                        ]
                    );

                    foreach($request->sku as $sku){
                        PfInventory::create(

                            [
                                'part_no'   => $sku,
                                'sku' => $sku,
                                'kit_id' => $kit_id->id,
                                'cost' => 0,
                                'warehouse_name'=>$request->warehouse_name,
                                'fee' => 0,
                                'commission' => 0,
                                'shipping' => 0,
                                'profit' => 0,
                                'qty' => 0,
                                ]
                            );
                    }
                return response()->json(['message'=>'Record Inserted Succesfully!','type'=>"success"],200);

                    }
                }

        $file = fopen(public_path('uploads').'/pf/'.$request->file_name,"r");
         fgetcsv($file);

         $kit_id = null;
            while(! feof($file))
            {
            $data = fgetcsv($file);

            if ($data){

                    if ($data[0] == '' && !$kit_id){
                        return response()->json(['message'=>'Error Invalid Kit!','type'=>'error'],200);
                    }

                    if ($data[1] == ''){
                        return response()->json(['message'=>'Part Error!','type'=>'error'],200);
                    }


                    if ($data[0] != ''){
                        $kit_id = PfKitInventory::create(

                                [
                                    'sku'   => $data[0],
                                    'warehouse_name'=>$request->warehouse_name,
                                'price'     => 0,
                                'inventory' => 0
                                ]
                            );
                    }


                        $pf_prod = PfInventory::create(

                            [
                                'part_no'   => $data[1],
                            'sku' => $data[1],
                                'kit_id' => $kit_id->id,
                                'cost' => 0,
                                'warehouse_name'=>$request->warehouse_name,
                                'fee' => 0,
                                'commission' => 0,
                                'shipping' => 0,
                                'profit' => 0,
                                'qty' => 0,
                            ]
                        );

                }

                    // $pf_prod->update_master_price();
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


           // Fetch all unique vendor names
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





 public function pf_calculator(Request $request)
{
    $pfDir = './cron/pf/';
    $sourceDir = '/home/apoconsole/apoconsole.com/expressmerch/';

    // Get the primary pf file (existing logic)
    $dir = scandir($pfDir);
    foreach ($dir as $files) {
        if (pathinfo($files, PATHINFO_EXTENSION) === 'zip') {
            $pf_inventory_file = $files;
        }
    }

    // Get the latest carparts_ds_inv_ file
    $carparts_file = null;
    $latestTime = 0;
    $sourceFiles = scandir($sourceDir);
    foreach ($sourceFiles as $file) {
        if (strpos($file, 'carparts_ss_inv_') === 0 && pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
            $fileTime = filemtime($sourceDir . $file); // Get file modification time
            if ($fileTime > $latestTime) {
                $latestTime = $fileTime;
                $carparts_file = $file; // Set to latest file
            }
        }
    }
    // Ensure both files are found
    if ($pf_inventory_file && $carparts_file) {
        // Process the pf file
        chdir($pfDir);
        $pfFile = 'zip://' . $pf_inventory_file . '#' . pathinfo($pf_inventory_file, PATHINFO_FILENAME) . '.txt';
        $pf_fp = fopen($pfFile, 'r');
        if (!$pf_fp) {
            exit("PF Inventory File Error\n");
        }
        $pf_csv = [];
        while (($data = fgetcsv($pf_fp, 0, "\t")) !== false) {
            $pf_csv[] = $data;
        }
        fclose($pf_fp);

        // Process the latest carparts_ds_inv_ zip file
        $carpartsFile = $sourceDir . $carparts_file;
        $carparts_fp = fopen('zip://' . $carpartsFile . '#' . pathinfo($carparts_file, PATHINFO_FILENAME) . '.txt', 'r');
        if (!$carparts_fp) {
            exit("Carparts File Error\n");
        }
        $carparts_csv = [];
        while (($data = fgetcsv($carparts_fp, 0, "\t")) !== false) {
            $carparts_csv[] = $data;
        }
        fclose($carparts_fp);

        // Get user input data
        $data = request()->all();
        $price = 0;
        $shipping = 0;
        $ss_price = 0;
        $handling = 0;
        $stock = 0;

        foreach ($data as $row) {
            echo '<tr>';
            $pf = [];
            if ($row != null) {
                $pf = $this->get_pf_csv($row, $pf_csv, $carparts_csv);
            }

            // Calculate values
            if (isset($pf[0])) { $pf[0] = $pf[0]; } else { $pf[0] = ''; }
            if (isset($pf[1])) { $pf[1] = $pf[1]; $price += $pf[1]; } else { $pf[1] = ''; }
            if (isset($pf[2])) { $pf[2] = $pf[2]; if ($pf[2] > $shipping) { $shipping = $pf[2]; } } else { $pf[2] = ''; }
            if (isset($pf[3])) { $pf[3] = $pf[3]; $handling += $pf[3]; } else { $pf[3] = ''; }
            if (isset($pf[4])) { $pf[4] = $pf[4]; $stock += $pf[4]; } else { $pf[4] = ''; }

            // Get price from carparts file for $pf[5]
            if (isset($pf[5])) {
                $ss_price += $pf[5]; // Add the price from carparts file
            }

            // Output the table row with values
            echo '<td><input type="text" onpaste="pastexls(event)" value="' . ($row) . '" onchange="calculate_pf()" class="form-control" placeholder="Type Sku..." style="padding: 2px;max-width: 112px;"></td>';
            echo '<td>' . ($pf[1]) . '</td>';
            echo '<td>' . ($pf[5]) . '</td>';  // Price from carparts file
            echo '<td>' . ($pf[2]) . '</td>';
            echo '<td>' . ($pf[3]) . '</td>';
            echo '<td>' . ($pf[4]) . '</td>';
            echo '<td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>';
            echo '</tr>';
        }

        // Calculate totals
        $es = 0;
        $ts = $price + $shipping + $handling;
        if ($ts > 0) {
            $es = $ts * 1.13;
            $es = $es * 1.13;
        }

        // Output totals row
        echo '<tr>';
        echo '<td>Estimated Cost: ' . ($price + $shipping + $handling) . ' <br>Estimated Price: ' . (number_format($es, 2)) . '</td>';
        echo '<td>Total: ' . ($price) . '</td>';
        echo '<td>Total: ' . ($ss_price) . '</td>';
        echo '<td>Max: ' . ($shipping) . '</td>';
        echo '<td>Total: ' . ($handling) . '</td>';
        echo '<td>Total: ' . ($stock) . '</td>';
        echo '<td></td>';
        echo '</tr>';
    } else {
        exit("Required files not found.\n");
    }
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

        function get_pf_csv($find, $pf_csv, $carparts_csv)
        {
            $pf_data = null;
            $carparts_data = null;

            // Search in the primary (pf) CSV
            foreach ($pf_csv as $row) {
                if (
                    $find == $row[0] || // SKU
                    $find == $row[1] ||
                    $find == $row[2] ||
                    $find == $row[3] ||
                    $find == $row[4] ||
                    $find == $row[5]
                ) {
                    // Store relevant data from the pf file
                    $pf_data = [
                        $find,          // SKU
                        isset($row[7]) ? $row[7] : 0,  // COST
                        isset($row[8]) ? $row[8] : 0,  // SHIPPING_COST
                        isset($row[9]) ? $row[9] : 0,  // HANDLING_COST
                        isset($row[16]) ? $row[16] : 0 // STOCK_TOTAL
                    ];
                    break; // Stop searching after finding the first match
                }
            }

            // Search in the carparts CSV
            foreach ($carparts_csv as $row) {
                if (
                    $find == $row[0] || // SKU
                    $find == $row[1] ||
                    $find == $row[2] ||
                    $find == $row[3] ||
                    $find == $row[4] ||
                    $find == $row[5]
                ) {
                    // Store relevant price from the carparts file
                    $carparts_data = isset($row[7]) ? $row[7] : 0; // COST
                    break; // Stop searching after finding the first match
                }
            }

            // Return combined data
            return [
                isset($pf_data) ? $pf_data[0] : '', // SKU
                isset($pf_data) ? $pf_data[1] : 0,   // COST from pf file
                isset($pf_data) ? $pf_data[2] : 0,   // SHIPPING_COST
                isset($pf_data) ? $pf_data[3] : 0,   // HANDLING_COST
                isset($pf_data) ? $pf_data[4] : 0,   // STOCK_TOTAL
                isset($carparts_data) ? $carparts_data : 0 // COST from carparts file
            ];
        }





    public function export_inventory(Request $request){
        $warehouse_name = $request->input('warehouse_name');
        $model = DB::select(DB::raw("  SELECT
        pf_kit_inventory.sku AS ksku,
        pf_kit_inventory.id AS kid,
        SUM(pf_inventory.original_price) AS koriginal_price,
        SUM(pf_inventory.cost) AS kcost,
        MIN(pf_inventory.qty) AS kqty,
        SUM(pf_inventory.commission) AS kcommission,
        MAX(pf_inventory.shipping) AS kshipping,
        SUM(pf_inventory.handling) AS khandling,
        SUM(pf_inventory.profit) AS kprofit,
        pf_kit_inventory.price AS kprice,
        GROUP_CONCAT(pf_inventory.part_no) AS parts
            FROM `pf_inventory`
            LEFT JOIN pf_kit_inventory ON pf_kit_inventory.id = pf_inventory.kit_id WHERE pf_inventory.warehouse_name = '$warehouse_name'
            GROUP BY pf_inventory.kit_id
            ORDER BY pf_inventory.kit_id;"));
                $f = fopen('php://memory', 'w');
                fputcsv($f, ['Action', 'Item number', 'Title', 'Listing site', 'Currency', 'Start price', 'Buy It Now price', 'Available quantity', 'Relationship', 'Relationship details', 'Custom label (SKU)']);

        $kit = '';
        $partCount = 0;
        foreach ($model as $line) {
            $line = (array)$line;
            if ($kit != $line['ksku']) {
                    $gross=$line['koriginal_price']+$line['kshipping']+$line['khandling']+$line['kprofit'];


                    if ($warehouse_name === 'virtual_voyage') {
                        $line['kqty'] = adjustKqtyVirtualVoyage($line['kqty']);
                    } elseif($warehouse_name === 'Hybrid') {
                        $line['kqty'] = adjustKqtyHybrid($line['kqty']);
                    }else {
                        $line['kqty'] = adjustKqtyDefault($line['kqty']);
                    }

                    fputcsv($f, ['Revise', $line['ksku'], '', 'US', 'USD', $line['koriginal_price'] + $line['kshipping'] + $line['khandling'] + $line['kprofit'], '', ($line['kqty'] < 5) ? 0 : $line['kqty'], '', '', $line['parts']]);

            }
        }

        fseek($f, 0);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="pf_export.csv";');
        fpassthru($f);
    }




}
