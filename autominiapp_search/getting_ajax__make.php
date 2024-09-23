<?php
header('Access-Control-Allow-Origin: *');
header('Content-Security-Policy: frame-ancestors *');
include_once("./inc/database.php");
include_once("./inc/functions.php");


if(isset($_POST['fyear___'])){
    $fyear = $_POST['fyear___'];
    // echo getting__details($db, $fyear);
    echo getting__details($db2, $fyear);
}else{
    echo json_encode(array("status" => "Fail", "data" => []));
}



function getting__details($db, $fyear )
{
    // $sql = "SELECT `make` FROM `auto_mmy_data` WHERE `year` = '$fyear' GROUP BY `make`";
    $sql = "SELECT `make_id` FROM `xml_test` WHERE `from_year` = '$fyear' GROUP BY `make_id`";
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