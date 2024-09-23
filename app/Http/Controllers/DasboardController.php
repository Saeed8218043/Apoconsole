<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use DataTables;
use Carbon\Carbon;
use DB;
use App\Models\Fitment;
use App\Models\InventoryPrice;


class DasboardController extends Controller
{
   
   

     public function index()
    {
        
    $data = DB::select( 
          DB::raw('SELECT * FROM dashboard_log'))[0];
          $data = (array)$data;
   
      return view('pages.index',[
        'order_csv_30days_chart' => (json_decode($data['order_csv_30days_chart'],true)),
        'order_csv_30days_chart_label' => (json_decode($data['order_csv_30days_chart_label'],true)),
        'order_shopify_30days_chart' => (json_decode($data['order_shopify_30days_chart'],true)),
        'order_shopify_30days_chart_label' => (json_decode($data['order_shopify_30days_chart_label'],true)),
        'order_shopify_30days_today' => $data['order_shopify_30days_today'],
        'order_shopify_30days' => $data['order_shopify_30days'],
        'order_csv_30days_today' => $data['order_csv_30days_today'],
        'order_csv_30days' => $data['order_csv_30days'],
        'total_purchase_value_today' => $data['total_purchase_value_today'],
        'total_purchase_value' => $data['total_purchase_value'],
        'total_purchase_value_chart' => (json_decode($data['total_purchase_value_chart'],true)),
        'today_success_orders' => $data['today_success_orders'],
        'today_failed_orders' => $data['today_failed_orders'],
        'failed_orders_shopify'=>$data['failed_orders_shopify'],
        'failed_orders_csv' => $data['failed_orders_csv'],
        'last_shopify_update'=>$data['last_shopify_update'],
        'today_orders_shopify'=>$data['today_orders_shopify'],
        'today_orders_csv' => $data['today_orders_csv'],
        'total_products_synced'=>json_decode($data['total_products_synced']),
      ]);
        
       
    }
    
    
    
    public function run()
    {
        $data = DB::select( 
          DB::raw('SELECT * FROM dashboard_log'))[0];
          
          if ((strtotime('now')-strtotime($data->created_at)) < 1700){
              return false;
          }
        
        $order_shopify_30days_days = array();
        $order_csv_30days_days = array();
        $order_amount_30days_days = array();
          
          
        $i = 0;
        while ($i < 30) {
          array_push( $order_shopify_30days_days, Carbon::today()->subDays($i)->format('Y-m-d') );
          $i++;
           }
           
           $order_csv_30days_days = $order_shopify_30days_days;
           $order_amount_30days_days = $order_shopify_30days_days;
        

         // ----------------------------------------------------------------

        $total_purchase_value_chart = DB::select( 
          DB::raw('with recursive cte as (
                    select now() - INTERVAL 29 day as calendar_date
                    union all
                    select date_add(calendar_date, interval 1 day) as calendar_date from cte 
                    where calendar_date < now()
                  )
                  select SUM(JSON_EXTRACT(orders_log.vendor_json, "$.orderTotal")) AS Total
                  from cte
                  LEFT JOIN orders_log ON DATE_FORMAT( orders_log.created_at, "%m/%d/%Y") = DATE_FORMAT(cte.calendar_date, "%m/%d/%Y")
                  AND JSON_EXTRACT(orders_log.vendor_json, "$.orderTotal") IS NOT NULL 
                  GROUP BY cte.calendar_date'));
        $total_purchase_value_chart = array_map(function ($b)  { return round($b->Total,2); }, $total_purchase_value_chart);
        $total_purchase_value_today = end($total_purchase_value_chart);
        $total_purchase_value       = array_sum($total_purchase_value_chart);

          $order_shopify_30days_chart = DB::select( 
          DB::raw('with recursive cte as (
                    select now() - INTERVAL 29 day as calendar_date
                    union all
                    select date_add(calendar_date, interval 1 day) as calendar_date from cte 
                    where calendar_date < now()
                  )
                  select COUNT(orders_log.id) AS Total
                  from cte
                  LEFT JOIN orders_log ON DATE_FORMAT( orders_log.created_at, "%m/%d/%Y") = DATE_FORMAT(cte.calendar_date, "%m/%d/%Y")
                  AND JSON_EXTRACT(orders_log.order_json, "$.id") IS NOT NULL 
                                     AND   (
                                         JSON_EXTRACT(orders_log.vendor_json, "$.id") IS NOT NULL
                                     OR  JSON_EXTRACT(orders_log.vendor_json, "$.error") IS NOT NULL
                                     OR  JSON_EXTRACT(orders_log.vendor_json, "$.errors") IS NOT NULL
                                           )
                  GROUP BY cte.calendar_date'));
          $order_shopify_30days_chart = array_map(function ($b)  { return $b->Total; }, $order_shopify_30days_chart);
          $order_shopify_30days       = array_sum($order_shopify_30days_chart);
          $order_shopify_30days_today = end($order_shopify_30days_chart);
          $order_shopify_30days_chart_label = $order_shopify_30days_days;
            
          
          
          
          // ----------------------------------------------------
          $order_csv_30days_chart = DB::select( 
          DB::raw('with recursive cte as (
                    select now() - INTERVAL 29 day as calendar_date
                    union all
                    select date_add(calendar_date, interval 1 day) as calendar_date from cte 
                    where calendar_date < now()
                  )
                  select COUNT(orders_log.id) AS Total
                  from cte
                  LEFT JOIN orders_log ON DATE_FORMAT( orders_log.created_at, "%m/%d/%Y") = DATE_FORMAT(cte.calendar_date, "%m/%d/%Y")
                  AND JSON_EXTRACT(orders_log.order_json, "$.id") IS NULL 
                                     AND   (
                                         JSON_EXTRACT(orders_log.vendor_json, "$.id") IS NOT NULL
                                     OR  JSON_EXTRACT(orders_log.vendor_json, "$.error") IS NOT NULL
                                     OR  JSON_EXTRACT(orders_log.vendor_json, "$.errors") IS NOT NULL
                                           )
                  GROUP BY cte.calendar_date'));
          $order_csv_30days_chart       = array_map(function ($b)  { return $b->Total; }, $order_csv_30days_chart);
          $order_csv_30days             = array_sum($order_csv_30days_chart);
          $order_csv_30days_today       = end($order_csv_30days_chart);
          $order_csv_30days_chart_label = $order_csv_30days_days;
            
          
          // ---------------------------------------------------

          $today_success_orders = DB::select( 
          DB::raw('SELECT COUNT(id) AS Total FROM `orders_log` 
                   WHERE DATE_FORMAT(`created_at`, "%m/%d/%Y") = DATE_FORMAT(now(), "%m/%d/%Y")
                   AND  JSON_EXTRACT(`vendor_json`, "$.id") IS NOT NULL'))[0]->Total;
          $today_failed_orders = DB::select( 
          DB::raw('SELECT COUNT(id) AS Total FROM `orders_log` 
                   WHERE DATE_FORMAT(`created_at`, "%m/%d/%Y") = DATE_FORMAT(now(), "%m/%d/%Y")
                   AND   (
                       JSON_EXTRACT(`vendor_json`, "$.error") IS NOT NULL
                   OR  JSON_EXTRACT(`vendor_json`, "$.errors") IS NOT NULL
                         )'))[0]->Total;

          // ---------------------------------------------------

          $today_orders_shopify = DB::select( 
          DB::raw('SELECT COUNT(id) AS Total FROM `orders_log` 
                   WHERE (
                       JSON_EXTRACT(`order_json`, "$.id") IS NOT NULL
                   AND  JSON_EXTRACT(`vendor_json`, "$.id") IS NOT NULL
                         )'))[0]->Total;
          $today_orders_csv = DB::select( 
          DB::raw('SELECT COUNT(id) AS Total FROM `orders_log` 
                   WHERE (
                       JSON_EXTRACT(`order_json`, "$.id") IS NULL
                   AND  JSON_EXTRACT(`vendor_json`, "$.id") IS NOT NULL
                         )'))[0]->Total;

          // ---------------------------------------------------

          $failed_orders_shopify = DB::select( 
          DB::raw('SELECT COUNT(id) AS Total FROM `orders_log` 
                   WHERE  JSON_EXTRACT(`order_json`, "$.id") IS NOT NULL
                   AND
                        (   
                        JSON_EXTRACT(`vendor_json`, "$.error") IS NOT NULL
                   OR   JSON_EXTRACT(`vendor_json`, "$.errors") IS NOT NULL
                         )'))[0]->Total;
          $failed_orders_csv = DB::select( 
          DB::raw('SELECT COUNT(id) AS Total FROM `orders_log` 
                   WHERE  JSON_EXTRACT(`order_json`, "$.id") IS NULL
                   AND
                        (   
                        JSON_EXTRACT(`vendor_json`, "$.error") IS NOT NULL
                   OR   JSON_EXTRACT(`vendor_json`, "$.errors") IS NOT NULL
                         )'))[0]->Total;

          // ---------------------------------------------------
          
        
        
        
        $last_shopify_update = InventoryPrice::where('shopify_update',1)->orderBy('id', 'desc')->first();
        $total_products_synced[0] = InventoryPrice::where('shopify_update',1)->where('vendor',1)->count();
        $total_products_synced[1] = InventoryPrice::where('shopify_update',1)->where('vendor',2)->count();
        $last_shopify_update = (isset($last_shopify_update->updated_at)) ? \Carbon\Carbon::parse($last_shopify_update->updated_at)->diffForHumans() : '';
        
      
        DB::statement("UPDATE `dashboard_log` SET 
                `order_csv_30days_chart`='".(json_encode(($order_csv_30days_chart)))."',
                `order_csv_30days_chart_label`='".(json_encode(array_reverse($order_csv_30days_chart_label)))."',
                `order_shopify_30days_chart`='".(json_encode(($order_shopify_30days_chart)))."',
                `order_shopify_30days_chart_label`='".(json_encode(array_reverse($order_shopify_30days_chart_label)))."',
                `order_shopify_30days_today`='".($order_shopify_30days_today)."',
                `order_shopify_30days`='".($order_shopify_30days)."',
                `order_csv_30days_today`='".($order_csv_30days_today)."',
                `order_csv_30days`='".($order_csv_30days)."',
                `total_purchase_value_today`='".($total_purchase_value_today)."',
                `total_purchase_value`='".($total_purchase_value)."',
                `total_purchase_value_chart`='".(json_encode($total_purchase_value_chart))."',
                `today_success_orders`='".($today_success_orders)."',
                `today_failed_orders`='".($today_failed_orders)."',
                `failed_orders_shopify`='".($failed_orders_shopify)."',
                `failed_orders_csv`='".($failed_orders_csv)."',
                `last_shopify_update`='".($last_shopify_update)."',
                `today_orders_shopify`='".($today_orders_shopify)."',
                `today_orders_csv`='".($today_orders_csv)."',
                `total_products_synced`='".(json_encode($total_products_synced))."',
                `created_at`=NOW(),
                `updated_at`=NOW()
                WHERE id=1");
   
       dd("UPDATE `dashboard_log` SET 
                `order_csv_30days_chart`='".(json_encode(($order_csv_30days_chart)))."',
                `order_csv_30days_chart_label`='".(json_encode(array_reverse($order_csv_30days_chart_label)))."',
                `order_shopify_30days_chart`='".(json_encode(($order_shopify_30days_chart)))."',
                `order_shopify_30days_chart_label`='".(json_encode(array_reverse($order_shopify_30days_chart_label)))."',
                `order_shopify_30days_today`='".($order_shopify_30days_today)."',
                `order_shopify_30days`='".($order_shopify_30days)."',
                `order_csv_30days_today`='".($order_csv_30days_today)."',
                `order_csv_30days`='".($order_csv_30days)."',
                `total_purchase_value_today`='".($total_purchase_value_today)."',
                `total_purchase_value`='".($total_purchase_value)."',
                `total_purchase_value_chart`='".(json_encode($total_purchase_value_chart))."',
                `today_success_orders`='".($today_success_orders)."',
                `today_failed_orders`='".($today_failed_orders)."',
                `failed_orders_shopify`='".($failed_orders_shopify)."',
                `failed_orders_csv`='".($failed_orders_csv)."',
                `last_shopify_update`='".($last_shopify_update)."',
                `today_orders_shopify`='".($today_orders_shopify)."',
                `today_orders_csv`='".($today_orders_csv)."',
                `total_products_synced`='".(json_encode($total_products_synced))."'
                WHERE id=1");
    }

 
   

}
