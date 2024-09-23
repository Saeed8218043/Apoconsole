<?php

namespace App\Http\Controllers;

use App\Models\InventoryPrice;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use DB;
use App\Models\Vendor;

class ShopifyController extends Controller
{
    
    function __construct()
    {
       ini_set('max_execution_time', -1);
    }
    
    public function sync_product($prod,$a){
        // $prod['available'] = false;
        $prod['up_price']  = true;
        $prod['up_qty']  = false;
        
      
        // $a = DB::select( DB::raw("SELECT * FROM inventory_prices WHERE sku = '".$prod['sku']."'") );
       if (!isset($a->id)){
           $prod['available'] = false;
           $prod['price'] = '0.00';
           return $prod;
       }
       
        if ($prod['available'] && $a->qty < 0){
            $prod['up_qty']  = true;
        }
        if (!$prod['available'] && $a->qty > 0){
            $prod['up_qty']  = true;
        }
        
         if($a->mapped>0){
            $price = $a->mapped;
        }else{
            $price = $a->cost+$a->fee+$a->shipping+$a->commission+$a->profit;
        }
        // if (abs($prod['price']-($price)) > 1){
        //      $prod['up_price']  = true;
        // }
       
       
       $prod['qty'] = $a->qty;
       $prod['price'] = number_format($price,2);
       
       if ($a->qty == 0){
           $prod['available'] = false;
           return $prod;
       }
       
       if ($a->qty > 0){
           $prod['available'] = true;
       }
       
       
       return $prod;
    }
  
    public function product(Request $request){
        $_POST = json_decode(file_get_contents("php://input"), true);
        $update = false;
        $a = DB::table('inventory_prices')
        ->selectRaw('inventory_prices.*, shopify_update.updated')
        ->leftJoin('shopify_update', 'inventory_prices.part_no', '=', 'shopify_update.sku')
        ->where('inventory_prices.part_no',$_POST['sku'])
        ->first();
        
        if ($_POST['available'] && isset($a->id) && $a->qty != $_POST['qty']){
            $update =true;
        }
        
        $ret = $this->sync_product($_POST,$a);
        
        if ($ret['up_price'] || $ret['up_qty']){
            $update =true;
        }
        
               if (isset($a->id) && $update && ($a->updated === 1 || $a->updated === null)){
            // DB::statement("INSERT INTO `shopify_update`(`sku`, `vid`, `shopify_price`, `shopify_qty`) VALUES ('".$_POST['sku']."','".$_POST['id']."','".$_POST['price']."','".$_POST['qty']."')");

                // Assuming $_POST contains sanitized input, consider using prepared statements for security
    $sku = $_POST['sku'];
    $id = $_POST['id'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];

    // Check if the SKU exists in the table
    $existingRecord = DB::table('shopify_update')->where('sku', $sku)->first();

    if ($existingRecord) {
        // If the SKU exists, update the existing record using raw SQL
        DB::statement("
            UPDATE `shopify_update`
            SET `vid` = '$id', `shopify_price` = '$price', `shopify_qty` = '$qty', updated = 0
            WHERE `sku` = '$sku'
        ");
    } else {
        DB::statement("INSERT INTO `shopify_update`(`sku`, `vid`, `shopify_price`, `shopify_qty`) VALUES ('".$_POST['sku']."','".$_POST['id']."','".$_POST['price']."','".$_POST['qty']."')");

        // If the SKU doesn't exist, you can choose to do nothing or handle it accordingly
        // Here, I'm not performing any action, but you may modify this part based on your requirement
    }
        }
        
        
       
        return $ret;
        // dd($request->all());
    }
    
    
    public function collectionproduct(){
        $res=[];
        $skus=[];
        foreach($_POST['collection_prodcut_data'] as $k => $product){
        $skus[] = $product['variants'][0]['sku'];
        }
        
        // return $_POST['collection_prodcut_data'];
        
        
        $all = DB::table('inventory_prices')
        ->selectRaw('inventory_prices.*, shopify_update.updated')
        ->leftJoin('shopify_update', 'inventory_prices.part_no', '=', 'shopify_update.sku')
        ->whereIn('inventory_prices.part_no', $skus)
        ->get();
        
        
        
        $up_que = '';
        
      foreach($_POST['collection_prodcut_data'] as $k => $product){
          $product['variants'][0]['price'] = $product['variants'][0]['price']/100;
          $a =  (object)[];
          foreach($all as $p) {
              if ($product['variants'][0]['sku'] == $p->sku){ $a = $p; break;  }
          }
          $b = $this->sync_product($product['variants'][0],$a);
          
          if (isset($a->id) && ($a->updated === 1 || $a->updated === null)){
              if ($b['up_price'] || $b['up_qty']){
                  $up_que .= "REPLACE INTO `shopify_update`(`sku`, `vid`, `shopify_price`) VALUES ('".$product['variants'][0]['sku']."','".$product['variants'][0]['id']."','".$product['variants'][0]['price']."'); \n";
              }
          }
          
          $res[] = $b;
      }
        if (strlen($up_que) > 20){
            DB::unprepared($up_que);
        }
        return $res;
    }
    
}
