<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\ShopifyOrder;
use Carbon\Carbon;
use App\Traits\trqVendor;

// include app_path('Http/Controllers/TrqTrait.php');

class ProcessOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $page;

    public function __construct($page)
    {
        $this->page = $page;
    }

    public function handle()
    {
             $t = new trqVendor();
           $allData = [];

               $ch = curl_init();
               curl_setopt($ch, CURLOPT_URL, "https://api1.trqautoparts.com/api/v3/orders?page=".$this->page."&size=400");
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
               curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'authorization: Bearer ' . $t->token,
                   'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
               ));

               $response = curl_exec($ch);
               curl_close($ch);
               $collection = collect(json_decode($response, true));

               if (isset($collection['error']) && $collection['status'] == 400) {
                // Log the error for debugging purposes
                echo ("Error fetching orders for page {$this->page}: {$collection['message']}");
                return;
            }


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
                  DB::table('orders_log')->upsert(
                      $allData,
                      ['po_number'], // The unique key to check for updates
                      ['vendor_json'], // The columns to update if the record already exists
                      ['created_at']

                  );
              } else {
                  // For example, you can log a message or take appropriate action
                  echo "No orders found in the response.";
              }
           // Update or insert the accumulated data into the database
    }

   public function shopify_json($data,$extra = null){
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
}

