<?php
//including files
chdir('/home/apoconsole/app.apoconsole.com/cron/');


$dir = '/home/apoconsole/app.apoconsole.com/cron/trq_inventory/';
foreach(glob($dir.'*.csv') as $v){
    unlink($v);
}

$dir = '/home/apoconsole/app.apoconsole.com/cron/pf/';
foreach(glob($dir.'*.zip') as $v){
    unlink($v);
}

$dir = '/home/apoconsole/app.apoconsole.com/cron/pf/';
foreach(glob($dir.'*.csv') as $v){
    unlink($v);
}

$dir = '/home/apoconsole/app.apoconsole.com/cron/unity/';
foreach(glob($dir.'*.csv') as $v){
    unlink($v);
}




//update here
$sourceDir = '/home/apoconsole/apoconsole.com/expressmerch/';
$destinationDir = '/home/apoconsole/app.apoconsole.com/cron/pf/';
$pf_file = 'pf.zip';

$files = scandir($sourceDir);

$mostRecent = array(
    'time' => 0,
    'file' => null
);

foreach ($files as $file) {
    // Check if it's a file and if the filename starts with 'carparts_ds_inv_'
    if (!is_dir($sourceDir . $file) && strpos($file, 'carparts_ds_inv_') === 0) {
        $time = filemtime($sourceDir . $file);

        // Find the most recent file
        if ($time > $mostRecent['time']) {
            $mostRecent['time'] = $time;
            $mostRecent['file'] = $file;
        }
    }
}

if ($mostRecent['file']) {
    $sourceFile = $sourceDir . $mostRecent['file'];
    $destinationFile = $destinationDir . $mostRecent['file'];

    // Copy the most recent file to the destination directory
    copy($sourceFile, $destinationFile);

    // Preserve the original modification time of the file
    $originalFileTime = filemtime($sourceFile);
    touch($destinationFile, $originalFileTime);

    $pf_file = $mostRecent['file'];
}




$files = scandir("/home/apoconsole/apoconsole.com/trqinventoryfeed/InventoryAndPrices");

$mostRecent = array(
    'time' => 0,
    'file' => null
);

foreach ($files as $file) {
    if (!is_dir("/home/apoconsole/apoconsole.com/trqinventoryfeed/InventoryAndPrices/".$file)){
        $time = filemtime("/home/apoconsole/apoconsole.com/trqinventoryfeed/InventoryAndPrices/".$file);


        if ($time > $mostRecent['time']) {
            // this file is the most recent so far
            $mostRecent['time'] = $time;
            $mostRecent['file'] = $file;
        }
    }
}


if ($mostRecent['file']){
       $sourceFile = "/home/apoconsole/apoconsole.com/trqinventoryfeed/InventoryAndPrices/" . $mostRecent['file'];
    $destinationFile = "trq_inventory/" . $mostRecent['file'];

    // Copy the file
    copy($sourceFile, $destinationFile);

    // Get the original file's modification time
    $originalFileTime = filemtime($sourceFile);

    // Set the modified time of the new file to match the original file
    touch($destinationFile, $originalFileTime);

    $trq_file = $mostRecent['file'];
}
// copy("/home/apoconsole/apoconsole.com/unityapinventoryfeed/Auto Outlet Inventory.csv" , "unity/Auto_Outlet_Inventory.csv");
// $unity_file = "Auto_Outlet_Inventory.csv";
$sourceFileUnity = "/home/apoconsole/apoconsole.com/unityapinventoryfeed/Auto Outlet Inventory.csv";
$destinationFileUnity = "unity/Auto_Outlet_Inventory.csv";

// Copy the file
copy($sourceFileUnity, $destinationFileUnity);

// Get the original file's modification time
$originalFileTimeUnity = filemtime($sourceFileUnity);

// Set the modified time of the new file to match the original file
touch($destinationFileUnity, $originalFileTimeUnity);

$unity_file = "Auto_Outlet_Inventory.csv";

$servername = "localhost";
$username = "apoconsole_main";
$password = 'iv$5iJ6lLoy]qOrU(}=gaStE';
$database = "apoconsole_main";

// Create connection
$conn = new mysqli($servername, $username, $password,$database);

mysqli_options($conn, MYSQLI_OPT_LOCAL_INFILE, true);

// Check connection
if ($conn->connect_errno) {
  die("Connection failed: " . $conn->connect_error);
}else{
    echo "Connected successfully<br>";
}


$conn->query("TRUNCATE trq");
$conn->query("TRUNCATE unity");



$sql = "LOAD DATA local INFILE '/home/apoconsole/app.apoconsole.com/cron/trq_inventory/".$trq_file."' INTO TABLE trq FIELDS TERMINATED BY ',' IGNORE 1 LINES";
$sql_unity = "LOAD DATA local INFILE '/home/apoconsole/app.apoconsole.com/cron/unity/Auto_Outlet_Inventory.csv' INTO TABLE unity FIELDS TERMINATED BY ',' IGNORE 1 LINES";




if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->query("UPDATE `trq` SET `created_at`=now() WHERE 1");
$conn->query($sql_unity);



$conn->query("UPDATE inventory_prices SET found = 0");

$conn->query("UPDATE inventory_prices
INNER JOIN trq ON inventory_prices.part_no = trq.PartNumber
SET inventory_prices.cost = trq.price ,inventory_prices.qty = trq.stock,inventory_prices.mapped = trq.map_price, inventory_prices.found = 1");



// ---------------------------------------  Upload PF Vendor csv File -------------------------------------------------

$zip = new ZipArchive;
$res = $zip->open('pf/' . $pf_file);

if ($res === true) {
    $name = $zip->getNameIndex(0);
    $file = $zip->getFromName($name);
    $fileContent = $file;

    // Specify the delimiter used in the text file (tab character)
    $delimiter = "\t";

    // Create an array to store CSV rows
    $csvRows = [];

    // Split the file content into lines
    $lines = explode("\n", $fileContent);

    // Process each line and convert it to CSV format
    foreach ($lines as $index => $line) {
        // Remove leading and trailing whitespaces
        $line = trim($line);

        // Skip empty lines
        if (!empty($line)) {
            // Split the line into fields using the specified delimiter
            $fields = explode($delimiter, $line);

            // If it's the first line, consider it as a header
            if ($index === 0) {
                $header = $fields;
            } else {
                // Add the fields to the CSV rows array
                $csvRows[] = $fields;
            }
        }
    }

    // Adjust the destination CSV file path based on the extracted date
    $csvFilePath = 'pf/' . pathinfo($name, PATHINFO_FILENAME) . '.csv';

    // Open the CSV file for writing
    $f = fopen($csvFilePath, 'w');

    // Write the header to the CSV file
    if (!empty($header)) {
        fputs($f, implode($delimiter, $header) . PHP_EOL);
    }

    // Write CSV rows to the file
    foreach ($csvRows as $csvRow) {
        fputs($f, implode($delimiter, $csvRow) . PHP_EOL);
    }

    // Close the CSV file
    fclose($f);

    $zip->close();

    // Now, load the CSV data into MySQL
    $conn->query("TRUNCATE pf");
    $csvFilePathForMySQL = '/home/apoconsole/app.apoconsole.com/cron/pf/' . pathinfo($name, PATHINFO_FILENAME) . '.csv';
    $conn->query("LOAD DATA LOCAL INFILE '{$csvFilePathForMySQL}' INTO TABLE pf FIELDS TERMINATED BY '{$delimiter}' ENCLOSED BY '\"' ESCAPED BY '' LINES TERMINATED BY '\n' IGNORE 1 LINES (@col1, @col2, @col3, @col4, @col5, @col6, @col7, @col8, @col9, @col10, @col11, @col12, @col13, @col14, @col15, @col16, @col17) SET SKU = @col1, PARTSLINK = @col4, OEM_NUMBER = @col5, PRICE = @col8, QTY = @col17");

    echo 'Extraction, conversion, and database loading completed successfully.';
} else {
    echo 'Failed to open the ZIP file.';
}




// ---------------------------------------------------------------------------------------------------------------------

  $conn->query('UPDATE pf_inventory SET found = 0');

         $conn->query("UPDATE pf_inventory
         INNER JOIN pf ON
             (pf.SKU = pf_inventory.part_no) OR
             (pf.PARTSLINK = pf_inventory.part_no ) OR
             (pf.OEM_NUMBER = pf_inventory.part_no)
         SET
             pf_inventory.cost = pf.PRICE,
             pf_inventory.qty = pf.QTY,
             pf_inventory.shipping = pf.shipping_fee,
             pf_inventory.handling = pf.handling,
             pf_inventory.found = 1;");


          $conn->query("UPDATE pf_kit_inventory
            SET pf_kit_inventory.price = (SELECT SUM(pf_inventory.cost + pf_inventory.fee + pf_inventory.handling + pf_inventory.shipping + pf_inventory.commission + pf_inventory.profit) FROM pf_inventory WHERE kit_id=pf_kit_inventory.id),
            pf_kit_inventory.inventory = (SELECT SUM(pf_inventory.qty) FROM pf_inventory WHERE kit_id=pf_kit_inventory.id)");


            $conn->query("UPDATE pf_kit_inventory LEFT JOIN ( SELECT kit_id, MIN(qty) AS min_qty FROM pf_inventory GROUP BY kit_id ) AS min_qty_table ON pf_kit_inventory.id = min_qty_table.kit_id LEFT JOIN pf_inventory ON pf_inventory.kit_id = pf_kit_inventory.id SET pf_kit_inventory.inventory = 0 WHERE pf_inventory.qty = 0 OR min_qty_table.min_qty < 5;");



         foreach (mysqli_fetch_all($conn->query("SELECT * FROM `price_setting`"), MYSQLI_ASSOC) as $key) {
            $vendorName = $key['vendor_name'];
            $costAdjustment = (100 + $key['price_percentage']) / 100;
            $percentage = (100 - $key['profit']) / 100;

            $updateQuery = "
                UPDATE `inventory_prices`
                SET
                    `fee` = (`cost` * ".($key['fee'] / 100)."),
                    `original_price` = `cost` * ".$costAdjustment.",
                    `commission` = (`cost` * ".($key['commission'] / 100)."),
                    `shipping` = (`cost` * ".($key['shipping'] / 100)."),
                    `profit` = ((`original_price` / ".$percentage.") - (`original_price` * ".$costAdjustment."))
                WHERE
                    `pricemasterrule` = 1
            ";

            $conn->query($updateQuery);
        }

            $vendors = mysqli_fetch_all($conn->query("SELECT * FROM `price_setting`"), MYSQLI_ASSOC);
            foreach ($vendors as $vendor) {
                $costAdjustment = (100 + $vendor['price_percentage'])/100;
                       $vendorName = $vendor['vendor_name'];
                       $percentage = (100 - $vendor['profit'])/100;
                       // Create the update query for `pf_inventory`
                       $updatePfInventoryQuery = "
                           UPDATE `pf_inventory` AS pi
                           JOIN `price_setting` AS ps ON pi.warehouse_name = ps.vendor_name
                           SET
                              pi.original_price = (cost *".$costAdjustment."),
                               pi.fee = (pi.cost * ".($vendor['fee']/100)."),
                               pi.commission = (pi.cost * ".($vendor['commission']/100)."),
                               pi.shipping = (pi.cost * ".($vendor['shipping']/100)."),
                               pi.profit = ((pi.original_price / ".$percentage.")-pi.original_price)
                           WHERE
                               pi.pricemasterrule = 1
                               AND pi.warehouse_name = '$vendorName'
                               AND ps.vendor_name = '$vendorName'
                       ";

                       // Execute the update query for `pf_inventory`
                       $conn->query($updatePfInventoryQuery);
                   }

echo "script ended";


?>
