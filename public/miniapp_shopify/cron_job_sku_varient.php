<?php
require "./inc/database.php";
require "./inc/functions.php";

$GOTDB___products_result = [];
$GetDB_Shopify_SHOP = [];
$access_token = "";
$host_shop = "";
$ARRAY___ToUpdate_In_Shopify_ARRAY = array();
// print_r ($db);
// die();



function query_grqph_sku($sku)
{
  $Query__graphQl = array(
    "query" => '{
			products(first: 140) {
			  edges {
			  cursor
				node {
				  id
				  title
				  variants(first: 1) {
					edges {
					  node {
						id
						title
						sku
						price
						inventoryQuantity
						inventoryItem {
							id
						}
						fulfillmentService {
							location {
							  id
							  name
							}
						}
					  }
					}
				  }
				}
			  }
			  pageInfo {
			      hasNextPage
			      hasPreviousPage
			  }
			}
		  }'
  );
  return $Query__graphQl;
}



$GetDB_Shopify_App_DATA = $db->query("SELECT * FROM `auto_miniapp_shopify` WHERE `shop_url` = 'autospartoutlet.myshopify.com' ");

if (mysqli_num_rows($GetDB_Shopify_App_DATA) > 0) {
  $GetDB_Shopify_SHOP = mysqli_fetch_all($GetDB_Shopify_App_DATA);
}

if (count($GetDB_Shopify_SHOP) > 0) {
  foreach ($GetDB_Shopify_SHOP as $shop__key => $shop__value) {

    $host_shop = Get_host_shop($shop__value[1]);
    $access_token = ($shop__value[2]);

    $GetDB_products = $db->query("SELECT * FROM `inventory_prices` 
LEFT JOIN products_shopify ON inventory_prices.sku = products_shopify.sku
WHERE v_id IS NULL");
    // $GetDB_products = $db->query("SELECT * FROM `inventory_prices` WHERE ( `found` = 1 AND `shopify_update`= 1 ) ");
    // $GetDB_products = $db->query("SELECT * FROM `inventory_prices`");
    if (mysqli_num_rows($GetDB_products) > 0) {
      $GOTDB___products_result = mysqli_fetch_all($GetDB_products);
    }

    // print_r(sizeof($GOTDB___products_result)); // 3650
    // die();
    // $ARRAY___ToUpdate_In_Shopify_ARRAY = array();
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    if (count($GOTDB___products_result) > 0) {
      foreach ($GOTDB___products_result as $db_key => $db_prod) {

        $temp_db_product_sku = 'ACA84459';
        $temp_db_product_quantity = $db_prod[2];
        $temp_db_product_netPrice = $db_prod[3];

        $temp_shopify_product_sku = "";
        $temp_shopify_product_quantity = "";
        $temp_shopify_product_netPrice = "";

        if ($temp_db_product_sku != "") {
          $page = 1;

          $GRAPHqL = shopify_graphQL_call($access_token, $host_shop, "2022-04", query_grqph_sku($temp_db_product_sku));

          $GRAPHqL_data = json_decode($GRAPHqL['response'], JSON_PRETTY_PRINT);





          $GOT_GRAPHQL__OUT_ARRAY = [];


          $GOT_GRAPHQL__OUT_ARRAY = $GRAPHqL_data['data']['products']['edges'];

          if (!empty($GOT_GRAPHQL__OUT_ARRAY)) {
            // echo $db_key . "--------------";
            // print_r($GOT_GRAPHQL__OUT_ARRAY);
            // die();
            if (sizeof($GRAPHqL_data['data']['products']['edges']) > 0) {
              $temp_Parent_prod_id = 0;
              $temp_Parent_varient_product_id = 0;
              foreach ($GOT_GRAPHQL__OUT_ARRAY as $key => $GOT_GRAPHQL__OUT) {
                // echo $GOT_GRAPHQL__OUT['node']['id'];
                $temp_Parent_prod_id = 0;
                $temp_Parent_varient_product_id = 0;
                $inventory_item_ID = 0;
                $inventory_quantity = 0;
                $location_ID = 0;


                $temp_Parent_prod_id = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['id']);
                $temp_db_product_sku = $GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['sku'];
                $temp_db_product_netPrice = $GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['price'];
                $temp_db_product_quantity = $GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['inventoryQuantity'];
                $temp_Parent_varient_product_id = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['id']);
                $inventory_item_ID = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['inventoryItem']['id']);
                $inventory_quantity = ($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['inventoryQuantity']); // inventoryQuantity
                $location_ID = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['fulfillmentService']['location']['id']);


                array_push(
                  $ARRAY___ToUpdate_In_Shopify_ARRAY,
                  array(
                    "v_id" =>  $temp_Parent_varient_product_id,
                    "p_id" => $temp_Parent_prod_id,
                    "sku" => $temp_db_product_sku,
                    "price" => $temp_db_product_netPrice,
                    "quantity" => $temp_db_product_quantity,
                    "inventory_item_id" => $inventory_item_ID,
                    "location_id" => $location_ID,
                    "inventory_quantity" => $inventory_quantity,
                    "available_adjustment" => ((int)$temp_db_product_quantity - (int)$inventory_quantity)
                  )
                );
              }
            }
          }


          //print_r($GRAPHqL_data);

          $np = $GRAPHqL_data['data']['products']['pageInfo']['hasNextPage'] == 1;
          $cursor = $GRAPHqL_data['data']['products']['edges'][count($GRAPHqL_data['data']['products']['edges']) - 1]['cursor'];

          //   echo "\nTime: ".date("i:s");
          //   echo "\npage: ".$page;
          //     echo "\nproducts: ".count($GRAPHqL_data['data']['products']['edges']);
          //     echo "\nnext page: ".$np;
          //     echo "\nnext cursor ".$cursor;


          while ($np) {
            sleep(20);


            $GRAPHqL = shopify_graphQL_call($access_token, $host_shop, "2022-04", array(
              "query" => '{
                          products(first: 140 , after: "' . $cursor . '") {
                            edges {
                            cursor
                            node {
                              id
                              title
                              variants(first: 1) {
                              edges {
                                node {
                                id
                                title
                                sku
                                price
                                inventoryQuantity
                                inventoryItem {
                                  id
                                }
                                fulfillmentService {
                                  location {
                                    id
                                    name
                                  }
                                }
                                }
                              }
                              }
                            }
                            }
                            pageInfo {
                                hasNextPage
                                hasPreviousPage
                            }
                          }
                          }'
            ));

            $GRAPHqL_data = json_decode($GRAPHqL['response'], JSON_PRETTY_PRINT);

            $GOT_GRAPHQL__OUT_ARRAY = $GRAPHqL_data['data']['products']['edges'];

            if (!empty($GOT_GRAPHQL__OUT_ARRAY)) {
              // echo $db_key . "--------------";
              // print_r($GOT_GRAPHQL__OUT_ARRAY);
              // die();
              if (sizeof($GRAPHqL_data['data']['products']['edges']) > 0) {
                $temp_Parent_prod_id = 0;
                $temp_Parent_varient_product_id = 0;
                foreach ($GOT_GRAPHQL__OUT_ARRAY as $key => $GOT_GRAPHQL__OUT) {
                  // echo $GOT_GRAPHQL__OUT['node']['id'];
                  $temp_Parent_prod_id = 0;
                  $temp_Parent_varient_product_id = 0;
                  $inventory_item_ID = 0;
                  $inventory_quantity = 0;
                  $location_ID = 0;


                  $temp_Parent_prod_id = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['id']);
                  $temp_db_product_sku = $GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['sku'];
                  $temp_db_product_netPrice = $GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['price'];
                  $temp_db_product_quantity = $GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['inventoryQuantity'];
                  $temp_Parent_varient_product_id = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['id']);
                  $inventory_item_ID = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['inventoryItem']['id']);
                  $inventory_quantity = ($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['inventoryQuantity']); // inventoryQuantity
                  $location_ID = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['fulfillmentService']['location']['id']);


                  array_push(
                    $ARRAY___ToUpdate_In_Shopify_ARRAY,
                    array(
                      "v_id" =>  $temp_Parent_varient_product_id,
                      "p_id" => $temp_Parent_prod_id,
                      "sku" => $temp_db_product_sku,
                      "price" => $temp_db_product_netPrice,
                      "quantity" => $temp_db_product_quantity,
                      "inventory_item_id" => $inventory_item_ID,
                      "location_id" => $location_ID,
                      "inventory_quantity" => $inventory_quantity,
                      "available_adjustment" => ((int)$temp_db_product_quantity - (int)$inventory_quantity)
                    )
                  );
                }
              }
            }


            // print_r($GRAPHqL_data);
            if (isset($GRAPHqL_data['errors'])) {
              print_r($GRAPHqL_data['errors']);
              die();
            }




            $np = $GRAPHqL_data['data']['products']['pageInfo']['hasNextPage'] == 1;
            $cursor = $GRAPHqL_data['data']['products']['edges'][count($GRAPHqL_data['data']['products']['edges']) - 1]['cursor'];

            // echo "\nTime: ".date("i:s");
            // echo "\npage: ".++$page;
            // echo "\nproducts: ".count($GRAPHqL_data['data']['products']['edges']);
            // echo "\nnext page: ".$np;
            // echo "\nnext cursor ".$cursor;

          }
        }
        break;
      }
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////

    print_r($ARRAY___ToUpdate_In_Shopify_ARRAY);

    $db->query("TRUNCATE TABLE `products_shopify`");


    foreach ($ARRAY___ToUpdate_In_Shopify_ARRAY as $data) {


      $v_id =    $data['v_id'];
      $p_id =   $data['p_id'];
      $sku =   $data['sku'];
      $price =   $data['price'];
      $quantity =   $data['quantity'];
      $inventory_item_id =   $data['inventory_item_id'];
      $location_id =   $data['location_id'];
      $inventory_quantity =   $data['inventory_quantity'];
      $available_adjustment =   $data['available_adjustment'];

      $db->query("INSERT INTO `products_shopify`(`id`, `v_id`, `p_id`, `sku`, `price`, `quantity`, `inventory_item_id`, `location_id`, `inventory_quantity`, `available_adjustment`) VALUES (NULL,'$v_id','$p_id','$sku','$price','$quantity','$inventory_item_id','$location_id','$inventory_quantity','$available_adjustment')");
    }



    echo "done";
    die();


    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////

    break;
  } // end foreach loop
} // end if 

echo "Done Updating Data...";
