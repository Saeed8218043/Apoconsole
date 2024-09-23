<?php
header('Access-Control-Allow-Origin: *');
header('Content-Security-Policy: frame-ancestors *');
include_once("./inc/database.php");
include_once("./inc/functions.php");


if(isset($_POST['fyear___']) && isset($_POST['fmake___'])){
    $fyear = $_POST['fyear___'];
    $fmake = $_POST['fmake___'];
    
    // echo getting__details($db, $fyear, $fmake);
    echo getting__details($db2, $fyear, $fmake);
}else{
    echo json_encode(array("status" => "Fail", "data" => []));
}



function getting__details($db, $fyear ,$fmake)
{
    $sql = "SELECT `model_id` FROM `xml_test` WHERE `from_year` = '$fyear' AND `make_id` = '$fmake' GROUP BY `model_id`";
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