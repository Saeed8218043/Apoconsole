<?php
header('Access-Control-Allow-Origin: *');
header('Content-Security-Policy: frame-ancestors *');
include_once("./inc/database.php");
include_once("./inc/functions.php");


$requests = $_GET;
// echo print_r($requests);
$access_token = '';
$hmac = $requests['hmac'];
$serializeArray = serialize($requests);
$requests = array_diff_key($requests, array('hmac' => ''));
ksort($requests);

$url = parse_url('https://' . $requests['shop']);
$host = explode('.', $url['host']);
$host_shop = $host[0];
$shop = $requests['shop'];

// $statement = $pdo->prepare("SELECT * FROM `shopify_shop` WHERE `requests` = '". $url ."' LIMIT 1 ");
// $result = $statement->execute();
$stmt = $pdo->prepare("SELECT * FROM `auto_miniapp_shopify` WHERE shop_url=?  LIMIT 1 ");
$stmt->execute([$shop]);
$user = $stmt->fetch();
// print_r($user);
$access_token = $user['access_token'];

// print_r([$user,$requests]); exit();

if (true || empty($user)) {
    header("Location: install.php?shop=" . $requests['shop']);
    exit();
} else {

    $chkProduct = $db->query("SELECT * from auto_miniapp_shopify WHERE shop_url='" . $shop . "' limit 1");
    if (mysqli_num_rows($chkProduct) == 0) {
        // update
        header("Location: install.php?shop=" . $requests['shop']);
        die("there is no access please reinstall discount app");
    }
    $result = mysqli_fetch_assoc($chkProduct);
    $access_token = $result['access_token']; //
}

echo Domain_URL_;

$array = array(
    "webhook" => array(
        "topic"   => "app/uninstalled",
        "address" =>  Domain_URL_ . "/webhooks/app/uninstalled.php",
        "format"  => "json"
    )
);

$webhook = shopify_call($access_token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
print_r($webhook);   // only one time print


// $array = array(
//     "webhook" => array(
//         "topic"   => "orders/create",
//         "address" =>  Domain_URL_ . "/webhooks/orders/create.php",
//         "format"  => "json"
//     )
// );
// $webhook = shopify_call($access_token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
// $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
// print_r($webhook);   // only one time print


$array = array(
    "webhook" => array(
        "topic"   => "orders/paid",
        "address" =>  Domain_URL_ . "/webhooks/orders/paid.php",
        "format"  => "json"
    )
);
print_r($array);
$webhook = shopify_call($access_token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
// $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
print_r($webhook);


function  PRODUCTS____REQUEST($access_token, $host_shop, $version, $query, $ARRAY,  $METHOD)
{
    $getProducts = shopify_call($access_token, $host_shop, "/admin/api/" . $version . $query, $ARRAY, $METHOD);
    $getProducts = json_decode(($getProducts['response']), true);
    return $getProducts;
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lobster|Josefin+Sans|Shadows+Into+Light|Pacifico|Amatic+SC:700|Orbitron:400,900|Rokkitt|Righteous|Dancing+Script:700|Bangers|Chewy|Sigmar+One|Architects+Daughter|Abril+Fatface|Covered+By+Your+Grace|Kaushan+Script|Gloria+Hallelujah|Satisfy|Lobster+Two:700|Comfortaa:700|Cinzel|Courgette' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lobster|Josefin+Sans|Shadows+Into+Light|Pacifico|Amatic+SC:700|Orbitron:400,900|Rokkitt|Righteous|Dancing+Script:700|Bangers|Chewy|Sigmar+One|Architects+Daughter|Abril+Fatface|Covered+By+Your+Grace|Kaushan+Script|Gloria+Hallelujah|Satisfy|Lobster+Two:700|Comfortaa:700|Cinzel|Courgette' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <title>Document</title>
</head>
<style>
    .overlay {
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255, 255, 255, 0.8) url("./images/loader.gif") center no-repeat;
    }

    body {
        text-align: center;
    }

    /* Turn off scrollbar when body element has the loading class */
    body.loading {
        overflow: hidden;
    }

    /* Make spinner image visible when body element has the loading class */
    body.loading .overlay {
        display: block;
    }
</style>

<body class="loading">
    <div class="overlay"></div>
    <div class="container">
        Hello --------> <?php echo $access_token; ?>
    </div>

    <?php

    //     Create cron Job after 30 ~ 60 minutes in curl phpMyadmin
    //     https://autooutletllc.com/miniapp_shopify/cron_job__sync_price_quantity_with_Shopify.php


    // $LOADING____CHECK = true;
    // require "Get__prodcts_compare_with_Shopify.php";
    // $ARRAY___ToUpdate_In_Shopify_ARRAY_FINAL = array();
    // $ARRAY___ToUpdate_In_Shopify_ARRAY_FINAL = $ARRAY___ToUpdate_In_Shopify_ARRAY;
    // // // print_r($ARRAY___ToUpdate_In_Shopify_ARRAY_FINAL);
    // if (count($ARRAY___ToUpdate_In_Shopify_ARRAY_FINAL) > 0) {
    //     foreach ($ARRAY___ToUpdate_In_Shopify_ARRAY_FINAL as $key => $value) {
    //         /* 
    //                 echo "v_ID  ---> ". $value['v_id'];
    //                 echo "price  ---> ". $value['price'];
    //                 echo "available_adjustment  ---> ". $value['available_adjustment'];
    //                 echo "inventory_item_id  ---> ". $value['inventory_item_id'];
    //                 echo "location_id  ---> ". $value['location_id'];
    //                 echo PHP_EOL;
    //             */
    //         // Adject_Price__Function($access_token , $host_shop , "2022-04" , $value['v_id'] , $value['price'] );
    //         // if($value['location_id'] != ""  &&  $value['inventory_item_id'] != "" && $value['available_adjustment'] != 0 ){
    //         //     Adject_Quantity__Function($access_token , $host_shop , "2022-04" , $value['location_id'] , $value['inventory_item_id'] ,$value['available_adjustment']);
    //         // }

    //     }
    //     $LOADING____CHECK = $LOADING____CHECK__;
    // }

    ?>


    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <!-- jQuery library -->
    <script>
        setInterval(() => {
            if (<?php echo $LOADING____CHECK; ?> == false) {
                $("body").removeClass("loading");
            }
        }, 1000);

        
    </script>


</body>

</html>