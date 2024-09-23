<?php
header('Access-Control-Allow-Origin: *');
header('Content-Security-Policy: frame-ancestors *');
include_once("./inc/database.php");
include_once("./inc/functions.php");


$is_at_start = 1;
$has_next = 0;
$Cursor = null;
$Last__result___ = [];


$GetDB_Shopify_App_DATA = $db->query("SELECT * FROM `auto_miniapp_shopify` WHERE `shop_url` = 'autospartoutlet.myshopify.com' ");

if (mysqli_num_rows($GetDB_Shopify_App_DATA) > 0) {
    $GetDB_Shopify_SHOP = mysqli_fetch_all($GetDB_Shopify_App_DATA);
    if (count($GetDB_Shopify_SHOP) > 0) {
        foreach ($GetDB_Shopify_SHOP as $shop__key => $shop__value) {
            $host_shop = Get_host_shop($shop__value[1]);
            $access_token = ($shop__value[2]);
            $ARRAY___ToUpdate_In_Shopify_ARRAY = [];

            if($is_at_start == 1){
                $GRAPHqL = shopify_graphQL_call($access_token, $host_shop, "2022-04", Query_get__products____() );
                $GRAPHqL_data = json_decode($GRAPHqL['response'], JSON_PRETTY_PRINT);
                $GOT_GRAPHQL__OUT_DATA = [];
                $GOT_GRAPHQL__OUT_DATA = $GRAPHqL_data['data']['products']['edges'];   
                $Page_Info = [];
                $Page_Info = $GRAPHqL_data['data']['products']['pageInfo']['hasNextPage'];    
                    
                // print_r($GOT_GRAPHQL__OUT_ARRAY);
                $Last__result___ =  $GOT_GRAPHQL__OUT_DATA[ ( count( $GOT_GRAPHQL__OUT_DATA ) - 1 ) ];
                $Cursor = $Last__result___['cursor'];
                // print_r( $Last__result___ );
                // echo $Page_Info;
                // echo $Cursor;
                $has_next = $Page_Info;
                $GOT_GRAPHQL__OUT_ARRAY = [];
                $GOT_GRAPHQL__OUT_ARRAY = $GOT_GRAPHQL__OUT_DATA;
                if( !empty($GOT_GRAPHQL__OUT_ARRAY) ){
                    if (count( $GOT_GRAPHQL__OUT_ARRAY ) > 0) {
                        $temp_Parent_prod_id = 0;
                        $temp_Parent_varient_product_id = 0;
                        foreach ($GOT_GRAPHQL__OUT_ARRAY as $key => $GOT_GRAPHQL__OUT) {
                            // echo $GOT_GRAPHQL__OUT['node']['id'];
                            $temp_Parent_prod_id = 0;
                            $temp_Parent_varient_product_id = 0;
                            $inventory_item_ID = 0;
                            $temp_db_product_netPrice = 0;
                            $inventory_quantity = 0;
                            $location_ID = 0;
                            $temp_db_product_quantity = 0;
                            // SELECT ( `cost` + `fee` + `commission` + `shipping` + `profit` ) as `net_price` FROM `inventory_prices` WHERE `sku` = "TF10087"
                            $temp_db_product_sku = $GOT_GRAPHQL__OUT['node']['sku'];
                            $temp_Parent_prod_id = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['id']);
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
                                    "available_adjustment" => ( (int)$temp_db_product_quantity - (int)$inventory_quantity)
                                )
                            );
                        }
                    }
                }
                // print_r($ARRAY___ToUpdate_In_Shopify_ARRAY);
                // die();

                while( $has_next ){

                    $GRAPHqL = shopify_graphQL_call($access_token, $host_shop, "2022-04", Query_get__NEXT__products____($Cursor) );
                    $GRAPHqL_data = json_decode($GRAPHqL['response'], JSON_PRETTY_PRINT);

                    print_r($GRAPHqL_data);
                    // die();
                    // $GOT_GRAPHQL__OUT_DATA = [];
                    $GOT_GRAPHQL__OUT_DATA = $GRAPHqL_data['data']['products']['edges'];    
                    $Page_Info = [];
                    $Page_Info = $GRAPHqL_data['data']['products']['pageInfo']['hasNextPage'];    
                    // print_r($GOT_GRAPHQL__OUT_ARRAY);
                    $Last__result___ =  $GOT_GRAPHQL__OUT_DATA[ ( count( $GOT_GRAPHQL__OUT_DATA ) - 1 ) ];
                    print_r( $Last__result___ );
                    echo $Page_Info;
                    $Cursor = $Last__result___['cursor'];
                    $has_next = $Page_Info;
                    // $GOT_GRAPHQL__OUT_ARRAY = [];
                    $GOT_GRAPHQL__OUT_ARRAY = $GOT_GRAPHQL__OUT_DATA;
                    if( !empty($GOT_GRAPHQL__OUT_ARRAY) ){
                        if (count( $GOT_GRAPHQL__OUT_ARRAY ) > 0) {
                            $temp_Parent_prod_id = 0;
                            $temp_Parent_varient_product_id = 0;
                            foreach ($GOT_GRAPHQL__OUT_ARRAY as $key => $GOT_GRAPHQL__OUT) {
                                // echo $GOT_GRAPHQL__OUT['node']['id'];
                                $temp_Parent_prod_id = 0;
                                $temp_Parent_varient_product_id = 0;
                                $inventory_item_ID = 0;
                                $temp_db_product_netPrice = 0;
                                $inventory_quantity = 0;
                                $location_ID = 0;
                                $temp_db_product_quantity = 0;
                                // SELECT ( `cost` + `fee` + `commission` + `shipping` + `profit` ) as `net_price` FROM `inventory_prices` WHERE `sku` = "TF10087"
                                $temp_db_product_sku = $GOT_GRAPHQL__OUT['node']['sku'];
                                $temp_Parent_prod_id = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['id']);
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
                                        "available_adjustment" => ( (int)$temp_db_product_quantity - (int)$inventory_quantity)
                                    )
                                );
                            }
                        }
                    }
                }
                

                print_r($ARRAY___ToUpdate_In_Shopify_ARRAY);
                
            }

        }
    }
}
