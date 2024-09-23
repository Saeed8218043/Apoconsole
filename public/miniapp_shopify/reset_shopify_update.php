<?php
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
$db->query("UPDATE `inventory_prices` SET shopify_update = 0 ");
