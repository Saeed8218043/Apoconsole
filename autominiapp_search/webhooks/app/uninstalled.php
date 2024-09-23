<?php
include_once("../../inc/database.php");
include_once("../../inc/functions.php");


function verify_webhook($data, $hmac_header){
    $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_SECRUT_KEY, true));
    return hash_equals($hmac_header, $calculated_hmac);
}

$response = '';
$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$shop_Domain = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];
$data = file_get_contents('php://input');
$utf8 = utf8_encode($data);
$data_json = json_decode($utf8, true);

///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////

$verified = verify_webhook($data, $hmac_header);
if($verified){

    $statement = $pdo->prepare("DELETE FROM `auto_miniapp_shopify` WHERE `shop_url` = '" . $shop_Domain . "' LIMIT 1 ");
    $statement->execute();
    $response =  $data_json;

}else{
    $response = 'This Request is not from shopify verified merchant...';
}
$log =  fopen($shop_Domain . "_uninstalled.json", "a") or die("Can not open or create this file.");

if (file_exists($shop_Domain . "_uninstalled.json")) {
    fputs($log, PHP_EOL . $shop_Domain .' is successfully deleted from the database.'  . PHP_EOL . json_encode($response) );
} else {
    fputs($log, json_encode($response));
}
fclose($log);
// GET /search/suggest.json?q=<query>&resources[type]=product
