<?php

$servername = "localhost";
$username = "consoleautooutle_miniapp";
$password = "consoleautooutle_miniapp";
$database = "consoleautooutle_miniapp";

// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_errno) {
  die("Connection failed: " . $conn->connect_error);
}else{
    echo "Connected successfully<br>";
}

// SET PERSIST local_infile = 1;

function scan($dir) {
    $ignored = array('.', '..', '.svn', '.htaccess'); // -- ignore these file names
    $files = array(); //----------------------------------- create an empty files array to play with
    foreach (scandir($dir) as $file) {
        if ($file[0] === '.') continue; //----------------- ignores all files starting with '.'
        if (in_array($file, $ignored)) continue; //-------- ignores all files given in $ignored
        $files[$file] = filemtime($dir . '/' . $file); //-- add to files list
    }
    arsort($files); //------------------------------------- sort file values (creation timestamps)
    $files = array_keys($files); //------------------------ get all files after sorting
    return ($files) ? $files : false;
}


print_r($files[0]);

// $files = scan('/home/autoqete/autooutletllc.com/trqinventory/Tracking/','SCANDIR_SORT_ASCENDING');
// $newest_file = $files[0];

// $conn->query("TRUNCATE tracking");


// $sql = "LOAD DATA local INFILE '/home/autoqete/autooutletllc.com/trqinventory/Tracking/".$files[0]."' INTO TABLE tracking FIELDS TERMINATED BY ',' IGNORE 1 LINES";

// if ($conn->query($sql) === TRUE) {
//   echo "New record created successfully";
// } else {
//   echo "Error: " . $sql . "<br>" . $conn->error;
// }


// $sql = "LOAD DATA local INFILE '/home/autoqete/autooutletllc.com/trqinventory/Tracking/".$files[1]."' INTO TABLE tracking FIELDS TERMINATED BY ',' IGNORE 1 LINES";




// if ($conn->query($sql) === TRUE) {
//   echo "New record created successfully";
// } else {
//   echo "Error: " . $sql . "<br>" . $conn->error;
// }

// $sql1 = "SELECT inventory_prices.id  FROM inventory_prices 
// INNER JOIN trq ON inventory_prices.part_no = trq.PartNumber
// AND inventory_prices.cost != trq.price";
// $conn->query($sql1);

// $sql2 = "UPDATE inventory_prices 
// RIGHT JOIN trq ON inventory_prices.part_no = trq.PartNumber
// AND inventory_prices.cost != trq.price
// SET inventory_prices.cost = trq.price ,inventory_prices.qty = trq.stock ";



// if ($conn->query($sql2) === TRUE) {
//   echo "record successfully";
// } else {
//   echo "Error: " . $sql . "<br>" . $conn->error;
// }

// echo 'loop';

// foreach($files as $file){
    
//     echo "$file \n";
//  $sql = "LOAD DATA local INFILE '/home/autoqete/autooutletllc.com/trqinventory/Tracking/".$file."' INTO TABLE tracking FIELDS TERMINATED BY ',' IGNORE 1 LINES";

// $conn->query($sql);  
// }






?>