<?php
 set_time_limit(2700);
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
 
     if (!auth()->user()->is_admin()){
         $model = $model->where('user_id',auth()->id());
     }
     foreach ($model as $data) {
      $vendorJsonData = json_decode($data->vendor_json);
      if ($vendorJsonData !== null && property_exists($vendorJsonData, 'poNumber')) {
        //Order::where('id', $data->id)->update(['po_number' => $vendorJsonData->poNumber]);
        Order::where('id', $data->id)->update(['po_number' => $vendorJsonData->poNumber]);
      }
     }

     for($i=0;$i<4;$i++){
     $t = new trqVendor();
     $ch = curl_init(); 
     
     curl_setopt($ch, CURLOPT_URL, "https://api1.trqautoparts.com/api/v3/orders?page=$i&size=400");
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
         'authorization: Bearer '.$t->token,
         'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
     ));
     $response = curl_exec($ch);
     curl_close($ch);
     
         $collection = collect(json_decode($response));
         foreach ($collection['_embedded']->orders as $data) {
          // $vendorJsonData = json_decode($data->vendor_json);
          DB::table('updated_orders')
              ->updateOrInsert(
                  ['po_number' => $data->poNumber],
                  ['vendor_json' => json_encode($data)]
              );
        }
     }
              // DB::table('orders_log')
              //     ->join('updated_orders', 'orders_log.po_number', '=', 'updated_orders.po_number')
              //     ->update(['orders_log.vendor_json' => DB::raw('updated_orders.vendor_json')]);
              DB::statement('
                      UPDATE orders_log
                      JOIN updated_orders ON orders_log.po_number = updated_orders.po_number
                      SET orders_log.vendor_json = updated_orders.vendor_json
                  ');
?>