<?php


$servername = "localhost";
$username = "consoleautooutle_miniapp";
$password = "ba4fDUv3mBy8AzpQYAOj";
$database = "consoleautooutle_miniapp";

// Create connection
$conn = new mysqli($servername, $username, $password,$database);

mysqli_options($conn, MYSQLI_OPT_LOCAL_INFILE, true);

// Check connection
if ($conn->connect_errno) {
  die("Connection failed: " . $conn->connect_error);
}else{
    echo "Connected successfully<br>";
}


$conn->query("INSERT INTO `inventory_prices`(`part_no`, `sku`, `created_at`, `updated_at`)
SELECT trq.PartNumber AS part_no, trq.PartNumber AS sku, NOW(), NOW() FROM `trq` 
LEFT JOIN inventory_prices on inventory_prices.part_no = trq.PartNumber
WHERE inventory_prices.part_no IS NULL
LIMIT 500");


?>