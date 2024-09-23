<?php
require_once("./inc/functions.php");
require_once("./inc/database.php");



$GetDB_Shopify_App_DATA = $db->query("SELECT * FROM `auto_miniapp_shopify` WHERE `shop_url` = 'autospartoutlet' ");

if (mysqli_num_rows($GetDB_Shopify_App_DATA) > 0) {
    $GetDB_Shopify_SHOP = mysqli_fetch_all($GetDB_Shopify_App_DATA);
}

// print_r($GetDB_Shopify_SHOP);

$token = $GetDB_Shopify_SHOP[0][2];
$host_shop = $GetDB_Shopify_SHOP[0][1];

echo Domain_URL_;

print_r([$token, $host_shop]);

echo "\n\n\n\n\n\n\n";



    $webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", [], 'GET');
    
    print_r($webhook);
    
    exit();


////////////////////////////////////////////////////////////////////////////////////////////////////////
//                         Shop 	app/uninstalled, shop/update
////////////////////////////////////////////////////////////////////////////////////////////////////////

// $array = array(
//     "webhook" => array(
//         "topic"   => "app/uninstalled",
//         "address" =>  Domain_URL_ . "/webhooks/app/uninstalled.php",
//         "format"  => "json"
//     )
// );

// $webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
// $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
// print_r($webhook);   // only one time print



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                         Order	orders/cancelled, orders/create, orders/fulfilled, orders/paid, orders/partially_fulfilled, orders/updated, orders/delete
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    // $array = array(
    // "webhook" => array(
    //         "topic"   => "orders/create",
    //         "address" =>  Domain_URL_. "/webhooks/orders/create.php",
    //         "format"  => "json"
    //         )
    // );
    // $webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
    // $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
    // print_r($webhook);  // only one time print

    $array = array(
    "webhook" => array(
            "topic"   => "orders/paid",
            "address" =>  Domain_URL_. "/webhooks/orders/paid.php",
            "format"  => "json"
            )
    );
    $webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
    // $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
    
    print_r($webhook);



/*
    $array = array(
        "webhook" => array(
            "topic"   => "orders/updated",
            "address" =>  Domain_URL_. "/webhooks/orders/updated.php",
            "format"  => "json"
            )
        );
    $webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
    $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);

    $array = array(
        "webhook" => array(
            "topic"   => "orders/delete",
            "address" =>  Domain_URL_. "/webhooks/orders/delete.php",
            "format"  => "json"
            )
    );
    $webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
    $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
    
    $array = array(
        "webhook" => array(
            "topic"   => "orders/fulfilled",
            "address" =>  Domain_URL_. "/webhooks/orders/fulfilled.php",
            "format"  => "json"
            )
        );
    $webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
    $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);

    $array = array(
        "webhook" => array(
            "topic"   => "orders/paid",
            "address" =>  Domain_URL_. "/webhooks/orders/paid.php",
            "format"  => "json"
            )
        );
        $webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
    $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
    
    $array = array(
        "webhook" => array(
            "topic"   => "orders/partially_fulfilled",
            "address" =>  Domain_URL_. "/webhooks/orders/partially_fulfilled",
            "format"  => "json"
            )
        );
    $webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
    $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
    
    $array = array(
        "webhook" => array(
        "topic"   => "orders/cancelled",
        "address" =>  Domain_URL_. "/webhooks/orders/cancelled.php",
        "format"  => "json"
        )
    );
    $webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
    $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
//////////////////////////////////////////////////////////////////////////////////////////////////////////

*/


////////////////////////////////////////////////////////////////////////////////////////////////////////
//                         Checkout	    checkouts/create, checkouts/update, checkouts/delete
////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
$array = array(
    "webhook" => array(
        "topic"   => "checkouts/create",
        "address" =>  Domain_URL_ . "/webhooks/checkouts/create.php",
        "format"  => "json"
    )
);
$webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);

$array = array(
    "webhook" => array(
        "topic"   => "checkouts/update",
        "address" =>  Domain_URL_ . "/webhooks/checkouts/update.php",
        "format"  => "json"
    )
);
$webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);

$array = array(
    "webhook" => array(
        "topic"   => "checkouts/delete",
        "address" =>  Domain_URL_ . "/webhooks/checkouts/delete.php",
        "format"  => "json"
    )
);
$webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);

////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////////
//                         Cart	carts/create, carts/update
////////////////////////////////////////////////////////////////////////////////////////////////////////

$array = array(
    "webhook" => array(
        "topic"   => "carts/create",
        "address" =>  Domain_URL_ . "/webhooks/carts/create.php",
        "format"  => "json"
    )
);
$webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);

$array = array(
    "webhook" => array(
        "topic"   => "carts/update",
        "address" =>  Domain_URL_ . "/webhooks/carts/update.php",
        "format"  => "json"
    )
);
$webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);

////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////////
//                         DraftOrder	draft_orders/create, draft_orders/update
////////////////////////////////////////////////////////////////////////////////////////////////////////

$array = array(
    "webhook" => array(
        "topic"   => "draft_orders/create",
        "address" =>  Domain_URL_ . "/webhooks/draft_orders/create.php",
        "format"  => "json"
    )
);
$webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);

$array = array(
    "webhook" => array(
        "topic"   => "draft_orders/update",
        "address" =>  Domain_URL_ . "/webhooks/draft_orders/update.php",
        "format"  => "json"
    )
);
$webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);

$array = array(
    "webhook" => array(
        "topic"   => "draft_orders/delete",
        "address" =>  Domain_URL_ . "/webhooks/draft_orders/delete.php",
        "format"  => "json"
    )
);
$webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
////////////////////////////////////////////////////////////////////////////////////////////////////////


*/


////////////////////////////////////////////////////////////////////////////////////////////////////////
//                         products/ create - delete - update 
////////////////////////////////////////////////////////////////////////////////////////////////////////

/*

$array = array(
    "webhook" => array(
        "topic"   => "products/create",
        "address" =>  Domain_URL_ . "/webhooks/products/create.php",
        "format"  => "json"
    )
);

$webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
// print_r($webhook);   // only one time print

$array = array(
    "webhook" => array(
        "topic"   => "products/update",
        "address" =>  Domain_URL_ . "/webhooks/products/update.php",
        "format"  => "json"
    )
);

$webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
// print_r($webhook);   // only one time print

$array = array(
    "webhook" => array(
        "topic"   => "products/delete",
        "address" =>  Domain_URL_ . "/webhooks/products/delete.php",
        "format"  => "json"
    )
);

$webhook = shopify_call($token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
// print_r($webhook);   // only one time print

*/