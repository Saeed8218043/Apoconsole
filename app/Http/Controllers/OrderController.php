<?php

namespace App\Http\Controllers;
use App\Jobs\ProcessOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Order;
use App\Models\ShopifyOrder;
use DataTables;
use Carbon\Carbon;
use DateTime;
use DB;
use App\Models\TrqProfit;
use trqVendor;
include app_path('Http/Controllers/TrqTrait.php');

class OrderController extends Controller
{
    //

       public function __construct()
    {
        ini_set('memory_limit', '1024M');
    }


    public function bulkdelete(Request $request)
    {
        if (isset($request->list) && $request->list != '') {
          $list = explode(',', $request->list);

          Order::whereIn('id', $list)->delete();
        }
    }
     public function orders(Request $request){
      $search='';
      if (isset($request->search) && $request->search != ''){
        $search =   $request->search['value'];
      } else {
         $search = NULL;
      }
      $order_log = Order::where('id',"$request->id")->first();
      $vendor_json = json_decode($order_log->order_json);
      if((isset($vendor_json->status) && $vendor_json->status ===400) || (isset($vendor_json->statusCode) && $vendor_json->statusCode ===401)){
        return response()->json(['error'=>$vendor_json->message]);
      }
       $t = new trqVendor();
       $res = json_decode($t->get_order($vendor_json->name),true);
      return response()->json($res);
     }
    public function get_rma(Request $request){
      return $this->orders($request);
    }

    public function get_detail(Request $request){
      $search='';
        if (isset($request->search) && $request->search != ''){
          $search =   $request->search['value'];
        } else {
           $search = NULL;
        }

        $order_log = Order::where('id',$request->id)->first();
        if($order_log===null || $order_log->vendor_json===''){
            $order_log = ShopifyOrder::where('id',$request->id)->first();
        }
        $vendor_json = json_decode($order_log->vendor_json);

        if(isset($vendor_json->error) && $vendor_json->error!=''){
           if(isset($vendor_json->message)){
            return response()->json(['error'=>$vendor_json->message]);
          }else{
            return response()->json(['error'=>$vendor_json->errors]);
          }
        }elseif(isset($vendor_json->errors) && $vendor_json->errors!=''){
          return response()->json(['error'=>$vendor_json->errors[0]]);
        }
        $res='';
        if($vendor_json ==='' || $vendor_json===null){
          return response()->json(['error'=>'Order on shopify not punched yet']);
        }else{
            $t = new trqVendor();
            $res = json_decode($t->get_order($order_log->po_number??$vendor_json->poNumber),true);
        }
        return response()->json($res);
    }

    public function order_refund(Request $request){
      $search='';
        if (isset($request->search) && $request->search != ''){
          $search =   $request->search['value'];
        } else {
           $search = NULL;
        }
        $order_log = Order::where('id',$request->id)->first();
        $vendor_json = json_decode($order_log->vendor_json);
        if((isset($vendor_json->status) && $vendor_json->status ===400) || (isset($vendor_json->statusCode) && $vendor_json->statusCode ===401)){
          return response()->json(['error'=>$vendor_json->message]);
        }
         $t = new trqVendor();
         $res = json_decode($t->get_order($vendor_json->poNumber),true);
        return response()->json($res);
    }

    public function order_cancel(Request $request){
      $search='';
        if (isset($request->search) && $request->search != ''){
          $search =   $request->search['value'];
        } else {
           $search = NULL;
        }
        $order_log = Order::where('id',$request->id)->first();
        $vendor_json = json_decode($order_log->vendor_json);
        if((isset($vendor_json->status) && $vendor_json->status ===400) || (isset($vendor_json->statusCode) && $vendor_json->statusCode ===401)){
          if(isset($vendor_json->message)){
            return response()->json(['error'=>$vendor_json->message]);
          }else{
            return response()->json(['error'=>$vendor_json->error]);
          }
        }
         $t = new trqVendor();
         $res = json_decode($t->get_order($vendor_json->poNumber),true);
        return response()->json($res);
    }


    public function all_orders(Request $request){

        $totalPages = 588; // Replace with the actual total pages

        for ($i = 0; $i < $totalPages; $i++) {
            ProcessOrders::dispatch($i);
        }
    }

    public function update_orders(Request $request){

        $model = DB::table('orders_log')
       ->select('*')
       ->where('order_json', 'LIKE', '%"shipping_lines":[{"id":%')
       ->where(function ($query) {
           $query->where('vendor_json', 'LIKE', '%"status":"Open"%')
                 ->orWhere('vendor_json', 'LIKE', '%"status":"shipped"%');
       })
       ->orderBy('id', 'DESC')
       ->whereBetween('created_at', [now()->subWeek(), now()->addDay()])
       ->get();


          foreach ($model as $data) {
           $vendorJsonData = json_decode($data->vendor_json);
           if ($vendorJsonData !== null && property_exists($vendorJsonData, 'poNumber')) {
             //Order::where('id', $data->id)->update(['po_number' => $vendorJsonData->poNumber]);
             Order::where('id', $data->id)->update(['po_number' => $vendorJsonData->poNumber]);
           }
          }



            $t = new trqVendor();
          $allData = [];

          for ($i = 0; $i < 8; $i++) {
              $ch = curl_init();

              curl_setopt($ch, CURLOPT_URL, "https://api1.trqautoparts.com/api/v3/orders?page=$i&size=400");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'authorization: Bearer ' . $t->token,
                  'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
              ));

              $response = curl_exec($ch);
              curl_close($ch);

              $collection = collect(json_decode($response, true));
              dd($collection);
              if (isset($collection['_embedded']['orders'])) {
                  // Use a loop to transform each item in the collection
                  foreach ($collection['_embedded']['orders'] as $data) {
                     if (strpos($data['poNumber'], '#AO') === 0 || strpos($data['poNumber'], 'AO') === 0 ) {
                         ShopifyOrder::updateOrInsert(
                             ['po_number' => $data['poNumber']],
                             ['vendor_json' => json_encode($data),
                             'shop_url' => "autospartoutlet.myshopify.com",
                             'order_json' => json_encode($this->shopify_json($data)),
                              'created_at' => Carbon::parse($data['orderDate'])]
                         );
                     }else{
                         $allData[] = [
                             'po_number' => $data['poNumber'],
                             'shop_url' => "autospartoutlet.myshopify.com",
                             'order_json'=>json_encode($this->shopify_json($data)),
                             'vendor_json' => json_encode($data),
                             'created_at' => Carbon::parse($data['orderDate']),
                         ];
                     }
                 }
             } else {
                 // For example, you can log a message or take appropriate action
                 echo "No orders found in the response.";
             }
          // Update or insert the accumulated data into the database
          DB::table('orders_log')->upsert(
              $allData,
              ['po_number'], // The unique key to check for updates
              ['vendor_json'], // The columns to update if the record already exists
              ['created_at']
          );
         }
         }


    public function shopify_update_orders(Request $request){
        $shopify_orders = ShopifyOrder::all();
        foreach ($shopify_orders as $data) {
         $vendorJsonData = json_decode($data->order_json);
         if ($vendorJsonData !== null && property_exists($vendorJsonData, 'name')) {
             $poNumber = ltrim($vendorJsonData->name, '#');
             $s_order = ShopifyOrder::where('po_number',$vendorJsonData->name)->first();
                if($s_order ===null){
                    try {
                        // Update the po_number field using raw SQL
                        DB::statement("
                            UPDATE shopify_orders_log
                            SET po_number = '$poNumber'
                            WHERE id = $data->id
                        ");
                    } catch (\Exception $e) {
                        // Check if it's a duplicate entry error
                        $errorCode = $e->getCode();
                        if ($errorCode === 23000 || strpos($e->getMessage(), 'Duplicate entry') !== false) {
                            // Handle the duplicate entry error
                            // Delete the row with the duplicate entry (excluding the original one)
                            DB::table('shopify_orders_log')
                                ->where('po_number', $poNumber)
                                ->where('id', '!=', $data->id)
                                ->delete();

                        } else {
                            // Rethrow the exception if it's not a duplicate entry error
                            throw $e;
                        }
                    }
                }
            }
                }
                $orders = ShopifyOrder::where('po_number','!=','')->get();
                foreach($orders as $order){
                    $t = new trqVendor();
                    $res = json_decode($t->get_order($order->po_number),true);
                    if($res!==null){
                        $updated_data = json_encode($res);
                        ShopifyOrder::where('id', $order->id)->update(['vendor_json' => $updated_data]);
                    }

                }

         }


    public function exportCsvFiltered(Request $request)
        {
            // Retrieve filtered data based on the request parameters
            $filteredData = $this->getFilteredData($request);

            // Create the CSV file name
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment;",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];

            $handle = fopen('php://temp', 'w+');

            // Add CSV headers
            fputcsv($handle, ['Po Number','Tracking','Order date']);

            // Add data rows
            foreach ($filteredData as $row) {
                $json_data = json_decode($row->vendor_json);
                $po_number = $json_data->poNumber ?? '';
                $tracking = $json_data->items[0]->trackingNumbers[0]->trackingNumber ?? '';
                // Check if tracking is an array with at least one element
                if (is_array($tracking) && count($tracking) > 0) {
                    $trackingNumber = $tracking[0]->trackingNumber ?? null;

                    // Check if the tracking number is not null before using it
                    if ($po_number !== '' && $trackingNumber !== null) {
                        fputcsv($handle, [$po_number, $trackingNumber, $row->created_at]);
                    }
                } elseif ($po_number !== '' && $tracking !== '') {
                    // Handle the case where tracking is a string
                    fputcsv($handle, [$po_number, $tracking, $row->created_at]);
                }
            }

            fseek($handle, 0);

            // Use the stream method to generate the file download
            $response = response()->stream(
                function () use ($handle) {
                    fpassthru($handle);
                    fclose($handle); // Close the file handle properly
                },
                200,
                $headers
            );

            $response->send();

            exit;
        }

        private function getFilteredData(Request $request)
        {
            // Your logic to filter data based on request parameters
            // Example: use Eloquent to query the database based on filters
            $store = isset($request->store)?$request->store:'';
            $query = Order::query();
            if($store!='' && isset($request->start_date) && $request->start_date!=null && isset($request->end_date) && $request->end_date!=null){
                $query = Order::whereBetween('created_at', [$request->start_date, $request->end_date])->validJson()->where('store', 'LIKE', "%$store%");
            }else if($store!='' && $request->start_date===null && $request->end_date===null){
                $query = Order::validJson()->where('store', 'LIKE', "%$store%");
            }
            else{
                $query = Order::query()->validJson();
            }
            // Apply your filters here...

            return $query->get();
        }

   public function orderSelectStore(Request $request){
    $order = Order::where('id',$request->row_id)->update([
        'store'=>$request->store
    ]);
    return response()->json(['message'=>"This record successfully saved to the $request->store"],200);
   }
   public function datatableapi(Request $request)
    {
      if(isset($request->store) && $request->store==='shopify'){
        $model = ShopifyOrder::orderBy('created_at','desc');
      }else{

          $w = '"shipping_lines":[{"id":';
           $a = '"vendor":"TRQ"';
           if(isset($request->store) && $request->store !=='' && $request->store!=='shopify'){
              $model = Order::orderBy('created_at','desc')->where('order_json', 'LIKE', "%{$w}%")->where('store','LIKE',"%$request->store%");
           }else{
               $model = Order::orderBy('created_at','desc');
           }
      }

        // if (!auth()->user()->is_admin()){
        //     $model = $model->where('user_id',auth()->id());
        // }
            // Apply date range filter
            if ($request->start_date && $request->end_date) {
              $startDate = $request->start_date . ' 00:00:00';
              $endDate = $request->end_date . ' 23:59:59';

              $model = $model->whereBetween('created_at', [$startDate, $endDate]);
            }

            // Apply status filter
            if ($request->status && $request->status !== 'All') {
              $model = $model->where('vendor_json', 'LIKE', '%"status":"' . $request->status . '"%');
            }

            if ($request->has('search') && isset($request->search['value'])) {
                $searchTerm = $request->search['value'];
                $order_log = Order::where('order_json','LIKE',"%$searchTerm%")->Orwhere('vendor_json','LIKE',"%$searchTerm%")->first();
                $t = new trqVendor();
                $res = json_decode($t->get_order($searchTerm),true);
                if($res){
                    $allData[] = [
                        'po_number' => $res['poNumber'],
                            'shop_url' => "autospartoutlet.myshopify.com",
                            'order_json'=>json_encode($this->shopify_json($res)),
                            'vendor_json' => json_encode($res),
                            'created_at' => Carbon::parse($res['orderDate']),
                        ];


                    if($order_log===null){
                        DB::table('orders_log')->upsert(
                            $allData,
                            ['po_number'], // The unique key to check for updates
                            ['vendor_json'], // The columns to update if the record already exists
                            ['created_at']
                        );

                    }else{
                        $order_log->update([
                            'shop_url' => "autospartoutlet.myshopify.com",
                        'order_json'=>json_encode($this->shopify_json($res)),
                        'vendor_json' => json_encode($res),
                        'created_at' => Carbon::parse($res['orderDate']),
                        ]);
                    }

                }

                // Perform raw query search
                $model = $model->whereRaw("order_json LIKE ? OR vendor_json LIKE ?", ["%$searchTerm%", "%$searchTerm%"]);
            }

        $model =  $model->limit(5000)->get();
        $x=0;
        foreach($model as $d){
        $order_data = json_decode($d->order_json, true);

        if (isset($order_data['line_items']) && isset($order_data['line_items'][0]) && isset($order_data['line_items'][0]['vendor']) && $order_data['line_items'][0]['vendor'] == 'AUTOOUTLET'){
          if (isset($model[$x])){
              unset($model[$x]);
          }
        }
        $x++;
         }


  $_GET['id']=1;

  	$order_json = [];
  	$vendor_json = [];

      return DataTables::of($model)

        ->setRowData([

        ])



        ->editColumn('created_at', function ($row) use (&$order_json,&$vendor_json) {
        	$order_json = json_decode($row->order_json,true);
        	$vendor_json = json_decode($row->vendor_json,true);

           return Carbon::parse($row->created_at)->format('d-m-Y ');
        })

        ->addColumn('sku', function ($row) use (&$order_json,&$vendor_json) {
            if (isset($order_json['line_items'][0])){
              $row = $order_json['line_items'][0]['sku'];
          return $row;
            }

       })
       ->addColumn('name', function ($row) use (&$order_json,&$vendor_json) {
           if (isset($order_json['line_items'][0])){
             $row = $order_json['line_items'][0]['sku'];
          return $row;
           }

       })


        ->addColumn('city', function ($row) use (&$order_json,&$vendor_json) {
          $order_json = json_decode($row->order_json,true);
        	$vendor_json = json_decode($row->vendor_json,true);
            if (isset($order_json['shipping_address']['city'])){
             $row = $order_json['shipping_address']['city'];
          return $row;
            }

       })
   ->addColumn('zip', function ($row) use (&$order_json,&$vendor_json) {
       if(isset($order_json['shipping_address']['zip'])){
           $row = $order_json['shipping_address']['zip'];
          return $row;
       }

       })

       ->addColumn('price', function ($row) use (&$order_json,&$vendor_json) {
        $order_json = json_decode($row->order_json,true);
        	$data = json_decode($row->vendor_json,true);
           if (isset($data['orderTotal'])){
             $row = $data['orderTotal'];
             return $row;
           }

   })

   ->addColumn('store', function ($row) use (&$order_json,&$vendor_json) {

        return $row->store;

})
   ->addColumn('sales_price', function ($row) use (&$order_json,&$vendor_json) {

        return $row->sales_price;

})

    ->addColumn('shipper_name', function ($row) use (&$order_json,&$vendor_json) {
        $order_json = json_decode($row->order_json,true);
        $vendor_json = json_decode($row->vendor_json,true);
       if (isset($order_json['shipping_address']['first_name'])){
         $row = $order_json['shipping_address']['first_name']." ".$order_json['shipping_address']['last_name'];
         return $row;
       }
     })


        ->addColumn('action', function($row) use (&$order_json,&$vendor_json)  {

          return view('pages.order.action',['row'=>$row]);
        })
        ->addColumn('checkbox',  function ($row) use (&$order_json,&$vendor_json) {

            if (isset($vendor_json['id'])){
              return '';
            }


          return ' <div class="form-check form-check-sm form-check-custom form-check-solid">
      <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
    </div>';
        })


        ->addColumn('shipping_method', function ($row) use (&$order_json,&$vendor_json) {
            $row = 'Standard';
          return $row;
       })

          ->addColumn('country_code', function ($row) use (&$order_json,&$vendor_json) {
              if (isset($order_json['shipping_address']['province_code'])){
                $row = $order_json['shipping_address']['province_code'];
                return $row;
              }

       })
         ->addColumn('address', function ($row) use (&$order_json,&$vendor_json) {
             if (isset($order_json['shipping_address']['address1'])){
              $row = $order_json['shipping_address']['address1'];
                return $row;
             }

       })
        ->addColumn('address2', function ($row) use (&$order_json,&$vendor_json) {
            if (isset($order_json['shipping_address']['address2'])){
               $row = $order_json['shipping_address']['address2'];
                return $row;
            }

       })
         ->addColumn('currency', function ($row) use (&$order_json,&$vendor_json) {
            $row = '$';
          return $row;
       })
            ->addColumn('po_number', function ($row) use (&$order_json,&$vendor_json) {
              $order_json = json_decode($row->order_json,true);
              $vendor_json = json_decode($row->vendor_json,true);
                 if (isset($order_json['name']) && !isset($vendor_json['poNumber'])  ){
              $row = "<p class='m-0' style='color: red' >".$order_json['name']."</p>";
          return $row;
            }
               if (isset($order_json['name'])  ){
              $row = "<p >".$order_json['name']."</p>";
          return $row;
            }

                if (isset($vendor_json['poNumber'])){

            return $vendor_json['poNumber'];

            }

       })


        ->addColumn('contact_email', function ($row) use (&$order_json,&$vendor_json) {
        //     $row = $order_json['shipping_address']['first_name'];
        //   return $row;
       })


        ->addColumn('payment_name', function ($row) use (&$order_json,&$vendor_json) {
            if (isset($order_json['payment_gateway_names'][0])){
              $row = $order_json['payment_gateway_names'][0];
          return $row;
            }

       })

         ->addColumn('province_code', function ($row) use (&$order_json,&$vendor_json) {
             if (isset($order_json['shipping_address']['province_code'])){
               $row = $order_json['shipping_address']['province_code'];
                 return $row;
             }

       })

        ->addColumn('vendor', function ($row) use (&$order_json,&$vendor_json) {
            if (isset($order_json['line_items'][0])){

            }

       })

        ->addColumn('variant', function ($row) use (&$order_json,&$vendor_json) {
            if (isset($order_json['line_items'][0])){

            }

       })
       ->addColumn('total', function ($row) use (&$order_json,&$vendor_json) {
            if (isset($vendor_json['orderTotal'])){
             $row = $vendor_json['orderTotal'];
            return $row;
            }

       })
        ->addColumn('trq_id', function ($row) use (&$order_json,&$vendor_json) {
            if (isset($vendor_json['id'])){
             $row = $vendor_json['id'];
            return $row;
            }

       })
       ->addColumn('status', function ($row) use (&$order_json,&$vendor_json) {

           if (isset($vendor_json['error']) || isset($vendor_json['errors'])){
             $row = "<p style='color: red;' >Error</p>";
            return $row;
            }

            if (isset($vendor_json['status'])){
             $row = "<p style='color: blue;' >".$vendor_json['status']."</p>";
            return $row;
            }

       })


       ->addColumn('status_message', function ($row) use (&$order_json,&$vendor_json) {

           if (isset($vendor_json['error']) || isset($vendor_json['errors'])){
             if (isset($vendor_json['message'])){
              return "<p style='color: red;' >".$vendor_json['message']."</p>";
             }
             return "<p style='color: red;' >".implode("<br>",$vendor_json['errors'])."</p>";
            }

            if (isset($vendor_json['status'])){
             $row = "<p style='color: blue;' >".$vendor_json['status']."</p>";
            return $row;
            }

       })


        ->addColumn('items', function ($row) use (&$order_json,&$vendor_json) {

          if (isset($order_json['line_items'])){
              $row = $order_json['line_items'];
                  return $row;
            }

       })

        ->rawColumns(['checkbox', 'action', 'status','status_message', 'amountt', 'date','part_no','po_number'])
        ->make(true);
    }



    public function index()
    {
        $store='';
        $orderModel = new Order();
        $date = Carbon::now()->format('d-m-Y');
        $csvFileName = 'trq_profit_' . $date . '.csv';
        $users = array();
        $today = Carbon::now()->toDateString();

        $today = now()->toDateString();
        $startDate = now()->subDays(30)->startOfDay();
        $endDate = now()->endOfDay();

        $todayCount = $orderModel->getOrderCount($today, $store);
        $monthCount = $orderModel->getOrderCountBetweenDates($startDate, $endDate, $store);
        $sales_1 = $orderModel->getSalesSum($today, $store);
        $sales_30 = $orderModel->getSalesSum($startDate, $store);
        $cost_1 = $orderModel->getCostSum($today, $store);
        $cost_30 = $orderModel->getCostSum($startDate, $store);


      return view('pages.order.main',['users'=>$users,'orders'=>$todayCount,'monthlyOrders'=>$monthCount,'sales_price'=>$sales_1,'sales_30'=>$sales_30??0,'day_cost'=>$cost_1??0,'cost_30'=>$cost_30,'file_name'=>$csvFileName]);
    }


    public function shopify_order()
    {
        $store='';
        $orderModel = new ShopifyOrder();
        $date = Carbon::now()->format('d-m-Y');
        $csvFileName = 'trq_profit_' . $date . '.csv';
        $users = array();
        $today = Carbon::now()->toDateString();

        $today = now()->toDateString();
        $startDate = now()->subDays(30)->startOfDay();
        $endDate = now()->endOfDay();

        $todayCount = $orderModel->getOrderCount($today, $store);
        $monthCount = $orderModel->getOrderCountBetweenDates($startDate, $endDate, $store);
        $sales_1 = $orderModel->getSalesSum($today, $store);
        $sales_30 = $orderModel->getSalesSum($startDate, $store);
        $cost_1 = $orderModel->getCostSum($today, $store);
        $cost_30 = $orderModel->getCostSum($startDate, $store);

      return view('pages.order.shopify_order',['users'=>$users,'orders'=>$todayCount,'monthlyOrders'=>$monthCount,'sales_price'=>$sales_1,'sales_30'=>$sales_30??0,'day_cost'=>$cost_1??0,'cost_30'=>$cost_30,'file_name'=>$csvFileName,'store'=>'shopify']);
    }

    public function getStoreData(Request $request)
    {
        $users = array();
        $orderModel = new Order(); // or you can use dependency injection to inject the Order model into your controller

        $store = $request->segment(2);
        $date = now()->format('d-m-Y');
        $csvFileName = 'trq_profit_' . $date . '.csv';

        $today = now()->toDateString();
        $startDate = now()->subDays(30)->startOfDay();
        $endDate = now()->endOfDay();

        $todayCount = $orderModel->getOrderCount($today, $store);
        $monthCount = $orderModel->getOrderCountBetweenDates($startDate, $endDate, $store);
        $sales_1 = $orderModel->getSalesSum($today, $store);
        $sales_30 = $orderModel->getSalesSum($startDate, $store);
        $cost_1 = $orderModel->getCostSum($today, $store);
        $cost_30 = $orderModel->getCostSum($startDate, $store);

        return view('pages.store.main', [
            // ... your other data
            'orders' => $todayCount,
            'monthlyOrders' => $monthCount,
            'sales_price' => $sales_1,
            'sales_30' => $sales_30 ?? 0,
            'day_cost' => $cost_1 ?? 0,
            'cost_30' => $cost_30,
            'file_name' => $csvFileName,
            'users' => $users,
            'store' => $store
        ]);
    }

    protected function getOrderCount($date, $store)
    {
        return Order::whereDate('created_at', $date)->where('store', 'LIKE', "%$store%")->validJson()->count();
    }

    protected function getOrderCountBetweenDates($startDate, $endDate, $store)
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])->validJson()->where('store', 'LIKE', "%$store%")->count();
    }

    protected function getSalesSum($date, $store)
    {
        return Order::where('created_at', '>=', $date)->validJson()->where('store', 'LIKE', "%$store%")->sum('sales_price');
    }

    protected function getCostSum($date, $store)
    {
        return Order::where('created_at', '>=', $date)->validJson()->where('store', 'LIKE', "%$store%")->sum(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(vendor_json, '$.orderTotal'))"));
    }


    function get_profit_sheet(Request $request){
        $store = isset($request->store)?$request->store:'';
        $row = Order::where('id',$request->id)->first();
        if($store ==='shopify'){
            $row = ShopifyOrder::where('id',$request->id)->first();
        }
      return response()->json(['data'=>json_decode($row->vendor_json),'sales_price'=>$row->sales_price]);
    }

    public function store(Request $request)
    {

        $coupon = Order::create([
            'sku'          => $request->sku,
            'part_no'      => $request->part_no,
            'cost'         => $request->cost,
            'qty'          => $request->qty,
            'fee'          => $request->fee,
            'commission'   => $request->commission,
            'shipping'     => $request->shipping,
            'profit'       => $request->profit,
        ]);

        if (isset($coupon->id)) {
            return response()->json(['message'=>'Niches Successfully Added'],200);
        } else {
            return response()->json(['message'=>'Unable To Process Request'],500);
        }
    }
    public function edit_profit_sheet(Request $request){
        // dd($request->all());
        $name = isset($request->name)?$request->name:0;
        $store = isset($request->store)?$request->store:0;
        $po_number = isset($request->po_number)?$request->po_number:0;
        $sale_price = isset($request->sale_price)?$request->sale_price:0;
        $selling_fee = isset($request->selling_fee)?$request->selling_fee:0;
        $selling_fee_reversal = isset($request->selling_fee_reversal)?$request->selling_fee_reversal:0;
        $net_selling_fee = isset($request->net_selling_fee)?$request->net_selling_fee:0;
        $cost = isset($request->cost)?$request->cost:0;
        $RTN = isset($request->RTN)?$request->RTN:0;
        $net_cost = isset($request->net_cost)?$request->net_cost:0;
        $adjustment_fee = isset($request->adjustment_fee)?$request->adjustment_fee:0;
        $shipping_fee = isset($request->shipping_fee)?$request->shipping_fee:0;
        $shipping_fee_reversal = isset($request->shipping_fee_reversal)?$request->shipping_fee_reversal:0;
        $net_shipping_fee = isset($request->net_shipping_fee)?$request->net_shipping_fee:0;
        $refund = isset($request->refund)?$request->refund:0;
        $cogs = isset($request->cogs)?$request->cogs:0;
        $total_cost = isset($request->total_cost)?$request->total_cost:0;
        $revenue_passive = isset($request->revenue_passive)?$request->revenue_passive:0;
        $odr = isset($request->odr)?$request->odr:0;

        Order::where('po_number',$po_number)->update([
            'sales_price' =>$sale_price
        ]);

        TrqProfit::updateOrCreate(
            ['po_number' => $po_number],
            [
                'sale_price' => $sale_price,
                'shipper_name' => $name,
                'store' => $request->store ?? '',
                'selling_fees' => $selling_fee,
                'selling_fees_reverse' => $selling_fee_reversal,
                'net_selling_fee' =>$net_selling_fee,
                'trq_rtn' =>$RTN,
                'net_cost' => $net_cost,
                'adjustment_fee' => $adjustment_fee,
                'shipping_fee' => $shipping_fee,
                'shipping_fee_reversal' =>$shipping_fee_reversal ,
                'net_shipping_fee' =>$net_shipping_fee ,
                'rep/refund' =>$refund ,
                'cogs' => $cogs,
                'store' => $store,
                'total_cost' => $total_cost,
                'revenue_passive' => $revenue_passive,
                'odr' => $odr,

                'cost_of_product' => $cost,
            ]
        );
        return back();

    }

    public function update(Request $request, Order $order, $id)
    {
        $coupon = Order::find($id);

        $coupon->sku  = $request->sku;
        $coupon->part_no  = $request->part_no;
        $coupon->cost  = $request->cost;
        $coupon->qty  = $request->qty;
        $coupon->fee  = $request->fee;
        $coupon->commission  = $request->commission;
        $coupon->shipping  = $request->shipping;
        $coupon->profit  = $request->profit;
        $coupon->save();


        if (isset($coupon->id)) {
          return response()->json(['message'=>'Niche Successfully Updated'],200);
        } else {
          return response()->json(['message'=>'Unable To Process Request'],500);
        }
    }




     public function uploadcsv(Request $request)
     {
    //   $request->validate([
    //         'file' => 'required|mimes:csv',
    //     ]);

        $fileName = rand(0,999).'_'.auth()->id().'_'.strtotime('now').'_ordercsv.'.$request->file->extension();


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


    public function en_con($a){
        $fs ='';

        for($i=0;$i<strlen($a);$i++){
        if (mb_check_encoding($a[$i])){
         $fs .= mb_convert_encoding($a[$i], "UTF-8", "auto");
        } else {

        }
        }


        return $fs;

    }



    public function insertcsv(Request $request ){




        $file = fopen(public_path('uploads').'/'.$request->file_name,"r");
         fgetcsv($file);
         $c = array();

             while(! feof($file))
  {
  $data = fgetcsv($file);
if ($request->poNumber == -1)        { $poNumber = ''; }        elseif (isset($data[$request->poNumber]))       { $poNumber = $data[$request->poNumber]; } else { $poNumber =''; }
if ($request->shippingName == -1)        { $shippingName = ''; }        elseif (isset($data[$request->shippingName]))       { $shippingName = $data[$request->shippingName]; } else { $shippingName =''; }
if ($request->shippingAddress1 == -1)        { $shippingAddress1 = ''; }        elseif (isset($data[$request->shippingAddress1]))       { $shippingAddress1 = $data[$request->shippingAddress1]; } else { $shippingAddress1 =''; }
if ($request->shippingAddress2 == -1)        { $shippingAddress2 = ''; }        elseif (isset($data[$request->shippingAddress2]))       { $shippingAddress2 = $data[$request->shippingAddress2]; } else { $shippingAddress2 =''; }
if ($request->shippingPostalCode == -1)        { $shippingPostalCode = ''; }        elseif (isset($data[$request->shippingPostalCode]))       { $shippingPostalCode = $data[$request->shippingPostalCode]; } else { $shippingPostalCode =''; }
if ($request->shippingCity == -1)        { $shippingCity = ''; }        elseif (isset($data[$request->shippingCity]))       { $shippingCity = $data[$request->shippingCity]; } else { $shippingCity =''; }
if ($request->shippingCountry == -1)        { $shippingCountry = ''; }        elseif (isset($data[$request->shippingCountry]))       { $shippingCountry = $data[$request->shippingCountry]; } else { $shippingCountry =''; }
if ($request->shippingRegion == -1)        { $shippingRegion = ''; }        elseif (isset($data[$request->shippingRegion]))       { $shippingRegion = $data[$request->shippingRegion]; } else { $shippingRegion =''; }
if ($request->sku == -1)        { $sku = ''; }        elseif (isset($data[$request->sku]))       { $sku = $data[$request->sku]; } else { $sku =''; }
if ($request->quantity == -1)        { $quantity = ''; }        elseif (isset($data[$request->quantity]))       { $quantity = $data[$request->quantity]; } else { $quantity =''; }
if ($request->sales_price == -1)        { $sales_price = ''; }        elseif (isset($data[$request->sales_price]))       { $sales_price = $data[$request->sales_price]; } else { $sales_price =''; }

if ($request->order_date == -1)        { $order_date = ''; }        elseif (isset($data[$request->order_date]))       { $order_date = $data[$request->order_date]; } else { $order_date =''; }


array_push($c,[
'poNumber' =>$this->en_con($poNumber),
'shippingName' =>$this->en_con($shippingName),
'shippingAddress1' =>$this->en_con($shippingAddress1),
'shippingAddress2' =>$this->en_con($shippingAddress2),
'shippingPostalCode' =>$this->en_con($shippingPostalCode),
'shippingCity' =>$this->en_con($shippingCity),
'shippingCountry' =>$this->en_con($shippingCountry),
'shippingRegion' =>$this->en_con($shippingRegion),
'sales_price' => $sales_price,
'order_date' => $order_date,
'shippingMethod' =>'REG',
'sku' =>$sku,
'store' =>$request->store,
'brandId' =>'',
'quantity' =>$quantity]);


    //   Order::create([
    //       'shop_url' => "autospartoutlet.myshopify.com",
    //       'order_json' => $data
    //       ]);





  }





  $e = array();
  $po = '';

  foreach ($c as $a) {
      // Check if essential fields are not empty
      if ($a['poNumber'] != '' && $a['shippingName'] != '' && $a['shippingAddress1'] != '' && $a['shippingPostalCode'] != '' && $a['shippingCity'] != '') {
          if ($po != '' && $po == $a['poNumber']) {
              // If the same poNumber is encountered, sum the sales_price to the existing entry
              $e[sizeof($e) - 1]['sales_price'] += $a['sales_price'];
              // Append the item details to the existing entry
              array_push($e[sizeof($e) - 1]['items'], [
                  $a['sku'],
                  $a['brandId'],
                  $a['quantity'],
                  $a['sales_price']
              ]);
          } else {
              // If a new poNumber is encountered, create a new entry in the result array
              $po = $a['poNumber'];
              array_push($e, [
                  'poNumber' => $a['poNumber'],
                  'shippingName' => $a['shippingName'],
                  'shippingAddress1' => $a['shippingAddress1'],
                  'shippingAddress2' => $a['shippingAddress2'],
                  'shippingPostalCode' => $a['shippingPostalCode'],
                  'shippingCity' => $a['shippingCity'],
                  'sales_price' => $a['sales_price'],
                  'order_date' => $a['order_date'],
                  'shippingCountry' => $a['shippingCountry'],
                  'shippingRegion' => $a['shippingRegion'],
                  'shippingMethod' => $a['shippingMethod'],
                  'store' => $a['store'],
                  'items' => [
                      [
                          $a['sku'],
                          $a['brandId'],
                          $a['quantity'],
                          $a['sales_price']
                      ]
                  ]
              ]);
          }
      }
  }


//  $e = mb_convert_encoding($e, "ASCII", "auto");





  return response()->json(['message'=>'Record Inserted Succesfully!','data'=>$e],200);


  $response = [];

 foreach($e as $ee){
      //print_r(json_encode($this->shopify_json($ee)));

    //   $t = new trqVendor();
    //  $order_vendor_response = $t->place_order(json_encode($this->shopify_json($ee)));
      $response[] = $this->shopify_json($ee);
    //   dd($order_vendor_response);


        //  Order::create([
        //   'shop_url' => "autospartoutlet.myshopify.com",
        //   'order_json' => json_encode($this->shopify_json($ee)),
        //   'vendor_json' => $order_vendor_response
        //   ]);


  }


            fclose($file);




        return response()->json(['message'=>'Record Inserted Succesfully!','data'=>$response],200);


    }
    public function exportCsvMonth()
    {


        $today = Carbon::now()->toDateString();


        $startDate = Carbon::now()->subDays(30)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $data = Order::whereBetween('created_at', [$startDate, $endDate])->get();
          $date = Carbon::now()->format('d-m-Y');
          $csvFileName = 'sheet' . $date . '.csv';

          $headers = array(
              "Content-type"        => "text/csv",
              "Content-Disposition" => "attachment; filename=$csvFileName",
              "Pragma"              => "no-cache",
              "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
              "Expires"             => "0"
          );

          $handle = fopen('php://temp', 'w+');

          // Add CSV headers
          fputcsv($handle, ['Po Number','Cost','Sales price','OrderDate']);

          // Add data rows
          foreach ($data as $row) {
            $json_data = json_decode($row->vendor_json);
              $po_number = $json_data->poNumber??'';
              $cost = $json_data->orderTotal??'';
              $orderDate = $json_data->orderDate??'';
              if($po_number!=''){
                  fputcsv($handle, [$po_number,$cost, $row->sales_price,$orderDate]);
              }
          }

          fseek($handle, 0);

          // Use the stream method to generate the file download
          return response()->stream(
              function () use ($handle) {
                  fpassthru($handle);
                  fclose($handle);
              },
              200,
              $headers
          );
    }


    public function exportCsvToday()
    {
      $today = Carbon::now()->toDateString();


      $startDate = Carbon::now()->subDays(30)->startOfDay();
      $endDate = Carbon::now()->endOfDay();

      $data = Order::whereDate('created_at', $today)->get();
        $date = Carbon::now()->format('d-m-Y');
        $csvFileName = 'sheet' . $date . '.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $handle = fopen('php://temp', 'w+');

        // Add CSV headers
        fputcsv($handle, ['Po Number','Cost','Sales price','OrderDate']);

        // Add data rows
        foreach ($data as $row) {
          $json_data = json_decode($row->vendor_json);
            $po_number = $json_data->poNumber??'';
            $cost = $json_data->orderTotal??'';
            $orderDate = $json_data->orderDate??'';
            if($po_number!=''){
                fputcsv($handle, [$po_number,$cost, $row->sales_price,$orderDate]);
            }
        }

        fseek($handle, 0);

        // Use the stream method to generate the file download
        return response()->stream(
            function () use ($handle) {
                fpassthru($handle);
                fclose($handle);
            },
            200,
            $headers
        );
    }

    public function exportToCsv(Request $request)
    {
       $store = isset($request->store)?$request->store:'';
       $data='';
       if($store !=''){
        $data = TrqProfit::where('store',$store)->get();
       }else{
           $data = TrqProfit::all();
       }

        $date = Carbon::now()->format('d-m-Y');
        $csvFileName = 'trq_profit_' . $date . '.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $handle = fopen('php://temp', 'w+');

        // Add CSV headers
        fputcsv($handle, ['Po number','Shipper name','Order date' , 'Sales price','Selling fees','Selling fee reverse','Net selling fee','TRQ Cost','Trq RTN', 'TRQ Net cost','Adjustment fee','Shipping fee','Shipping fee reversal','Net Shipping fee charged','Rep/Refund','COGS','Total cost','Revenue passive','ODR']);

        // Add data rows
        foreach ($data as $row) {
            fputcsv($handle, [$row->po_number,$row->shipper_name,$row->order_date , $row->sale_price, $row->selling_fees, $row->selling_fees_reverse,$row->net_selling_fee, $row->cost_of_product,$row->trq_rtn,
            $row->trq_net_cost,$row->adjustment_fee,$row->shipping_fee,$row->shipping_fee_reversal,$row->net_shipping_fee,$row->rep_or_refund,$row->cogs,$row->total_cost,$row->revenue_passive,$row->odr
          ]);
        }

        fseek($handle, 0);

        // Use the stream method to generate the file download
        return response()->stream(
            function () use ($handle) {
                fpassthru($handle);
                fclose($handle);
            },
            200,
            $headers
        );
    }




    public function csv_punch_order(Request $request){
      $orderDate = Carbon::parse($request->order_date);
        $requestData = $request->except('sales_price');
        $order=Order::where('order_json','LIKE','%"name":"'.$requestData['poNumber'].'"%')->where('vendor_json','LIKE','%"poNumber":"'.$requestData['poNumber'].'"%')->exists();
        if ($order===true) {
            $response ='{"error":"PO already submitted","message":"PO already submitted","status":400}';
            $response = json_decode($response);
            return response()->json($response);
        }
        $sales_price =isset($request->sales_price)?$request->sales_price:0;
        $trq =  DB::table('trq')->where('PartNumber', 'like', '%' . $requestData['items'][0][0] . '%')->first();
        $trqPrice = floatval($trq->price??0);
        $percent12 = 0.12;

        // Remove non-numeric characters, including the dollar sign ('$')
        $sales_price_numeric = (float) str_replace(['$', ','], '', $sales_price);

        $amazon_fee = $sales_price_numeric * $percent12;
        $sales_price_with_percentage = $trqPrice + $amazon_fee;
        $profit = (float) $sales_price_numeric - $sales_price_with_percentage;

        $t = new trqVendor();

        $order_vendor_response = ''; // Assuming this is declared earlier in your code

        if ($profit > 0) {
            // Place the order
            $order_vendor_response = $t->place_order(json_encode($this->shopify_json($requestData)));
        } else {
            // Handle the error case
            $order_vendor_response = '{"error":"ERR-AO100","message":"Cost price('.$trqPrice.'),sales price('.$sales_price.'),sale price with amazon fee('.$sales_price_with_percentage.') and profit is ('.$profit.')","status":400}';
        }

        // Check if $order_vendor_response contains "error" or "errors"
        if (strpos($order_vendor_response, 'error') !== false || strpos($order_vendor_response, 'errors') !== false) {
            // Update the record
            $punched_order = Order::create(
                [
                    'shop_url' => "autospartoutlet.myshopify.com",
                    'order_json' => json_encode($this->shopify_json($request)),
                    'vendor_json' => $order_vendor_response,
                    'user_id' => auth()->id(),
                    'store' => $request->store ?? '',
                ]
            );
        } else {
            // Update or insert the record
            $punched_order = Order::updateOrInsert(
                ['po_number' => $requestData['poNumber']],
                [
                    'shop_url' => "autospartoutlet.myshopify.com",
                    'order_json' => json_encode($this->shopify_json($request)),
                    'vendor_json' => $order_vendor_response,
                    'sales_price' => $sales_price_numeric,
                    'user_id' => auth()->id(),
                    'store' => $request->store ?? '',
                ]
            );
        }


        // $order = Order::where('po_number',$requestData['poNumber'])->first();
        $order_response = json_decode($order_vendor_response);

        // Assuming $order_response->orderDate contains the original date
        $originalDate = $order_response->orderDate??'';
        $shippingName = $order_response->shippingName??'';
        $shippingCost = $order_response->shippingCost??'';
        // Create a DateTime object from the original date
        $dateTime = new DateTime($originalDate);

        // Format the date in the desired format
        $formattedDate = $dateTime->format('d-M-Y');
        $revenue_passive = $sales_price_numeric - $trqPrice;
        $odrPercentage = ($revenue_passive / $sales_price_numeric) * 100;

        TrqProfit::updateOrCreate(
            ['po_number' => $requestData['poNumber']],
            [
                'sale_price' => $sales_price_numeric,

                'shipper_name' => $shippingName,
                'order_date' =>$formattedDate ,
                'store' => $request->store ?? '',
                'selling_fees' => '',
                'selling_fees_reverse' => '',
                'net_selling_fee' =>'' ,
                'trq_rtn' =>'' ,
                'net_cost' => '',
                'adjustment_fee' => '',
                'shipping_fee' => $shippingCost,
                'shipping_fee_reversal' =>'' ,
                'net_shipping_fee' =>'' ,
                'rep/refund' =>'' ,
                'cogs' => $trqPrice,
                'total_cost' => $trqPrice,
                'revenue_passive' => $revenue_passive,
                'odr' => $odrPercentage,

                'amazon_fee' => $amazon_fee,
                'cost_of_product' => $trqPrice,
                'profit' => $profit,
            ]
        );

          $order_vendor_response = json_decode($order_vendor_response);

         return response()->json($order_vendor_response);

    }








function shopify_json($data,$extra = null){
$items = array();
foreach ($data['items'] as $i) {
   $sku = isset($i[0])?$i[0]:$i['sku'];
   $quantity = isset($i[2])?$i[2]:$i['quantity'];
    $trq = DB::table('trq')->where('PartNumber','LIKE','%'.$sku.'%')->first();

    if (isset($trq->brand_abbr)){
        $brand = $trq->brand_abbr;
    }else {
        $brand ='';
    }


  array_push($items,['sku'=>$sku,'vendor'=>$brand,'quantity'=>$quantity]);
}

$json = array (
  'extra' => $extra,
  'name' => $data['poNumber'],
  'line_items' => $items,
  'shipping_address' =>
  array (
    'first_name' => $data['shippingName'],
    'address1' => $data['shippingAddress1'],
    'phone' => NULL,
    'city' => $data['shippingCity'],
    'zip' => $data['shippingPostalCode'],
    'province' => ' ',
    'country' => $data['shippingCountry'],
    'last_name' => ' ',
    'address2' => $data['shippingAddress2'],
    'company' => NULL,
    'latitude' => 38.6298052,
    'longitude' => -77.3267664,
    'name' => ' ',
    'country_code' => $data['shippingCountry'],
    'province_code' => $data['shippingRegion'],
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









public function insertsingleorder(Request $request){

    // dd($request->all());



  $e = [
'poNumber' => $request->poNumber,
'shippingName' => $request->shippingName,
'store' => $request->store??'',
'shippingAddress1' => $request->shippingAddress1,
'shippingAddress2' => $request->shippingAddress2,
'shippingPostalCode' => $request->shippingPostalCode,
'shippingCity' => $request->shippingCity,
'shippingCountry' => $request->shippingCountry,
'shippingRegion' => $request->shippingRegion,
'shippingMethod' => $request->shippingMethod,
'clientSegment' => $request->clientSegment,
'items'=>[]
        ];

        if ($request->items == null){
          return response()->json(['message'=>"Select atleast one item!"],500);
        }




   for($i=0;$i<sizeof($request->items);$i++){
        array_push($e['items'],[$request->items[$i],'',$request->quantity[$i]]);
   }






     $t = new trqVendor();
     $order_vendor_response = $t->place_order(json_encode($this->shopify_json($e,'single_order')));

    //   dd($order_vendor_response);



    $res = json_decode($order_vendor_response,true);




         Order::create([
          'shop_url' => "autospartoutlet.myshopify.com",
          'store' => $request->store??'',
          'order_json' => json_encode($this->shopify_json($e,'single_order')),
          'vendor_json' => $order_vendor_response
          ]);

       if (isset($res['id'])){
          return response()->json(['message'=>'Order Successfully Punched Order ID # '.$res['id']],200);

      }



    if (isset($res['error'])){
     return response()->json(['message'=>$res['error']],500);
    }


     if (isset($res['errors'])){
         $res['errors'] = implode("\n",$res['errors']);
     return response()->json(['message'=>$res['errors']],500);
    }



    return response()->json(['message'=>"Error!"],500);

}






















}
