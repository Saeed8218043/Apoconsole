<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Security-Policy: frame-ancestors *');
    include_once("./inc/database.php");
    include_once("./inc/functions.php");

    
    
    if( isset($_POST['search_sku']) && isset($_POST['getData_with_sku']) ){
        if(  $_POST['search_sku'] != ""  ){
            $sku = $_POST['search_sku'];
            
            $Get_fitment_data = $db->query("SELECT `part_no`, `from_year`, `make_id`, `model_id` FROM `xml_test` WHERE `part_no` = '". $sku ."' ORDER BY `xml_test`.`from_year` ASC ");
            if (mysqli_num_rows($Get_fitment_data) > 0) {
                $Get_fitment_data_result = mysqli_fetch_all($Get_fitment_data);
                
                
                // echo '{ "status" : "true" , "data" : "'. json_encode(json_decode(json_encode($Get_fitment_data_result), true )) .'" }';
                echo json_encode([ "status" => true , "data" => $Get_fitment_data_result ]);
                die();
            }else{
                echo json_encode([ "status" => false , "data" => [] ]);
                die();
            }
        }else{
            // echo '{ "status" : "false" , "data" : "Passing field is empty!" }';
            echo json_encode([ "status" => false , "data" => [] ]);
            die();
        }
    }else{
        // echo '{ "status" : "false" , "data" : "fields should not empty" }';
        echo json_encode([ "status" => false , "data" => [] ]);
        die();
    }



