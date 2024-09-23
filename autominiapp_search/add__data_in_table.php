<?php
include_once("./inc/database.php");
include_once("./inc/functions.php");

$sql = "SELECT * FROM `xml_test_view` ";
$GET_ALL__DATA = $db2->query($sql);

// print_r($GET_ALL__DATA);

if (mysqli_num_rows($GET_ALL__DATA) >= 0) {
    $GOT_ALL__DATA_ARRAY = mysqli_fetch_all($GET_ALL__DATA);
    // print_r($GOT_ALL__DATA_ARRAY);
    foreach ($GOT_ALL__DATA_ARRAY as $key => $value) :
        // print_r($value);
        // echo PHP_EOL;
        
        $sql = "SELECT * FROM `auto_mmy_data` WHERE `year` = '$value[0]' AND `make` = '$value[1]' AND `model` = '$value[2]'";
        $GOT_res = $db->query($sql);
        if($GOT_res){
            if (mysqli_num_rows($GOT_res) == 0) {
                // echo "";
                $sql = "INSERT INTO `auto_mmy_data`( `year`, `make`, `model`) VALUES ( '$value[0]', '$value[1]', '$value[2]' )";
                $insert = $db->query($sql);
                
            }
        }

    endforeach;
}

