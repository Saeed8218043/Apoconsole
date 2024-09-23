<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Security-Policy: frame-ancestors *');
    include_once("./inc/database.php");
    include_once("./inc/functions.php");
    
    $requests = $_GET;
    // echo print_r($requests);
    $access_token = '';
    $hmac = $requests['hmac'];
    $serializeArray = serialize($requests);
    $requests = array_diff_key($requests, array('hmac' => ''));
    ksort($requests);
    
    $url = parse_url('https://' . $requests['shop']);
    $host = explode('.', $url['host']);
    $host_shop = $host[0];
    $shop = $requests['shop'];

    // $statement = $pdo->prepare("SELECT * FROM `shopify_shop` WHERE `requests` = '". $url ."' LIMIT 1 ");
    // $result = $statement->execute();
    $stmt = $pdo->prepare("SELECT * FROM `auto_miniapp_shopify` WHERE shop_url=?  LIMIT 1 ");
    $stmt->execute([$shop]);
    $user = $stmt->fetch();
    // print_r($user);
    $access_token = $user['access_token'];
    
    if ( empty($user) ) {
        header("Location: install.php?shop=" . $requests['shop']);
        exit();
    } else {
    
        $chkProduct = $db->query("SELECT * from auto_miniapp_shopify WHERE shop_url='" .$shop . "' limit 1");
        if (mysqli_num_rows($chkProduct) == 0) {
            // update
            header("Location: install.php?shop=" . $requests['shop']);
            die("there is no access please reinstall discount app");
        }
        $result = mysqli_fetch_assoc($chkProduct);
        $access_token = $result['access_token']; //
    }
    
    $array = array(
        "webhook" => array(
            "topic"   => "app/uninstalled",
            "address" =>  Domain_URL_ . "/webhooks/app/uninstalled.php",
            "format"  => "json"
        )
    );
    
    $webhook = shopify_call($access_token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
    $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
    // print_r($webhook);   // only one time print
    
    $array = array(
        "webhook" => array(
        "topic"   => "orders/create",
        "address" =>  Domain_URL_. "/webhooks/orders/create.php",
        "format"  => "json"
        )
    );
    $webhook = shopify_call($access_token, $host_shop, "/admin/api/2022-04/webhooks.json", $array, 'POST');
    $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
    // print_r($webhook);   // only one time print
    
    
    function  PRODUCTS____REQUEST($access_token, $host_shop , $version , $query , $ARRAY ,  $METHOD){
        $getProducts = shopify_call($access_token, $host_shop, "/admin/api/". $version.$query , $ARRAY , $METHOD);
        $getProducts = json_decode( ($getProducts['response']) , true);
        return $getProducts;
    }

    // $PRODUCTS__GOT = PRODUCTS____REQUEST($access_token, $host_shop , "2022-04" , "/products.json" , array() ,  'GET');
    /*
        CREATE VIEW  `inventory_price_view` AS
        SELECT `id` , `sku`, `qty` , (`cost`) + (`fee`) + (`commission`) + (`shipping`) + (`profit`) as `net_price` 
        FROM `inventory_prices`

    */

    $GOTDB___products_result = [];

    $GetDB_products = $db->query("SELECT * FROM `inventory_price_view`");
    if (mysqli_num_rows($GetDB_products) > 0) {
        $GOTDB___products_result = mysqli_fetch_all($GetDB_products);
    }
    // print_r($GOTDB___products_result);
    
    //////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////
    
    $ARRAY___ToUpdate_In_Shopify_ARRAY_FINAL = array();
    $ARRAY___ToUpdate_In_Shopify_ARRAY = array();
    
    if( count($GOTDB___products_result) > 0  ){
        foreach ($GOTDB___products_result as $db_key => $db_prod) {
            $temp_db_product_sku = $db_prod[1];
            $temp_db_product_quantity = $db_prod[2];
            $temp_db_product_netPrice = $db_prod[3];
            
            $temp_shopify_product_sku = "";
            $temp_shopify_product_quantity = "";
            $temp_shopify_product_netPrice = "";
    
            if( $temp_db_product_sku != "" ){

                $GRAPHqL = shopify_graphQL_call($access_token, $host_shop,"2022-04", Query_get__product_with_sku( $temp_db_product_sku ));
                $GRAPHqL_data = json_decode($GRAPHqL['response'], JSON_PRETTY_PRINT);
                // $GOT_GRAPHQL__OUT_ARRAY = [];
                $GOT_GRAPHQL__OUT_ARRAY = $GRAPHqL_data['data']['products']['edges'];
                if( count( $GRAPHqL_data['data']['products']['edges'] ) > 0  ){
                    $temp_Parent_prod_id = 0;
                    $temp_Parent_varient_product_id = 0;
                    foreach ($GOT_GRAPHQL__OUT_ARRAY as $key => $GOT_GRAPHQL__OUT) {
                        // echo $GOT_GRAPHQL__OUT['node']['id'];
                        $temp_Parent_prod_id = 0;
                        $temp_Parent_varient_product_id = 0;
                        $temp_Parent_prod_id = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['id']);
                        $temp_Parent_varient_product_id = graphQL__id__spliting($GOT_GRAPHQL__OUT['node']['variants']['edges'][0]['node']['id']);
            
                        array_push( 
                            $ARRAY___ToUpdate_In_Shopify_ARRAY , 
                            array(  
                                "v_id" =>  $temp_Parent_varient_product_id, 
                                "p_id" => $temp_Parent_prod_id,
                                "sku" => $temp_db_product_sku,
                                "price" => $temp_db_product_netPrice,
                                "quantity" => $temp_db_product_quantity
                            ) 
                        );
                    }
                }

            }
        }
    }

    print_r($ARRAY___ToUpdate_In_Shopify_ARRAY);

    




    //////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////

    

    // graphQL__id__spliting();
    
    $products = shopify_call($access_token, $host_shop, "/admin/api/2022-04/products.json", 
        array( 
            'limit' => 250,
        ), 'GET');
    $products_pre = ($products['response']);
    $products = json_decode($products['response'], JSON_PRETTY_PRINT);
    $product_json =  $products_pre;
    // print_r($products);

    // $product_titles = array();
    $Shopify_product_array = array();
    foreach ($products as $key => $product) {
        foreach ($product as $p_key => $value) {
            $variant_data = json_decode(json_encode($value['variants']) , true );
            $size_of_varient_array = count(json_decode(json_encode($value['variants']) , true ));
            if( $size_of_varient_array > 0 ){
                foreach ($variant_data as $v_key => $variant) {
                    array_push($Shopify_product_array, $variant);

                }       
            }  
        }
    }

    $PRODUCTS__ALL_ARRAY = (json_decode( json_encode($Shopify_product_array) , true));
    // print_r( $PRODUCTS__ALL_ARRAY );




    ?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lobster|Josefin+Sans|Shadows+Into+Light|Pacifico|Amatic+SC:700|Orbitron:400,900|Rokkitt|Righteous|Dancing+Script:700|Bangers|Chewy|Sigmar+One|Architects+Daughter|Abril+Fatface|Covered+By+Your+Grace|Kaushan+Script|Gloria+Hallelujah|Satisfy|Lobster+Two:700|Comfortaa:700|Cinzel|Courgette' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lobster|Josefin+Sans|Shadows+Into+Light|Pacifico|Amatic+SC:700|Orbitron:400,900|Rokkitt|Righteous|Dancing+Script:700|Bangers|Chewy|Sigmar+One|Architects+Daughter|Abril+Fatface|Covered+By+Your+Grace|Kaushan+Script|Gloria+Hallelujah|Satisfy|Lobster+Two:700|Comfortaa:700|Cinzel|Courgette' rel='stylesheet' type='text/css'>
    
    <title>Document</title>
</head>

<body>
    <div class="container">
        Hello -------->   <?php echo $access_token; ?>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    
</body>

</html>