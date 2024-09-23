<?php
include_once("./inc/database.php");
include_once("./inc/functions.php");


?>

<form action="" method="POST" id="createData__form_id">
    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-md-4">
                <div class="form-floating mb-3">
                    <input class="form-control select_model_year" id="select_model_year_id" name="select_model_year" placeholder="Select Model year" required>
                    <label for="select_model_year_id">Year</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4">
                <div class="form-floating mb-3">
                    <input class="form-control select_make" id="select_make_id" name="select_make" placeholder="Select Model" required>
                    <label for="select_make_id">Make</label>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-floating mb-3">
                    <input class="form-control select_model" id="select_model_id" name="select_model" placeholder="Select Make" required>
                    <label for="select_model_id">Model</label>
                </div>
            </div>
            <br>
            <hr class="submit_btn_spacer">
            <input type="submit" value="save" name="craete_data" id="save__data" class="btn btn-outline-primary">

        </div>
    </div>
</form>