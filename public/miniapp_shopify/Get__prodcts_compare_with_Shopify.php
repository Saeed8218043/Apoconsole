<?php

$GOTDB___products_result = [];
$GetDB_products = $db->query("SELECT * FROM `inventory_price_view`");
if (mysqli_num_rows($GetDB_products) > 0) {
    $GOTDB___products_result = mysqli_fetch_all($GetDB_products);
}
// print_r($GOTDB___products_result);


$ARRAY___ToUpdate_In_Shopify_ARRAY = array();

if (count($GOTDB___products_result) > 0) {
    foreach ($GOTDB___products_result as $db_key => $db_prod) {
        $temp_db_product_sku = $db_prod[1];
        $temp_db_product_quantity = $db_prod[2];
        $temp_db_product_netPrice = $db_prod[3];

        $temp_shopify_product_sku = "";
        $temp_shopify_product_quantity = "";
        $temp_shopify_product_netPrice = "";

        if ($temp_db_product_sku != "") {

            $GRAPHqL = shopify_graphQL_call($access_token, $host_shop, "2022-04", Query_get__product_with_sku($temp_db_product_sku));
            $GRAPHqL_data = json_decode($GRAPHqL['response'], JSON_PRETTY_PRINT);
            // $GOT_GRAPHQL__OUT_ARRAY = [];
            $GOT_GRAPHQL__OUT_ARRAY = $GRAPHqL_data['data']['products']['edges'];
            if (count($GRAPHqL_data['data']['products']['edges']) > 0) {
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
                            "available_adjustment" =>  ($temp_db_product_quantity - $inventory_quantity)
                        )
                    );
                }
            }
        }
    }
    
}


// $products = shopify_call($access_token, $host_shop, "/admin/api/2022-04/products.json", 
//     array( 
//         'limit' => 3,
//     ), 'GET');
// $products_pre = ($products['response']);
// $products = json_decode($products['response'], JSON_PRETTY_PRINT);
// $product_json =  $products_pre;
// print_r($products);