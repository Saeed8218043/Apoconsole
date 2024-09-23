<?php


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

    $conn->query("TRUNCATE pf");
    $csvFilePathForMySQL = '/home/apoconsole/app.apoconsole.com/public/test/PF.csv';
    $conn->query("LOAD DATA LOCAL INFILE '{$csvFilePathForMySQL}' INTO TABLE pf FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '' LINES TERMINATED BY '\n' IGNORE 1 LINES (@col1, @col2, @col3, @col4, @col5, @col6, @col7, @col8, @col9, @col10, @col11, @col12, @col13, @col14, @col15, @col16, @col17) SET SKU = @col1, PARTSLINK = @col4, OEM_NUMBER = @col5, PRICE = @col8, QTY = @col17");

    echo 'Extraction, conversion, and database loading completed successfully.';
