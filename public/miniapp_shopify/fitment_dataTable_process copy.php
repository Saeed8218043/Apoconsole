<?php
header('Access-Control-Allow-Origin: *');
header('Content-Security-Policy: frame-ancestors *');
include_once("./inc/database.php");
include_once("./inc/functions.php");

if (isset($_POST['sku___']) && isset($_POST['get__table_data']) && isset($_POST['is_bundle'])) {

    if ($_POST['sku___'] != "" && $_POST['get__table_data'] == "getData") {

        // echo sizeof($_POST['sku___']);
        if (sizeof($_POST['sku___']) > 0) {
            $Final__data__ARRAY = array();
            for ($s = 0; $s < sizeof($_POST['sku___']); $s++) {
                // echo "SKU :: " . $_POST['sku___'][$s] . PHP_EOL ;
                $temp_year = "";
                $temp_sku = $_POST['sku___'][$s];
                $Get__data = $db->query("SELECT `part_no`, `make_id`, `model_id`, `note` FROM `xml_test` WHERE `part_no` = '" . $temp_sku . "' GROUP BY `xml_test`.`model_id` ORDER BY `xml_test`.`model_id` ");
                if (mysqli_num_rows($Get__data) > 0) {
                    $Get__data_ARRAY = mysqli_fetch_all($Get__data);

                    foreach ($Get__data_ARRAY as $key => $gotData) {
                        // print_r($gotData);
                        $p_id = $gotData[0];
                        $m_id = $gotData[1];
                        $mo_id = $gotData[2];
                        $Note = $gotData[3];
                        // echo $p_id . " ---  " . $m_id . " ---  ". $mo_id ;
                        $Get__year = $db->query("SELECT `from_year` as 'year' FROM `xml_test` WHERE ( `part_no` = '". $p_id ."' AND `make_id` = '". $m_id ."' AND `model_id` = '". $mo_id ."' ) ORDER BY `year` ASC limit 1 ");
                        // print_r($Get__year);

                        $f_year = "";
                        if (mysqli_num_rows($Get__year) > 0) {
                            $f_year = mysqli_fetch_row($Get__year);
                            $f_year = $f_year[0];
                        }
                        $Get__year = $db->query("SELECT `from_year` as 'year' FROM `xml_test` WHERE ( `part_no` = '". $p_id ."' AND `make_id` = '". $m_id ."' AND `model_id` = '". $mo_id ."' ) ORDER BY `year` DESC limit 1 ");
                        // print_r($Get__year);
                        $l_year = "";
                        if (mysqli_num_rows($Get__year) > 0) {
                            $l_year = mysqli_fetch_row($Get__year);
                            $l_year = $l_year[0];
                        }
                        
                        array_push($Final__data__ARRAY , 
                            array(
                                'part_no' => $p_id,
                                'make_id' => $m_id,
                                'model_id' => $mo_id,
                                'note' => $Note,
                                'year' => $f_year."-".$l_year
                            )
                        );

                    }

                }
                // print_r( $Final__data__ARRAY );
                echo json_encode(["status" => true, "data" => $Final__data__ARRAY ]);
                die();
                // print_r( $Get__data_ARRAY );
            }
        } else {
            echo json_encode(["status" => false, "data" => "No Data Found"]);
            die();
        }
    } else {
        echo json_encode(["status" => false, "data" => "No Data Found"]);
        die();
    }
} else {
    echo json_encode(["status" => false, "data" => "No Data Found"]);
    die();
}
