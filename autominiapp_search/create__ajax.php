<?php
include_once("./inc/database.php");
include_once("./inc/functions.php");

if( isset($_POST['select_model_year']) && isset($_POST['select_make']) & isset($_POST['select_model'])  ){
    
    $year = isset($_POST['select_model_year']) ? $_POST['select_model_year'] : "";
    $make = isset($_POST['select_make']) ? $_POST['select_make'] : "";
    $model = isset($_POST['select_model']) ? $_POST['select_model'] : "";

    $sql = "INSERT INTO `auto_mmy_data`( `year`, `make`, `model`) VALUES ( '$year', '$make', '$model' )";
    $insert = $db->query($sql);
    if($insert){
        echo json_encode(array("status" => "Success", "data" => []));
        die();
    }else{
        echo json_encode(array("status" => "Fail", "data" => "ERROR:: creating data."));
        die();
    }
}else{
    echo json_encode(array("status" => "Fail", "data" => "ERROR:: creating data."));
    die();
}
?>
