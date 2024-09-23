<?php
header('Access-Control-Allow-Origin: *');
header('Content-Security-Policy: frame-ancestors *');
include_once("./inc/database.php");
include_once("./inc/functions.php");



echo time()."\n";

$GOTDB___products_result = [];
$GetDB_Shopify_SHOP = [];
$access_token = "";
$host_shop = "";
$ARRAY___ToUpdate_In_Shopify_ARRAY = array();

$GetDB_Shopify_App_DATA = $db->query("SELECT inventory_prices.*, shopify_update.vid FROM `shopify_update`
LEFT JOIN inventory_prices on inventory_prices.sku = shopify_update.sku
WHERE shopify_update.updated=0
order by shopify_update.id asc
LIMIT 100");

if (mysqli_num_rows($GetDB_Shopify_App_DATA) > 0) {


    while ($row = mysqli_fetch_assoc($GetDB_Shopify_App_DATA)) {
     $price = $row['cost'] + $row['fee'] + $row['commission'] + $row['shipping'] + $row['profit'];
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
      $GRAPHqL_data = json_decode($GRAPHqL['response'], JSON_PRETTY_PRINT);

      if (
            isset($GRAPHqL_data['data']) &&
            isset($GRAPHqL_data['data']['productVariantUpdate']) &&
            isset($GRAPHqL_data['data']['productVariantUpdate'] ['product']) &&
            isset($GRAPHqL_data['data']['productVariantUpdate'] ['product']['variants']) &&
            isset($GRAPHqL_data['data']['productVariantUpdate'] ['product']['variants'] ['edges']) &&
            isset($GRAPHqL_data['data']['productVariantUpdate'] ['product']['variants'] ['edges'][0]) &&
            isset($GRAPHqL_data['data']['productVariantUpdate'] ['product']['variants'] ['edges'][0]['node']) &&
            isset($GRAPHqL_data['data']['productVariantUpdate'] ['product']['variants'] ['edges'][0]['node']['inventoryItem']['inventoryLevels']) &&
            isset($GRAPHqL_data['data']['productVariantUpdate'] ['product']['variants'] ['edges'][0]['node']['inventoryItem']['inventoryLevels']['edges']) &&
            isset($GRAPHqL_data['data']['productVariantUpdate'] ['product']['variants'] ['edges'][0]['node']['inventoryItem']['inventoryLevels']['edges'][0]) &&
            isset($GRAPHqL_data['data']['productVariantUpdate'] ['product']['variants'] ['edges'][0]['node']['inventoryItem']['inventoryLevels']['edges'][0]['node']) &&
            isset($GRAPHqL_data['data']['productVariantUpdate'] ['product']['variants'] ['edges'][0]['node']['inventoryItem']['inventoryLevels']['edges'][0]['node']['id'])
          ){
       $inventorylevelId =  ($GRAPHqL_data['data']['productVariantUpdate'] ['product']['variants'] ['edges'][0]['node']['inventoryItem']['inventoryLevels']['edges'][0]['node']['id']);

       $qty = $GRAPHqL_data['data']['productVariantUpdate'] ['product']['variants'] ['edges'][0]['node']['inventoryQuantity'];

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
      $GRAPHqL_data = json_decode($GRAPHqL['response'], JSON_PRETTY_PRINT);

      }



      $trolling = $GRAPHqL_data['extensions']['cost']['throttleStatus']['currentlyAvailable'];

      print_r($GRAPHqL_data);exit();



    }
  }
echo time()."\n";
