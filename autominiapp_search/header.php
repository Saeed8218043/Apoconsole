<?php
require_once("inc/database");
require_once("inc/functions");

header('Content-Security-Policy: frame-ancestors *');

$requests = $_GET;
// echo print_r($requests);
$access_token = '';
$hmac = $requests['hmac'];
$serializeArray = serialize($requests);
$requests = array_diff_key($requests, array('hmac' => ''));
ksort($requests);

$url = parse_url('https://' . $requests['shop']);
$host = explode('.', $url['host']);

//  echo $host[0];
$host_shop = $host[0];
//echo $requests['shop'];   //  nimble-nws.myshopify.com
// header("Location: install.php?shop=". $requests['shop']);
// exit();

$shop = $requests['shop'];

// $statement = $pdo->prepare("SELECT * FROM `shopify_shop` WHERE `requests` = '". $url ."' LIMIT 1 ");
// $result = $statement->execute();

$stmt = $pdo->prepare("SELECT * FROM `auto_miniapp_shopify` WHERE shop_url=?  LIMIT 1 ");
$stmt->execute([$shop]);
$user = $stmt->fetch();

//  print_r($user['access_token']);
$access_token = $user['access_token'];

if (empty($user)) {
    header("Location: install.php?shop=" . $requests['shop']);
    exit();
} else {
    //echo 'App';
    //$theme = shopify_call($token, $host_shop, "/admin/api/2021-07/themes.json", array() , 'GET');
    //print_r($theme);
    //$theme = json_decode($theme['response'], JSON_PRETTY_PRINT);

    $chkProduct = $db->query("SELECT * from auto_miniapp_shopify WHERE shop_url='" .$shop . "' limit 1");
    if (mysqli_num_rows($chkProduct) == 0) {
        // update
        header("Location: install.php?shop=" . $requests['shop']);
        die("there is no access please reinstall discount app");
    }
    $result = mysqli_fetch_assoc($chkProduct);
    $token = $result['access_token']; //'';
    //$api_endpoint = "/admin/themes.json";
    // print_r($theme);
}
