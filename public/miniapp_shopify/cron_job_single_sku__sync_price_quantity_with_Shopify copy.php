<?php
require "./inc/database.php";
require "./inc/functions.php";

$access_token = "";
$host_shop = "";
$GetDB_Shopify_SHOP = [];
$Total__products__updated = 0;
$GraphQL__rate_limit_ = 50;
$GOTDB___products_result = [];

$SKU_for_update = "";

$GetDB_Shopify_App_DATA = $db->query("SELECT * FROM `auto_miniapp_shopify` WHERE `shop_url` = 'autospartoutlet.myshopify.com' ");
if (mysqli_num_rows($GetDB_Shopify_App_DATA) > 0) {
    $GetDB_Shopify_SHOP = mysqli_fetch_all($GetDB_Shopify_App_DATA);
}

if (sizeof($GetDB_Shopify_SHOP) > 0) {
    foreach ($GetDB_Shopify_SHOP as $shop__key => $shop__value) {
        $host_shop = Get_host_shop($shop__value[1]);
        $access_token = ($shop__value[2]);
        if (isset($_POST['sku_____search'])) {
            if ($_POST['sku_____search'] != "") {
                $SKU_for_update = $_POST['sku_____search'];
            } else {
                echo "error";
                die();
            }
        } else {
            echo "error";
            die();
        }

        $GetDB_products = $db->query("SELECT * FROM `inventory_prices` WHERE `sku` = '$SKU_for_update' LIMIT 1 ");
        if (mysqli_num_rows($GetDB_products) > 0) {
            $GOTDB___products_result = mysqli_fetch_all($GetDB_products);
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        if (sizeof($GOTDB___products_result) > 0) {
            foreach ($GOTDB___products_result as $db_key => $db_prod) {
                $temp_db_product_sku = $db_prod[2];
                $temp_db_product_quantity = $db_prod[8];
                $temp_db_product_netPrice = ($db_prod[3] + $db_prod[4] + $db_prod[5] + $db_prod[6] + $db_prod[7]);

                if ($temp_db_product_sku != "") {

                    $GRAPHqL = shopify_graphQL_call($access_token, $host_shop, "2022-04", Query_get__product_with_sku($temp_db_product_sku));
                    $GRAPHqL_data = json_decode($GRAPHqL['response'], JSON_PRETTY_PRINT);

                    if (isset($GRAPHqL_data['extensions'])) {
                        $currentlyAvailable_ThrottledCost = $GRAPHqL_data['extensions']['cost']['throttleStatus']['currentlyAvailable'];
                        // print_r( $currentlyAvailable_ThrottledCost );
                        if ((int)$currentlyAvailable_ThrottledCost <= $GraphQL__rate_limit_) {
                            echo "currentlyAvailable_ThrottledCost  :: " . $currentlyAvailable_ThrottledCost . PHP_EOL;
                            sleep(1);
                        }
                    }
                    if (isset($GRAPHqL_data['data'])) :
                        if (isset($GRAPHqL_data['data']['products']['edges']) && $GRAPHqL_data['data']['products']['edges'] != array()) {
                            // echo "Array Key exists...";
                            $temp_Parent_prod_id = 0;
                            $temp_Parent_varient_product_id = 0;
                            $GOT_GRAPHQL__OUT_ARRAY = $GRAPHqL_data['data']['products']['edges'];
                            foreach ($GOT_GRAPHQL__OUT_ARRAY as $key => $GOT_GRAPHQL__OUT) :
                                $temp_Parent_prod_id = 0;
                                $temp_Parent_varient_product_id = 0;
                                $inventory_item_ID = 0;
                                $inventory_quantity = 0;
                                $location_ID = 0;
                                // print_r($GOT_GRAPHQL__OUT);
                                // die();
                                if (array_key_exists("node", $GOT_GRAPHQL__OUT)) {
                                    $temp_Parent_prod_id = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['id']);
                                    $temp_Parent_varient_product_id = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['id']);
                                    $inventory_item_ID = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['inventoryItem']['id']);
                                    $inventory_quantity = ($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['inventoryQuantity']); // inventoryQuantity
                                    $location_ID = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['fulfillmentService']['location']['id']);
                                }

                                $l = ((int)$temp_db_product_quantity - (int)$inventory_quantity);
                                $check_if_sku_exist_in_db = $db->query("SELECT * FROM `shopify_product_details` WHERE `sku` = '$temp_db_product_sku' ");
                                // echo "SELECT * FROM `shopify_product_details` WHERE `sku` = '$temp_db_product_sku' " . PHP_EOL ;
                                if (mysqli_num_rows($check_if_sku_exist_in_db) > 0) {
                                    $db->query("UPDATE `shopify_product_details` SET `v_id` = '$temp_Parent_varient_product_id', `p_id` = '$temp_Parent_prod_id', `sku` = '$temp_db_product_sku', `price` = '$temp_db_product_netPrice', `quantity` = '$temp_db_product_quantity', `inventory_item_id` = '$inventory_item_ID', `location_id` = '$location_ID', `inventory_quantity` = '$inventory_quantity', `available_adjustment` = '$l' WHERE `sku` = '$temp_db_product_sku' ");
                                    $db->query("UPDATE `inventory_prices` SET `location_inventory_id_check`= 1 WHERE `sku` = '$temp_db_product_sku' ");

                                    Adject_Price__Function($access_token, $host_shop, "2022-04", $temp_Parent_varient_product_id, $temp_db_product_netPrice);
                                    if (isset($location_ID) && isset($inventory_item_ID) && isset($l)) {
                                        if ($location_ID != ""  &&  $inventory_item_ID != "" && $l != 0) {
                                            Adject_Quantity__Function($access_token, $host_shop, "2022-04", $location_ID, $inventory_item_ID, $l);
                                            echo "Success Updating...";
                                            die();
                                        } else {
                                            echo "error Updating...";
                                            die();
                                        }
                                    } else {
                                        echo "error Updating...";
                                        die();
                                    }

                                    // print_r($res);
                                } else if (mysqli_num_rows($check_if_sku_exist_in_db) == 0) {
                                    $db->query("INSERT INTO `shopify_product_details` (`id`, `v_id`, `p_id`, `sku`, `price`, `quantity`, `inventory_item_id`, `location_id`, `inventory_quantity`, `available_adjustment`) VALUES (NULL, '$temp_Parent_varient_product_id', '$temp_Parent_prod_id', '$temp_db_product_sku', $temp_db_product_netPrice, '$temp_db_product_quantity', '$inventory_item_ID', '$location_ID', '$inventory_quantity', '$l')");
                                    $db->query("UPDATE `inventory_prices` SET `location_inventory_id_check`= 1 WHERE `sku` = '$temp_db_product_sku' ");

                                    Adject_Price__Function($access_token, $host_shop, "2022-04", $temp_Parent_varient_product_id, $temp_db_product_netPrice);
                                    if (isset($location_ID) && isset($inventory_item_ID) && isset($l)) {
                                        if ($location_ID != ""  &&  $inventory_item_ID != "" && $l != 0) {
                                            Adject_Quantity__Function($access_token, $host_shop, "2022-04", $location_ID, $inventory_item_ID, $l);
                                            echo "Success Updating...";
                                            die();
                                        } else {
                                            echo "error Updating...";
                                            die();
                                        }
                                    } else {
                                        echo "error Updating...";
                                        die();
                                    }
                                }

                            endforeach;
                        } // end if
                    endif;
                } else {
                    echo "error Updating...";
                    die();
                }
            }
        }
    } // end foreach loop
} else {
    echo "error Updating...";
    die();
}
