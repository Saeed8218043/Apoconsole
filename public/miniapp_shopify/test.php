<?php
chdir('/home/apoconsole/app.apoconsole.com/miniapp_shopify/');
echo "Updating Price and Quantity";
require "./inc/database.php";
require "./inc/functions.php";

// $starttime = microtime(true); // Top of page
// $Total__products__updated = 0;
// $GOTDB___products_result = null;
// $access_token = "";
// $host_shop = "";
// $db->query("UPDATE `inventory_prices` SET profit = 10.77 ");



$f = fopen('update_status.txt','a');
fwrite($f,"Done all Products on ".date('d-m-Y h:i:s A')."\n");
fclose($f);
echo "Done all Products on ".date('d-m-Y h:i:s A')."\n" ;