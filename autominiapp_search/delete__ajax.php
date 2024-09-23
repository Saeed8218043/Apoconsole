<?php
include_once("./inc/database.php");
include_once("./inc/functions.php");

if (!empty($_POST['delete_action']) && !empty($_POST['section_id'])) {
    $id_to_Delete = $_POST['section_id'];
    $sql = "DELETE FROM `auto_mmy_data` WHERE `id` = '$id_to_Delete'";
    $delete = $db->query($sql);
    // ($delete) ? ( "" ) : ( "" );
    if ($delete) {
        echo json_encode(array("status" => "Success", "data" => "data has Deleted."));
        die();
    } else {
        echo json_encode(array("status" => "Fail", "data" => "ERROR: Could not Delete!"));
        die();
    }
} else {
    echo json_encode(array("status" => "Fail", "data" => "ERROR: Could not Delete!"));
    die();
};
