<?php
header('Access-Control-Allow-Origin: *');
header('Content-Security-Policy: frame-ancestors *');
include_once("./inc/database.php");
include_once("./inc/functions.php");


echo getting__details($db);


function getting__details($db)
{
    $YEARS___ = array();
    $MAKE___ = [];
    $MODEL___ = [];

    $sql = "SELECT `year` FROM `auto_mmy_data` GROUP BY `year`";
    $GET_ALL__YEARS = $db->query($sql);
    if($GET_ALL__YEARS){
        if (mysqli_num_rows($GET_ALL__YEARS) >= 0) {
            $ALL__yeasrs = mysqli_fetch_all($GET_ALL__YEARS);
            $years = $ALL__yeasrs;
            foreach ($years as $key => $year) {
                array_push( $YEARS___ ,  '{ value: "'. $year[0] .'", text: "'. $year[0] .'" }');
            }

            // {
            //     'reg-1': [
            //         { value: 'div-1', text: 'New England' },
            //         { value: 'div-2', text: 'Mid-Atlantic' }
            //     ],
            //     'reg-2': [
            //         { value: 'div-3', text: 'East North Central' },
            //         { value: 'div-4', text: 'West North Central' }
            //     ]
            // }

            foreach ($years as $key => $year) {
                $sql = "SELECT `make` FROM `auto_mmy_data` WHERE `year` = '$year[0]' GROUP BY `make`";
                $GET_ALL__MAKES = $db->query($sql);
                if( mysqli_num_rows($GET_ALL__MAKES) >= 0 ){
                    $ALL__makes = mysqli_fetch_all($GET_ALL__MAKES);
                    $makes = $ALL__makes;
                    // print_r($makes);



                }


            }

            
            return json_encode(array("status" => "Fail", "data" => array( "years" => $YEARS___, "make"=> [] , "model" => [] ) ));     
        }else{
            return json_encode(array("status" => "Fail", "data" => array( "years" => [], "make"=> [] , "model" => [] ) ));     
        }
    }else{
        return json_encode(array("status" => "Fail", "data" => array( "years" => [], "make"=> [] , "model" => [] ) ));
    }
}