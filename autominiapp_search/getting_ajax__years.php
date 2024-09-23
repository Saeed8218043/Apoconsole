<?php
header('Access-Control-Allow-Origin: *');
header('Content-Security-Policy: frame-ancestors *');
include_once("./inc/database.php");
include_once("./inc/functions.php");



echo getting__details($db2);


function getting__details($db)
{
    // $sql = "SELECT `year` FROM `auto_mmy_data` GROUP BY `year`";
    $sql = "SELECT `from_year` FROM `xml_test` GROUP BY `from_year`";
    // $GET_ALL__DATA = $db->query($sql);
    $GET_ALL__DATA = $db->query($sql);
    if($GET_ALL__DATA){
        if (mysqli_num_rows($GET_ALL__DATA) >= 0) {
            $GOT_ALL__DATA_ARRAY = mysqli_fetch_all($GET_ALL__DATA);
            return json_encode(array("status" => "Success", "data" => $GOT_ALL__DATA_ARRAY));
        }else{
            return json_encode(array("status" => "Fail", "data" => []));            
        }
    }else{
        return json_encode(array("status" => "Fail", "data" => []));
    }
}