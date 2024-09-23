<?php
include_once("../../inc/database.php");
include_once("../../inc/functions.php");
// include "/home/autoqete/public_html/miniapp/app/Http/Controllers/TrqTrait.php";
include "/home/apoconsole/app.apoconsole.com/app/Http/Controllers/TrqTrait.php";


function verify_webhook($data, $hmac_header){
    $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_SECRUT_KEY , true));
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
if($verified){
    $response = $data_json;
    
    
    $iiid = $response['id'];
     $order_id_check = $db->query("SELECT * FROM `orders_log` WHERE `order_json` LIKE '%$iiid%'");
    if (mysqli_num_rows($order_id_check) > 0) {
    die();
    }
    
    
    
    // $stmt = $pdo->prepare("SELECT * FROM `Request_formApp` WHERE shop_url=?  LIMIT 1 ");
    // $stmt->execute([$shop]);
    // $user = $stmt->fetch();
    	//*******************laravel team code ******************************************
    	$order_vendor_response = '';
    	if (count($response['shipping_lines']) > 0){
    	    $t = new trqVendor();
            $order_vendor_response = $t->place_order(json_encode($response)); 
    	}
	   
    	//*******************laravel team code ******************************************
    
    $statement = $pdo->prepare("INSERT INTO `orders_log` ( `shop_url`, `order_json`, `vendor_json` ) VALUES (:shop_url , :order_json, :order_vendor_response ) ");
	$statement->bindValue(':shop_url', $shop );
	$statement->bindValue(':order_json', json_encode($response) );
	$statement->bindValue(':order_vendor_response', $order_vendor_response );
	
	$check =  $statement->execute();
	if ($check) {
		$response = $data_json;
		// $response_array = json_decode($response,true);
	} else {
		$response = 'Error in Order Paid webHook...';
	}
}else{
    $response = 'This Request is not from shopify verified merchant...';
}
$log =  fopen($shop_Domain . "_order_paid.json", "a") or die("Can not open or paid this file.");
if (file_exists($shop_Domain . "_order_paid.json")) {
    fputs($log, PHP_EOL . json_encode($response));
} else {
    fputs($log, json_encode($response));
}
fclose($log);