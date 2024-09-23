<?php
include_once("../../inc/database.php");
include_once("../../inc/functions.php");
// include "/home/apoconsole/app.apoconsole.com/app/Http/Controllers/TrqTrait.php";
include "/home/apoconsole/app.apoconsole.com/app/Http/Controllers/TrqTrait.php";

function verify_webhook($data, $hmac_header)
{
    $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_SECRUT_KEY, true));
    return hash_equals($hmac_header, $calculated_hmac);
}
$response = '';
$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$shop_Domain = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];
$data = file_get_contents('php://input');
$utf8 = utf8_encode($data);
$data_json = json_decode($utf8, true);
$verified = verify_webhook($data, $hmac_header);
//////////////////////////////////////////////////////////////////////////////////////
$url = parse_url('https://' . $shop_Domain);
$host = explode('.', $url['host']);
$host_shop = $host[0];
$shop = $shop_Domain;
//////////////////////////////////////////////////////////////////////////////////////
if ($verified) {
    $response = $data_json;
    // print_r($response['line_items'][0]['vendor']);

    $final_line_item_array = array();
    $No_of_vendors_in_json = 0;
    $vendor_check_Array__ = ['TRQ', 'AUTOOUTLET','DIY Solutions','Trail Ridge'];


    $final_line_item_array = Get_separated_vendors_Array( $response , $vendor_check_Array__  , "line_items");


    $final_line_item_array = array_filter($final_line_item_array, function($value) {
         return count($value) > 0;
	});


    if( !is_null( $final_line_item_array ) ){
        $No_of_vendors_in_json = count($final_line_item_array);
    }
    $Vendor_seprating_json = $final_line_item_array;

    $iiid = $response['id'];
    $order_id_check = $db->query("SELECT * FROM `shopify_orders_log` WHERE `order_json` LIKE '%$iiid%'");

    if (mysqli_num_rows($order_id_check) > 0) {
        die();
    }

    foreach ($Vendor_seprating_json as $key => $V_json) {

        $temp_response = [];
        $temp_response = $response;
        // $temp_response = array_replace($temp_response, $temp_response['line_items'] , $V_json  );
        // $stmt = $pdo->prepare("SELECT * FROM `Request_formApp` WHERE shop_url=?  LIMIT 1 ");
        // $stmt->execute([$shop]);
        // $user = $stmt->fetch();
        $temp_response['line_items'] = $V_json;

        //*******************************************************************************
        //*******************laravel team code ******************************************
        //*******************************************************************************
        $order_vendor_response = '';
        if (count($temp_response['shipping_lines']) > 0) {
            // $t = new trqVendor();
            // $order_vendor_response = $t->place_order(json_encode($temp_response));
        }
        //*******************************************************************************
        //*******************laravel team code ******************************************
        //*******************************************************************************

        $statement = $pdo->prepare("INSERT INTO `shopify_orders_log` ( `shop_url`, `order_json`, `vendor_json` ) VALUES (:shop_url , :order_json, :order_vendor_response ) ");
        $statement->bindValue(':shop_url', $shop);
        $statement->bindValue(':order_json', json_encode($temp_response));
        $statement->bindValue(':order_vendor_response', $order_vendor_response);
        $check =  $statement->execute();

        if ($check) {
            // $response = $data_json; // commented out for test else uncomment it ....
            // $response_array = json_decode($response,true);
        } else {
            $response = 'Error in Order Paid webHook...';
        }

    }

} else {
    $response = 'This Request is not from shopify verified merchant...';
}
$log =  fopen($shop_Domain . "_order_paid.json", "a") or die("Can not open or paid this file.");
if (file_exists($shop_Domain . "_order_paid.json")) {
    fputs($log, PHP_EOL . json_encode($response));
} else {
    fputs($log, json_encode($response));
}
fclose($log);

    /*
        $line_items__temp = $response['line_items'];
        // $final_line_item_Temp = array(
        //     "TRQ" => array(),
        //     "AUTOOUTLET" => array()
        // );
        $final_line_item_Temp = array();
        for ($i = 0; $i < count($vendor_check_Array); $i++) {
            $final_line_item_Temp[ $vendor_check_Array[$i] ] = array();
        }

        foreach ($line_items__temp as $key => $line_items__temp_value) {
            if (isset($line_items__temp_value['vendor'])) {
                for ($i = 0; $i < count($vendor_check_Array); $i++) {
                    if ($line_items__temp_value['vendor'] == $vendor_check_Array[$i]) {
                        // array_push($final_line_item_Temp[$i] , $line_items__temp_value);
                        $temp__Array = $final_line_item_Temp[ $vendor_check_Array[$i] ];
                        array_push(  $temp__Array , $line_items__temp_value );
                        $final_line_item_Temp[ $vendor_check_Array[$i] ] = $temp__Array;
                    }
                }
            }
        }
        print_r($final_line_item_Temp);
    */
function Get_separated_vendors_Array( $response__ , $vendor_check_Array__  , $line_items_tag = "line_items"){
    $No_of_vendors_in_json = 0;
    // $vendor_check_Array = ['TRQ', 'AUTOOUTLET'];
    $vendor_check_Array = $vendor_check_Array__;
    // $line_items__temp = $response__['line_items'];
    $line_items__temp = $response__[ $line_items_tag ];
    $final_line_item_Temp = array();

    for ($i = 0; $i < count($vendor_check_Array); $i++) {
        $final_line_item_Temp[ $vendor_check_Array[$i] ] = array();
    }

    foreach ($line_items__temp as $key => $line_items__temp_value) {
        if (isset($line_items__temp_value['vendor'])) {
            for ($i = 0; $i < count($vendor_check_Array); $i++) {
                if ($line_items__temp_value['vendor'] == $vendor_check_Array[$i]) {
                    // array_push($final_line_item_Temp[$i] , $line_items__temp_value);
                    $temp__Array = $final_line_item_Temp[ $vendor_check_Array[$i] ];
                    array_push(  $temp__Array , $line_items__temp_value );
                    $final_line_item_Temp[ $vendor_check_Array[$i] ] = $temp__Array;
                }
            }
        }
    }
    // print_r($final_line_item_Temp);
    return $final_line_item_Temp;

}
