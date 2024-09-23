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
$Total_templates_types = [];
// $statement = $pdo->prepare("SELECT * FROM `shopify_shop` WHERE `requests` = '". $url ."' LIMIT 1 ");
// $result = $statement->execute();
$stmt = $pdo->prepare("SELECT * FROM `auto_miniapp_shopify` WHERE shop_url=?  LIMIT 1 ");
$stmt->execute([$shop]);
$user = $stmt->fetch();
// print_r($user);
$access_token = $user['access_token'];

if (empty($user)) {
    header("Location: install.php?shop=" . $requests['shop']);
    exit();
} else {
    $chkProduct = $db->query("SELECT * from auto_miniapp_shopify WHERE shop_url='" . $shop . "' limit 1");
    if (mysqli_num_rows($chkProduct) == 0) {
        // update
        header("Location: install.php?shop=" . $requests['shop']);
        die("there is no access please reinstall discount app");
    }
    $result = mysqli_fetch_assoc($chkProduct);
    $access_token = $result['access_token']; //
}
include_once("./webhooks.php");


function createTags__withGraphQL( $access_token , $host_shop , $gid , $tags_array ){
    $queryUsingVariables = <<<QUERY
    mutation addTags(\$id: ID!, \$tags: [String!]!) {
        tagsAdd(id: \$id, tags: \$tags) {
            node {
                id
            }
            userErrors {
                message
            }
        }
    }
    QUERY;
    $variables = [
        "id" => $gid,
        "tags" => $tags_array
    ];
    return shopify_graphQL_call($access_token , $host_shop , "2022-04", ['query' => $queryUsingVariables, 'variables' => $variables] );
}
function removeTags__withGraphQL( $access_token , $host_shop , $gid , $tags_array ){
    $queryUsingVariables = <<<QUERY
    mutation removeTags(\$id: ID!, \$tags: [String!]!) {
        tagsRemove(id: \$id, tags: \$tags) {
            node {
                id
            }
            userErrors {
                message
            }
        }
    }
    QUERY;
    $variables = [
        "id" => $gid,
        "tags" => $tags_array
    ];
    return shopify_graphQL_call($access_token , $host_shop , "2022-04", ['query' => $queryUsingVariables, 'variables' => $variables] );
}

// $test = shopify_graphQL_call($access_token , $host_shop , "2022-04", ["query" => $query, "variables" => $variables]);

$graphql___tags_getAll = array(
    "query" => '{
        products(first: 1) {
            edges {
                cursor
                node {
                    id
                    tags
                }
            }
            pageInfo {
                hasNextPage
                hasPreviousPage
                startCursor
                endCursor
            }
        } 
    }'
);


$tags________prod = shopify_graphQL_call($access_token , $host_shop , "2022-04" , $graphql___tags_getAll );
echo "<pre>";
// print_r($tags________prod['response']);
// print_r( json_decode($tags________prod['response'])->data->products->edges );
// print_r( json_decode($tags________prod['response'])->data->products->pageInfo->hasNextPage );

$next_ = json_decode($tags________prod['response'])->data->products->pageInfo->hasNextPage;
$next_node = "";

while( $next_ == 1 ){
    $next_node = json_decode($tags________prod['response'])->data->products->pageInfo->endCursor;

    $gql_Tags_getNEXT = array(
        "query" => '{
            products(first: 1, after: "'. $next_node .'" ) {
                edges {
                    cursor
                    node {
                        id
                        tags
                    }
                }
                pageInfo {
                    hasNextPage
                    hasPreviousPage
                    startCursor
                    endCursor
                }
            } 
        }'
    );

   
    $tags________prod = shopify_graphQL_call($access_token , $host_shop , "2022-04" , $gql_Tags_getNEXT );
    $next_ = json_decode($tags________prod['response'])->data->products->pageInfo->hasNextPage;
    // print_r( json_decode($tags________prod['response'])->data->products->edges );
    $product = ( json_decode($tags________prod['response'])->data->products->edges[0] );
    $tags = $product->node->tags;
    $prod_gid = $product->node->id;
    // print_r($tags);
    // die();
    foreach ($tags as $key => $t) {
        $temp_tag = $t;
        $tags_array = array();
        if( strpos($temp_tag, "-") !== false ) {
            $t___tag = str_replace("-", "" , $t);
            if(is_numeric( $t___tag )){
                // echo " this is an integer ";
                // echo $temp_tag;
                // die();
                $temp_split_tag = explode("-", $temp_tag);
                // print_r( $temp_split_tag );
                // die();
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                
                if( strlen( $temp_split_tag[0] ) == 4 &&  strlen( $temp_split_tag[1] ) == 4 ){
                    
                    $first = $temp_split_tag[0];
                    $second = $temp_split_tag[1];
                    $larger_year = 0;
                    $smaller_year = 0;
                    if( $first > $second ){
                        $larger_year = $first;
                        $smaller_year = $second;
                    }elseif( $second > $first ){
                        $larger_year = $second;
                        $smaller_year = $first;
                    }
                    $start = $smaller_year;
                    $end = $larger_year;
                    array_push( $tags_array , $smaller_year );
                    array_push( $tags_array , $larger_year );
                    
                    for ($i=0; $i < ($larger_year - $smaller_year) ; $i++) { 
                        // array_push( $tags_array , ($start + ($i + 1)) );
                        $tags_array[] = ($start + ($i + 1)) ;
                    }
                    createTags__withGraphQL( $access_token , $host_shop , $prod_gid , Implode( ',' , $tags_array) );
                    // print_r (Implode( ',' , $tags_array)  );
                    // die();
                }
                
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if( strlen( $temp_split_tag[0] ) == 2 ||  strlen( $temp_split_tag[1] ) == 2 ){
                    $first = 0;
                    $temp_second = 0;
                    $second = 0;

                    $larger_year = 0;
                    $smaller_year = 0;
                    if( strlen( $temp_split_tag[1] ) == 4 ){
                        $first = $temp_split_tag[1];
                        $temp_second = $temp_split_tag[0];
                        if( substr($first , 0,2) == 20 ){
                            $second = $temp_second + 2000;
                        }elseif( substr($first , 0,2) == 19 ){
                            $second = $temp_second + 1900;
                        }
                        
                    }elseif( strlen( $temp_split_tag[1] ) == 2 ){
                        $first = $temp_split_tag[0];
                        $temp_second = $temp_split_tag[1];
                        if( substr($first , 0,2) == 20 ){
                            $second = $temp_second + 2000;
                        }elseif( substr($first , 0,2) == 19 ){
                            $second = $temp_second + 1900;
                        }
                    }

                    if( $first > $second ){
                        $larger_year = $first;
                        $smaller_year = $second;
                    }elseif( $second > $first ){
                        $larger_year = $second;
                        $smaller_year = $first;
                    }
                    $start = $smaller_year;
                    $end = $larger_year;
                    array_push( $tags_array , $smaller_year );
                    array_push( $tags_array , $larger_year );
                    
                    for ($i=0; $i < ($larger_year - $smaller_year) ; $i++) { 
                        // array_push( $tags_array , ($start + ($i + 1)) );
                        $tags_array[] = ($start + ($i + 1)) ;
                    }
                    createTags__withGraphQL( $access_token , $host_shop , $prod_gid , Implode( ',' , $tags_array) );
                    // print_r (Implode( ',' , $tags_array)  );

                }
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                removeTags__withGraphQL( $access_token , $host_shop , $prod_gid  , $temp_tag );


            } // end if(is_numeric( $t___tag )){
        }// end  if( strpos($temp_tag, "-") !== false ) {
    }// end  foreach ($tags as $key => $t) {
}//  edn while loop


// $SHOPIFY_theme__ID = GET__selected_shopify_theme___id( $access_token , Get_host_shop($shop) , SHOPIFY__VERSION);
// print_r( $SHOPIFY_theme__ID['id'] );

// UPDATE_assets__shopifyStore__($access_token, $host_shop , SHOPIFY__VERSION , $SHOPIFY_theme__ID['id'] , "about___snippet" , "snippets" ,  file_get_contents(getcwd() . "/scripts/sections/about/". 'about_1' .".txt")  );
// UPDATE_assets__shopifyStore__($access_token, $host_shop , SHOPIFY__VERSION , $SHOPIFY_theme__ID['id'] , "about___section" , "sections" ,  file_get_contents(getcwd() . "/scripts/sections/about/". 'about_1' .".txt")  );
// UPDATE_assets__shopifyStore__($access_token, $host_shop , SHOPIFY__VERSION , $SHOPIFY_theme__ID['id'] , "about___section" , "sections" ,  file_get_contents(getcwd() . "/scripts/sections/about/". 'about_1' .".txt")  );

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/overcast/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/sweetalert2.min.css">
    <link rel="stylesheet" href="./css/tailwindoutput.css">
    <link rel="stylesheet" href="./css/custom.css">
    <link href="./css/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">


    <!-- CSS -->

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>

    <script src="./js/sweetalert2.all.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v6.1.1/js/all.js" integrity="sha384-xBXmu0dk1bEoiwd71wOonQLyH+VpgR1XcDH3rtxrLww5ajNTuMvBdL5SOiFZnNdp" crossorigin="anonymous"></script>
    <script src="./js/jquery.overlayScrollbars.js"></script>
    <script src="./js/year-select.js"></script>

    <!-- JS -->

    <title>Document</title>
</head>

<body class="" id="BODY__APP_MAIN__id">
    <div class="overlay"></div>


    <!-- This example requires Tailwind CSS v2.0+ -->
    <!--
  This example requires updating your template:

  ```
  <html class="h-full bg-gray-100">
  <body class="h-full">
  ```
-->
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow">

                        </div>
                        <div class="hidden md:block">
                            <div class="ml-5 flex items-baseline space-x-6">
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                <a class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium dashboard__body_btn" aria-current="page">Dashboard</a>
                                <a class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium settings__body_btn">Settings</a>
                                <a class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium plans__body_btn">Plans</a>

                            </div>
                        </div>
                    </div>




                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" id="open_menu_btn___id" class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <!-- Heroicon name: outline/menu Menu open: "hidden", Menu closed: "block" -->
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <!-- Heroicon name: outline/x Menu open: "block", Menu closed: "hidden" -->
                            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a class="bg-gray-900 text-white  px-3 py-2 rounded-md text-sm font-medium dashboard__body_btn" aria-current="page">Dashboard</a>
                    <a class="text-gray-300 hover:bg-gray-700 hover:text-white  px-3 py-2 rounded-md text-sm font-medium settings__body_btn">Settings</a>
                    <a class="text-gray-300 hover:bg-gray-700 hover:text-white  px-3 py-2 rounded-md text-sm font-medium plans__body_btn">Plans</a>
                </div>

            </div>
        </nav>

        <header class="sm:hidden bg-white shadow" id="heading__text_id">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            </div>
        </header>
        <main>
            <div class="min-w-full mx-auto min-h-full py-6 sm:px-4 lg:px-4">
                <!-- Replace with your content -->
                <div class="px-2 py-2 sm:px-0">

                    <!-- /Start DashBoard Block -->
                    <div class="dashboard__Body_" id="dashboard__Body_id">
                        <div class="">
                            <div class="border-0 border-dashed border-gray-200 rounded-lg sm:min-h-96 min-h-full overflow-auto">
                                <?php include('./dashboard_page.php'); ?>
                            </div>
                        </div>
                        <br>
                        <br>
                        <hr>
                        <div class="">
                            <?php include('./details_table2.php'); ?>
                            <?php include('./details_table.php'); ?>
                        </div>
                    </div>
                    <!-- /End DashBoard Block -->

                    <!-- /Start Settings Block -->
                    <div class="settings__Body_" id="settings__Body_id">
                        <div class="">
                            <div class="border-0 border-dashed border-gray-200 rounded-lg sm:min-h-96 min-h-full overflow-auto">
                                <?php include('./settings_page.php'); ?>
                            </div>
                        </div>
                    </div>
                    <!-- /End Settings Block -->

                    <!-- /Start Plans Block -->
                    <div class="plans__Body_" id="plans__Body_id">
                        <div class="">
                            <div class="border-0 border-dashed border-gray-200 rounded-lg sm:min-h-96 min-h-full overflow-auto">
                                <?php include('./plans_page.php'); ?>
                            </div>
                        </div>
                    </div>
                    <!-- /End Plans Block -->

                </div>
                <!-- /End replace -->
            </div>
        </main>
    </div>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.2/alpine.js" defer></script> -->
    <script src="./js/custom.js"></script>
    <script>
        // $("input[name='section_delete_radio_4']:checked").val(); 
        // $("input:radio[name='section_delete_radio_15'][value='1']").prop('checked', true);
        // setTimeout(function(){
        //     $("body#BODY__APP_MAIN__id").removeClass('loading');
        // }, 1000);

    
        

        $('.select_model_year').yearselect({
            start: 1950,
            end: (new Date).getFullYear() + 30
        });

        $("#settings__Body_id").hide();
        $("#plans__Body_id").hide();



        $(".settings__body_btn").on("click", () => {
            $("#settings__Body_id").show();
            $("#plans__Body_id").hide();
            $("#dashboard__Body_id").hide();
            $(".dashboard__body_btn , .plans__body_btn").removeClass("bg-gray-900 text-white  px-3 py-2 rounded-md text-sm font-medium").addClass("text-gray-300 hover:bg-gray-700 hover:text-white  px-3 py-2 rounded-md text-sm font-medium");
            $(this).removeClass("text-gray-300 hover:bg-gray-700 hover:text-white  px-3 py-2 rounded-md text-sm font-medium").addClass("bg-gray-900 text-white  px-3 py-2 rounded-md text-sm font-medium");
            if (window.innerWidth <= 425) {
                $('#mobile-menu').addClass("sm:hidden").toggle();
            }
            $("#heading__text_id").find("h1").text($($(".settings__body_btn")[0]).text());
        });

        $(".plans__body_btn").on("click", () => {
            $("#plans__Body_id").show();
            $("#dashboard__Body_id").hide();
            $("#settings__Body_id").hide();
            $(".settings__body_btn , .dashboard__body_btn").removeClass("bg-gray-900 text-white  px-3 py-2 rounded-md text-sm font-medium").addClass("text-gray-300 hover:bg-gray-700 hover:text-white  px-3 py-2 rounded-md text-sm font-medium");
            $(this).removeClass("text-gray-300 hover:bg-gray-700 hover:text-white  px-3 py-2 rounded-md text-sm font-medium").addClass("bg-gray-900 text-white  px-3 py-2 rounded-md text-sm font-medium");
            if (window.innerWidth <= 425) {
                $('#mobile-menu').addClass("sm:hidden").toggle();
            }
            $("#heading__text_id").find("h1").text($($(".plans__body_btn")[0]).text());
        });

        $(".dashboard__body_btn").on("click", () => {
            $("#dashboard__Body_id").show();
            $("#plans__Body_id").hide();
            $("#settings__Body_id").hide();
            $(".settings__body_btn , .plans__body_btn").removeClass("bg-gray-900 text-white  px-3 py-2 rounded-md text-sm font-medium").addClass("text-gray-300 hover:bg-gray-700 hover:text-white  px-3 py-2 rounded-md text-sm font-medium");
            $(this).removeClass("text-gray-300 hover:bg-gray-700 hover:text-white  px-3 py-2 rounded-md text-sm font-medium").addClass("bg-gray-900 text-white  px-3 py-2 rounded-md text-sm font-medium");
            if (window.innerWidth <= 425) {
                $('#mobile-menu').addClass("sm:hidden").toggle();
            }
            $("#heading__text_id").find("h1").text($($(".dashboard__body_btn")[0]).text());
        });

        $("#open_menu_btn___id").on("click", () => {
            $('#mobile-menu').addClass("sm:hidden").toggle();
        });

        $("#v-section-names_tab___id").on("click", function() {
            $(this).find("button").removeClass("bg-white rounded-lg shadow text-indigo-900");
            $(this).find("button.active").addClass("bg-white rounded-lg shadow text-indigo-900");
        });

        $('.info__alert__btn').on('click', () => {
            $("#info__alert__id").remove();
        });



        $('body').overlayScrollbars({
            // none || both  || horizontal || vertical || n || b || h || v
            resize: 'none',
            className: "os-theme-dark",
            // nativeScrollbarsOverlaid: {
            //     showNativeScrollbars: false, //true || false
            //     initialize: true //true || false
            // },
            // Defines how the overflow should be handled for each axis
            overflowBehavior: {
                x: 'scroll',
                y: 'scroll'
            },
            // scrollbars: {
            //     visibility: 'auto', //visible || hidden || auto || v || h || a
            //     autoHide: 'never', //never || scroll || leave || n || s || l
            //     dragScrolling: true, //true || false
            //     clickScrolling: false, //true || false
            //     touchSupport: true, //true || false
            //     snapHandle: true //true || false
            // }

        });
        $('.SHOPIFY_ALL_themesTable__DIV').overlayScrollbars({
            className: "os-theme-light"
        });
        $('.SECTIONS___DIV').overlayScrollbars({
            className: "os-theme-light",
            overflowBehavior: {
                x: 'scroll',
                y: 'scroll'
            },
        });


        $("#save__data").on('click', function(e) {
            e.preventDefault();
            var formdata = new FormData($("#createData__form_id").get(0));
            if ($("#select_make_id").val() != '' && $("#select_model_id").val() != '') {
                $.ajax({
                    url: "create__ajax.php",
                    type: "POST",
                    data: formdata,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#err").fadeOut();
                    },
                    success: function(data) {
                        var DATA_resp = JSON.parse(data);
                        data_for_Updating = DATA_resp.data;
                        if (DATA_resp.status == "Success") {
                            Swal.fire({
                                icon: 'success',
                                title: DATA_resp.status,
                                text: "Data Inserted.",
                                // footer: '<a href="">Why do I have this issue?</a>'
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: DATA_resp.status,
                                text: DATA_resp.data,
                                // footer: '<a href="">Why do I have this issue?</a>'
                            });
                        }
                    },
                    error: function(e) {
                        $("#err").html(e).fadeIn();
                    }
                });
            }
        });


        function delete__listData(ele) {
            var delete_id = $(ele).attr('data-delete-id');
            $.ajax({
                url: "delete__ajax.php",
                type: "POST",
                async: false,
                data: {
                    'section_id': delete_id,
                    'delete_action': 1
                },
                success: function(data) {
                    var DATA_resp = JSON.parse(data);
                    data_for_Updating = DATA_resp.data;
                    if (DATA_resp.status == "Success") {
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: DATA_resp.status,
                            text: DATA_resp.data,
                            // footer: '<a href="">Why do I have this issue?</a>'
                        });
                    }
                },
                error: function(e) {}
            });
        }

        $('.delete-btn').on("click", function(e) {
            var delete_id = $(this).attr('data-delete-id');
            $.ajax({
                url: "delete__ajax.php",
                type: "POST",
                async: false,
                data: {
                    'section_id': delete_id,
                    'delete_action': 1
                },
                success: function(data) {
                    var DATA_resp = JSON.parse(data);
                    data_for_Updating = DATA_resp.data;
                    if (DATA_resp.status == "Success") {
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: DATA_resp.status,
                            text: DATA_resp.data,
                            // footer: '<a href="">Why do I have this issue?</a>'
                        });
                    }
                },
                error: function(e) {}
            });
        });


        ////////////////////////
    </script>


    <script>
        //console.log($("#nws_years_options_id").val());	
        $('.nws_search_template').hide();
        $.ajax({
            url: "https://console.autooutletllc.com/autominiapp_search/getting_ajax__years.php",
            type: "POST",
            data: {},
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                var DATA_resp = JSON.parse(data);
                data_for_Updating = DATA_resp.data;
                if (DATA_resp.status == "Success") {
                    //console.log(DATA_resp.data);
                    $("#nws_years_options_id").html("");
                    $("#nws_make_options_id").html("");
                    $("#nws_model_options_id").html("");
                    $("#nws_years_options_id").append(`<option value="">select</option>`);
                    $("#nws_make_options_id").append(`<option value="">select</option>`);
                    $("#nws_model_options_id").append(`<option value="">select</option>`);

                    $('.nws_search_template').show();

                    DATA_resp.data.forEach(function(element) {
                        $("#nws_years_options_id").append(`<option value="` + element[0] + `">` + element[0] + `</option>`);
                    });
                    if ($("#nws_years_options_id").val() == "") {
                        $("#nws_make_options_id").html("");
                        $("#nws_make_options_id").append(`<option value="">Select</option>`);

                        $("#nws_model_options_id").html("");
                        $("#nws_model_options_id").append(`<option value="">Select</option>`);

                        $("#nws_make_options_id").attr('disabled', 'disabled');
                        $("#nws_model_options_id").attr('disabled', 'disabled');
                    }
                    ////////////////////////////////////////////////
                } else {
                    $('.nws_search_template').show();
                    $("#nws_years_options_id").html("");
                    $("#nws_years_options_id").append(`<option value="">Select</option>`);

                    $("#nws_make_options_id").html("");
                    $("#nws_make_options_id").append(`<option value="">Select</option>`);

                    $("#nws_model_options_id").html("");
                    $("#nws_model_options_id").append(`<option value="">Select</option>`);
                }
            },
            error: function(e) {
                $('.nws_search_template').show();
                $("#nws_years_options_id").html("");
                $("#nws_years_options_id").append(`<option value="">Select</option>`);

                $("#nws_make_options_id").html("");
                $("#nws_make_options_id").append(`<option value="">Select</option>`);

                $("#nws_model_options_id").html("");
                $("#nws_model_options_id").append(`<option value="">Select</option>`);
            }
        });

        $("#nws_years_options_id").on('change', function() {
            if ($("#nws_years_options_id :selected").val() != "") {
                $("#nws_make_options_id").prop('disabled', false);

                $("#nws_make_options_id").html("");
                $("#nws_make_options_id").append(`<option value="">Select</option>`);
                $("#nws_model_options_id").html("");
                $("#nws_model_options_id").append(`<option value="">Select</option>`);

                $.ajax({
                    url: "https://console.autooutletllc.com/autominiapp_search/getting_ajax__make.php",
                    type: "POST",
                    data: {
                        'fyear___': $("#nws_years_options_id :selected").val()
                    },
                    //             contentType: false,
                    //             cache: false,
                    //             processData: false,
                    success: function(data) {
                        var DATA_resp = JSON.parse(data);
                        data_for_Updating = DATA_resp.data;
                        if (DATA_resp.status == "Success") {
                            //  console.log(DATA_resp.data);
                            DATA_resp.data.forEach(function(element) {
                                $("#nws_make_options_id").append(`<option value="` + element[0] + `">` + element[0] + `</option>`);
                            });
                            if ($("#nws_years_options_id").val() == "") {

                                $("#nws_model_options_id").html("");
                                $("#nws_model_options_id").append(`<option value="">Select</option>`);

                                $("#nws_model_options_id").attr('disabled', 'disabled');
                            }
                            /////////////////////////////////////////////////////////////////////

                        } else {

                            $("#nws_make_options_id").html("");
                            $("#nws_make_options_id").append(`<option value="">Select</option>`);

                            $("#nws_model_options_id").html("");
                            $("#nws_model_options_id").append(`<option value="">Select</option>`);
                            $("#nws_model_options_id").attr('disabled', 'disabled');

                        }

                    },
                    error: function(e) {
                        $("#nws_make_options_id").html("");
                        $("#nws_make_options_id").append(`<option value="">Select</option>`);

                        $("#nws_model_options_id").html("");
                        $("#nws_model_options_id").append(`<option value="">Select</option>`);
                        $("#nws_model_options_id").attr('disabled', 'disabled');
                    }
                });



            } else {
                $("#nws_make_options_id").html("");
                $("#nws_make_options_id").append(`<option value="">Select</option>`);

                $("#nws_model_options_id").html("");
                $("#nws_model_options_id").append(`<option value="">Select</option>`);
                $("#nws_model_options_id").attr('disabled', 'disabled');

            }
        });


        $("#nws_make_options_id").on('change', function() {
            if ($("#nws_make_options_id :selected").val() != "") {
                $("#nws_model_options_id").prop('disabled', false);

                $("#nws_model_options_id").html("");
                $("#nws_model_options_id").append(`<option value="">Select</option>`);

                $.ajax({
                    url: "https://console.autooutletllc.com/autominiapp_search/getting_ajax__model.php",
                    type: "POST",
                    data: {
                        'fyear___': $("#nws_years_options_id :selected").val(),
                        'fmake___': $("#nws_make_options_id :selected").val()
                    },
                    //             contentType: false,
                    //             cache: false,
                    //             processData: false,
                    success: function(data) {
                        var DATA_resp = JSON.parse(data);
                        data_for_Updating = DATA_resp.data;
                        if (DATA_resp.status == "Success") {
                            //  console.log(DATA_resp.data);
                            DATA_resp.data.forEach(function(element) {
                                $("#nws_model_options_id").append(`<option value="` + element[0] + `">` + element[0] + `</option>`);
                            });
                            if ($("#nws_make_options_id").val() == "") {

                                $("#nws_model_options_id").html("");
                                $("#nws_model_options_id").append(`<option value="">Select</option>`);

                                $("#nws_model_options_id").attr('disabled', 'disabled');
                            }
                            /////////////////////////////////////////////////////////////////////

                        } else {

                            $("#nws_model_options_id").html("");
                            $("#nws_model_options_id").append(`<option value="">Select</option>`);
                            $("#nws_model_options_id").attr('disabled', 'disabled');

                        }

                    },
                    error: function(e) {
                        $("#nws_make_options_id").html("");
                        $("#nws_make_options_id").append(`<option value="">Select</option>`);

                        $("#nws_model_options_id").html("");
                        $("#nws_model_options_id").append(`<option value="">Select</option>`);
                        $("#nws_model_options_id").attr('disabled', 'disabled');
                    }
                });
            } else {
                $("#nws_model_options_id").html("");
                $("#nws_model_options_id").append(`<option value="">Select</option>`);
                $("#nws_model_options_id").attr('disabled', 'disabled');

            }
        });
    </script>



</body>

</html>

<?php

?>