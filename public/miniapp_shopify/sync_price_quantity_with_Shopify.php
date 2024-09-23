<?php
chdir('/home/apoconsole/app.apoconsole.com/public/miniapp_shopify/');
$start_time = time();
$prod_updated=0;
header('Access-Control-Allow-Origin: *');
header('Content-Security-Policy: frame-ancestors *');
include_once("./inc/database.php");
include_once("./inc/functions.php");
function find_inventory_id($data,&$value){
        	if (isset($data['inventoryLevels'])){
        		$value = $data['inventoryLevels']['edges'][0]['node'];
        		return;
        	}
        	if (is_array($data)){
        		foreach($data as $a){
        			find_inventory_id($a,$value);
        		}
        	}
        }


start_sync:

$GOTDB___products_result = [];
$GetDB_Shopify_SHOP = [];
$access_token = "";
$host_shop = "";
$ARRAY___ToUpdate_In_Shopify_ARRAY = array();

$GetDB_Shopify_App_DATA = $db->query("SELECT inventory_prices.*, shopify_update.vid, shopify_update.id AS suid FROM `shopify_update`
LEFT JOIN inventory_prices on inventory_prices.sku = shopify_update.sku
WHERE shopify_update.updated=0
order by shopify_update.id asc
LIMIT 100");
if (mysqli_num_rows($GetDB_Shopify_App_DATA) > 0) {
$price='';


    while ($row = mysqli_fetch_assoc($GetDB_Shopify_App_DATA)) {
    if($row['mapped']>0){
        $price = $row['mapped'];
      }else{
        $price = $row['cost'] + $row['fee'] + $row['commission'] + $row['shipping'] + $row['profit'];
      }
    //  print_r($row); exit();

$a = (array (
  'query' =>
      'mutation productVariantUpdate($input: ProductVariantInput!) { productVariantUpdate(input: $input) {
      productVariant {
                  id
                  title
                  inventoryPolicy
                  inventoryQuantity
                  price
                  compareAtPrice

      }
      product {
              variants(first: 1) {
                edges {
    					  node {
    					    price
    					    sku
    						inventoryQuantity
    						inventoryItem {
    							id
    							inventoryLevels(first: 10) {
                                    edges {
                                      node {
                                        available
                                        id
                                      }
                                    }
                                  }
    						}

    					  }
                        }
              }
          }
            userErrors {
              field
              message
            }
          } }',
          'variables' =>
          array (
            'input' =>
            array (
              'id' => 'gid://shopify/ProductVariant/'.$row['vid'],
              'price' => round($price, 2),
            //   'inventoryQuantity' => 1,

            ),
          ),
));







        $GRAPHqL = shopify_graphQL_call('', 'autospartoutlet', "2022-04", $a);

      $GRAPHqL_data = json_decode($GRAPHqL, JSON_PRETTY_PRINT);



      $value=false;



        find_inventory_id($GRAPHqL_data,$value);




      if ( $value ){
       $inventorylevelId =  $value['id'];

       $qty = $value['available'];

       $qty = $row['qty']-$qty;
       $a = array (
              'query' => 'mutation AdjustInventoryQuantity($input: InventoryAdjustQuantityInput!) { inventoryAdjustQuantity(input: $input) { inventoryLevel { id available incoming item { id sku } location { id name } } } }',
              'variables' =>
              array (
                'input' =>
                array (
                  'inventoryLevelId' => $inventorylevelId,
                  'availableDelta' => $qty,
                ),
              ),
            );
        $GRAPHqL = shopify_graphQL_call('', 'autospartoutlet', "2022-04", $a);
      $GRAPHqL_data = json_decode($GRAPHqL, JSON_PRETTY_PRINT);



      $trolling = $GRAPHqL_data['extensions']['cost']['throttleStatus']['currentlyAvailable'];



      if (
          isset($GRAPHqL_data['extensions']) &&
          isset($GRAPHqL_data['extensions']['cost']) &&
          isset($GRAPHqL_data['extensions']['cost']['throttleStatus']) &&
          isset($GRAPHqL_data['extensions']['cost']['throttleStatus']['currentlyAvailable'])
          ){
         $db->query("UPDATE `shopify_update` SET `updated`=1 ,`troll`='".$trolling."' WHERE id=".$row['suid']);
      } else {
         $db->query("UPDATE `shopify_update` SET `updated`=1 ,`error`=1  WHERE id=".$row['suid']);
      }
      $prod_updated++;

    //   UPDATE `shopify_update` SET `updated`='[value-6]',`error`='[value-7]',`troll`='[value-8]' WHERE 1

      }





    //   print_r($GRAPHqL_data);

        if ((time() - $start_time) > 55){
            echo $prod_updated;
            exit('timeout');
        }


    }
  }
// echo time()."\n";

if ((time() - $start_time) < 50){
    sleep(3);
    echo "checking again\n";
     goto start_sync;
        }
