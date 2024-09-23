<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Security-Policy: frame-ancestors *');
    include_once("./inc/database.php");
    include_once("./inc/functions.php");

    
    
    if( isset($_POST['sku_']) && isset($_POST['year_']) && isset($_POST['model_'])  && isset($_POST['make_'])   ){
        if(  $_POST['sku_'] != "" && $_POST['year_'] != "" && $_POST['model_'] != "" && $_POST['make_'] != ""   ){
            $sku = $_POST['sku_'];
            $year = $_POST['year_'];
            $model = $_POST['model_'];
            $make = $_POST['make_'];

            $Get_fitment_data = $db->query("SELECT `part_no`, `from_year`, `from_to`, `make_id`, `model_id`, `note` FROM `xml_test` WHERE `part_no` = '". $sku ."' and `from_year` = '". $year ."' and `make_id`= '". $make ."' and `model_id` = '". $model ."' ");
            if (mysqli_num_rows($Get_fitment_data) > 0) {
                $Get_fitment_data_result = mysqli_fetch_all($Get_fitment_data);
                $note = '';
                foreach ($Get_fitment_data_result as $a){
                  $note .= $a[5]; 
                }
                
                // echo '{ "status" : "true" , "data" : "'. json_encode(json_decode(json_encode($Get_fitment_data_result), true )) .'" }';
                echo json_encode([ "status" => true , "data" => [   
                        'part_no' => $Get_fitment_data_result[0][0],
                        'form_year' => $Get_fitment_data_result[0][1],
                        'from_to' => $Get_fitment_data_result[0][2],
                        'make_id' => $Get_fitment_data_result[0][3],
                        'model_id' => $Get_fitment_data_result[0][4],
                        'note' => $note,
                    ] , "Raw_data" => $Get_fitment_data_result
                ]);
                die();
            }else{
                echo json_encode([ "status" => false , "data" => "No match found!" ]);
                die();
            }
        }else{
            // echo '{ "status" : "false" , "data" : "Passing field is empty!" }';
            echo json_encode([ "status" => false , "data" => "Passing field is empty!" ]);
            die();
        }
    }else{
        // echo '{ "status" : "false" , "data" : "fields should not empty" }';
        echo json_encode([ "status" => false , "data" => "fields should not empty" ]);
        die();
    }



