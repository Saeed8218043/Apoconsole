<?php
ini_set('max_execution_time', '0');
$cmd = shell_exec('ps -ef |grep "php"');
// echo $cmd;
if (substr_count($cmd, '/home/apoconsole/app.apoconsole.com/miniapp_shopify/cron_job__sync_price_quantity_with_Shopify___part2.php') > 1) {
    echo "already Running";
    die();
}
// die();
chdir('/home/apoconsole/app.apoconsole.com/miniapp_shopify/');
echo "Updating Price and Quantity";
require "./inc/database.php";
require "./inc/functions.php";

$starttime = microtime(true); // Top of page
$Total__products__updated = 0;
$GOTDB___products_result = null;
$access_token = "";
$host_shop = "";
// die();
// $db->query("UPDATE `inventory_prices` SET shopify_update = 0 ");
$GetDB_Shopify_App_DATA = $db->query("SELECT * FROM `auto_miniapp_shopify` WHERE `shop_url` = 'autospartoutlet.myshopify.com' LIMIT 1 ");

if (mysqli_num_rows($GetDB_Shopify_App_DATA) > 0) {
    $GetDB_Shopify_SHOP = mysqli_fetch_all($GetDB_Shopify_App_DATA);
}

if (sizeof($GetDB_Shopify_SHOP) > 0) {
    foreach ($GetDB_Shopify_SHOP as $shop__key => &$shop__value) {
        $host_shop = Get_host_shop($shop__value[1]);
        $access_token = ($shop__value[2]);
    }
}
// $GetDB_products = $db->query("SELECT `inventory_prices`.id ,`inventory_prices`.sku , ( `inventory_prices`.cost + `inventory_prices`.fee + `inventory_prices`.`commission` + `inventory_prices`.`shipping` + `inventory_prices`.`profit`) as `net_price` ,`inventory_prices`.qty ,`shopify_product_details`.`v_id` , `shopify_product_details`.`p_id` , `shopify_product_details`.`inventory_item_id`,`shopify_product_details`.`location_id`,`shopify_product_details`.`inventory_quantity`, `shopify_product_details`.`available_adjustment` FROM `inventory_prices` LEFT JOIN `shopify_product_details` ON `inventory_prices`.`sku` = `shopify_product_details`.`sku` WHERE `inventory_prices`.`location_inventory_id_check` = 1 AND `inventory_prices`.`shopify_update` = 0 ");

$GetDB_products = $db->query("SELECT `inventory_prices`.id ,`inventory_prices`.sku , ( `inventory_prices`.cost + `inventory_prices`.fee + `inventory_prices`.`commission` + `inventory_prices`.`shipping` + `inventory_prices`.`profit`) as `net_price` ,`inventory_prices`.qty ,`shopify_product_details`.`v_id` , `shopify_product_details`.`p_id` , `shopify_product_details`.`inventory_item_id`,`shopify_product_details`.`location_id`,`shopify_product_details`.`inventory_quantity`, `shopify_product_details`.`available_adjustment` FROM `inventory_prices` INNER JOIN `shopify_product_details` ON `shopify_product_details`.`sku` = inventory_prices.part_no WHERE `inventory_prices`.`location_inventory_id_check` = 1 AND `inventory_prices`.`shopify_update` = 0 ");

if (mysqli_num_rows($GetDB_products) > 0) {
    $GOTDB___products_result = mysqli_fetch_all($GetDB_products);
} else {
    $db->query("UPDATE `inventory_prices` SET shopify_update = 0 ");
    echo "Done all Products";
    $f = fopen('update_status.txt','a');
    fwrite($f,"Done all Products on ".date('d-m-Y h:i:s A')."\n");
    fclose($f);
    exit();
}
// echo "Hello";
// print_r($GOTDB___products_result[0]);
// die();
$f = fopen('shopify.txt','a');
$Total__products__updated = 0;
if (sizeof($GOTDB___products_result) > 0) {
    foreach ($GOTDB___products_result as $key => $value) :
        $Total__products__updated = $Total__products__updated + 1;
        // echo "SKU  ---> ". $value[1];
        // echo "price  ---> ". $value[2];

        // echo "available_adjustment  ---> ". $value['available_adjustment'];
        // echo "inventory_item_id  ---> ". $value['inventory_item_id'];
        // echo "location_id  ---> ". $value['location_id'];
        // echo PHP_EOL;
    
        // ----------------------------------------------    Adjusting the price & counts of products  START      //
        $rr = Adject_Price__Function($access_token, $host_shop, "2022-04", $value[4], $value[2]);
        //echo $r;
        // print_r($value);
        $date = date('Y-m-d h:i:s');
        // echo $date."<br>";
         $db->query("UPDATE `inventory_prices` SET shopify_update = 1, updated_at = '$date' WHERE sku = '$value[1]'");
        if (isset($value[7]) && isset($value[6]) && isset($value[9])) :
            if ($value[7] != ""  &&  $value[6] != "") {
                echo "updated ".$value[1]."<br>";
                $r = Adject_Quantity__Function($access_token, $host_shop, "2022-04", $value[7], $value[6], $value[9]);
                $check_if_sku_exist_in_db = $db->query("SELECT * FROM `shopify_product_details` WHERE `sku` = '$value[1]' ");
                // echo "SELECT * FROM `shopify_product_details` WHERE `sku` = '$temp_db_product_sku' " . PHP_EOL ;
                if (mysqli_num_rows($check_if_sku_exist_in_db) > 0) {
                    $res = $db->query("UPDATE `shopify_product_details` SET `inventory_quantity` = '". ( (int)$value[8] + (int)$value[9] ) ."', `available_adjustment` = 0 WHERE `sku` = '$value[1]' ");
                    // print_r($res);
                }
                fwrite($f,$date."  ");
                fwrite($f,"sku: ".$value[1]." (".$value[2].") (".$value[3].") ".$rr);
                //echo $r;
                fwrite($f,"\n");
                fwrite($f,$r);
                fwrite($f,"\n");
            }
        //die();
        usleep( 500 * 1000 ); // 2 requests and 4 requests in one second  
        endif;
    // ----------------------------------------------    Adjusting the price & counts of products   END       //
    endforeach;
}
fwrite($f,"--------------------------------------------------------------------------------------------------------\n");
fclose($f);
$endtime = microtime(true); // Bottom of page
printf("Page loaded in %f seconds", $endtime - $starttime );
echo PHP_EOL;
echo "Done Updating ". $Total__products__updated ." Products...";
