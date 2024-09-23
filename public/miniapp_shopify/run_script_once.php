<?php


$cmd = shell_exec('ps -ef |grep "php"');
// echo $cmd;
if (strpos($cmd, '/home/apoconsole/app.apoconsole.com/miniapp_shopify/cron_job__sync_price_quantity_with_Shopify___part2.php') !== false) {
    echo "already Running";
    die();
}


// include "/home/apoconsole/app.apoconsole.com/miniapp_shopify/cron_job__sync_price_quantity_with_Shopify___part2.php";
shell_exec('php /home/apoconsole/app.apoconsole.com/miniapp_shopify/cron_job__sync_price_quantity_with_Shopify___part2.php');