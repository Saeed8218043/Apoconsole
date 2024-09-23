<?php
include_once("./inc/database.php");
include_once("./inc/functions.php");



?>
<div class="bg-white dark:bg-gray-800 shadow mb-4 overflow-y-auto">
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Details</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="whitespace-nowrap">ID</th>
                            <th class="whitespace-nowrap">YEAR</th>
                            <th class="whitespace-nowrap">MAKE</th>
                            <th class="whitespace-nowrap">MODEL</th>
                            <th class="whitespace-nowrap actions_____"></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="bg-primary text-white">
                        <th class="whitespace-nowrap">ID</th>
                            <th class="whitespace-nowrap">YEAR</th>
                            <th class="whitespace-nowrap">MAKE</th>
                            <th class="whitespace-nowrap">MODEL</th>
                            <th class="whitespace-nowrap actions_____"></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php Table__details($db); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<?php

function Table__details($db)
{
    $sql = "SELECT `id`, `year`, `make`, `model` FROM `auto_mmy_data` LIMIT 10";
    $GET_ALL__DATA = $db->query($sql);
    $TEMPLATE = "";
    if (mysqli_num_rows($GET_ALL__DATA) >= 0) {
        $GOT_ALL__DATA_ARRAY = mysqli_fetch_all($GET_ALL__DATA);
        foreach ($GOT_ALL__DATA_ARRAY as $key => $value_) {

            $TEMPLATE .= '<tr>
            <td class="px-2 border-b border-gray-200 bg-white text-xs">' . $value_[0] . '</td>
            <td class="px-2 border-b border-gray-200 bg-white text-xs">' . $value_[1] . '</td>
            <td class="px-2 border-b border-gray-200 bg-white text-xs">' . $value_[2] . '</td>
            <td class="px-2 border-b border-gray-200 bg-white text-xs">' . $value_[3] . '</td>';
            $TEMPLATE .= '
                </td>
                <td class="border-b border-gray-200 bg-white text-xs">
                    <a class="btn btn-danger btn-icon-split btn-sm delete-btn" data-delete-id="' . $value_[0] . '">
                        <span class="icon text-white-50"><i class="fas fa-trash"></i></span>
                        <span class="text">Delete</span>
                    </a> 
                </td>
            </tr>';
        }
        echo $TEMPLATE;
    } else {
        echo "<h3>No Record Found.</h3>";
    }
}


?>
<style>
    .actions_____ {
        min-width: 160px;
    }
    .image_____ {
        min-width: 40px;
    }
    /* @media screen and (max-width: 1280px) {
    .col-sm-12.table-responsive {
        min-width: 150vw !important;
    }
}
@media screen and (max-width: 425px) {
    .col-sm-12.table-responsive {
        min-width: 300vw !important;
    }
}
@media screen and (min-width: 1281px) {
    .col-sm-12.table-responsive {
        min-width: 100% !important;
    }
} */
</style>