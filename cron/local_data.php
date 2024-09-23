<?php

// $conn = ftp_connect('ftp.autooutletllc.com');

// $conn = ftp_ssl_connect('ftp.autooutletllc.com');



// if (!$conn){
//     exit("ftp connection failed");
// }
// exit();
chdir('/home/saeed/Downloads/apoconsole/cron/');


$dir = '/home/saeed/Downloads/apoconsole/cron/trq_inventory/';
foreach(glob($dir.'*.csv') as $v){
    unlink($v);
}

// $dir = '/home/saeed/Downloads/apoconsole/cron/pf/';
// foreach(glob($dir.'*.zip') as $v){
//     unlink($v);
// }

$dir = '/home/saeed/Downloads/apoconsole/cron/pf/';
foreach(glob($dir.'*.csv') as $v){
    unlink($v);
}

$dir = '/home/saeed/Downloads/apoconsole/cron/unity/';
foreach(glob($dir.'*.csv') as $v){
    unlink($v);
}

// $dir = '/home/saeed/Downloads/apoconsole/cron/Tracking/';
// foreach(glob($dir.'*.csv') as $v){
//     unlink($v);
// }


// connect
// $conn = ftp_connect('ftp.autooutletllc.com');

// if (!$conn){
//     exit("ftp connection failed");
// }


// $A= ftp_login($conn, 'console@autooutletllc.com', 'Cj4!PO(@OCU]');
// ftp_set_option($conn, FTP_USEPASVADDRESS, false); // set ftp option
// ftp_pasv($conn, true); //make connection to passive mode

  

// ########################### get tracking file
// ftp_chdir($conn, "/autooutletllc.com");
// ftp_chdir($conn, "trqinventory");
// ftp_chdir($conn, "Tracking");

// $files = scandir("/home/apoconsole/apoconsole.com/trqinventoryfeed/Tracking");

// $mostRecent = array(
//     'time' => 0,
//     'file' => null
// );

// foreach ($files as $file) {
//     // get the last modified time for the file
//     if (!is_dir("/home/apoconsole/apoconsole.com/trqinventoryfeed/Tracking/".$file)){
//         $time = filemtime("/home/apoconsole/apoconsole.com/trqinventoryfeed/Tracking/".$file);
    
    
//         if ($time > $mostRecent['time']) {
//             // this file is the most recent so far
//             $mostRecent['time'] = $time;
//             $mostRecent['file'] = $file;
//         }
//     }
// }


// if ($mostRecent['file']){
//     copy("/home/apoconsole/apoconsole.com/trqinventoryfeed/Tracking/".$mostRecent['file'] , "Tracking/".$mostRecent['file']);
// }


// ########################### get tracking file end

// get list of files on given path
$files = scandir("/home/saeed/Documents/apoconsole.com/trqinventoryfeed/InventoryAndPrices");

$mostRecent = array(
    'time' => 0,
    'file' => null
);

foreach ($files as $file) {
    // get the last modified time for the file
    if (!is_dir("/home/saeed/Documents/apoconsole.com/trqinventoryfeed/InventoryAndPrices/".$file)){
        $time = filemtime("/home/saeed/Documents/apoconsole.com/trqinventoryfeed/InventoryAndPrices/".$file);
    
    
        if ($time > $mostRecent['time']) {
            // this file is the most recent so far
            $mostRecent['time'] = $time;
            $mostRecent['file'] = $file;
        }
    }
}


if ($mostRecent['file']){
    copy("/home/saeed/Documents/apoconsole.com/trqinventoryfeed/InventoryAndPrices/".$mostRecent['file'] , "trq_inventory/".$mostRecent['file']);
    $trq_file = $mostRecent['file'];
}
copy("/home/saeed/Documents/apoconsole.com/unityapinventoryfeed/Auto Outlet Inventory.csv" , "unity/unity_Inventory.csv");
$unity_file = "Auto_Outlet_Inventory.csv";




// ****************************************************************************************


$f = fopen("pf/pf.zip",'w+');

// fwrite($f,file_get_contents("http://pf.autooutletllc.com/"));

fclose($f);

$pf_file='pf.zip';



// ****************************************************************************************

$servername = "localhost";
$username = "saeed";
$password = 'P@ssw0rd';
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

// SET PERSIST local_infile = 1;

// function scan($dir) {
//     $ignored = array('.', '..', '.svn', '.htaccess','.xlsx'); // -- ignore these file names
//     $files = array(); //----------------------------------- create an empty files array to play with
//     foreach (scandir($dir) as $file) {
//         if ($file[0] === '.') continue; //----------------- ignores all files starting with '.'
//         if (in_array($file, $ignored)) continue; //-------- ignores all files given in $ignored
//         $files[$file] = filemtime($dir . '/' . $file); //-- add to files list
//     }
//     arsort($files); //------------------------------------- sort file values (creation timestamps)
//     $files = array_keys($files); //------------------------ get all files after sorting
//     return ($files) ? $files : false;
// }




// $files = scan('/home/autoqete/autooutletllc.com/trqinventory/InventoryAndPrices/','SCANDIR_SORT_ASCENDING');
// $newest_file = $files[0];

$conn->query("TRUNCATE trq");
$conn->query("TRUNCATE unity");



$sql = "LOAD DATA local INFILE '/home/saeed/Downloads/apoconsole/cron/trq_inventory/".$trq_file."' INTO TABLE trq FIELDS TERMINATED BY ',' IGNORE 1 LINES";
$sql_unity = "LOAD DATA local INFILE '/home/saeed/Downloads/apoconsole/cron/unity/Auto_Outlet_Inventory.csv' INTO TABLE unity FIELDS TERMINATED BY ',' IGNORE 1 LINES";
// $sql = "INSERT INTO `auto_outlet` (`id`, `ExtractRunId`, `PartNumber`, `BasePartNumber`, `CorePartNumber`, `ProductLine`, `SequenceNumber`, `SubProductLine`, `ImagePath`, `WebDescription1`, `WebDescription2`, `WebDescription3`, `FrenchDescription1`, `FrenchDescription2`, `DefaultUnitOfMeasure`, `SecurityCode`, `SoldOnWeb`, `PlatinumPlus`, `Capa`, `KeyTrac`, `C2COnWeb`, `OverSize`, `ValueLine`, `NSF`, `Weight`, `ListPrice`, `CustomerPrice`, `QuantityAvailable`, `DateCreated`, `Length`, `Width`, `Depth`, `HighRisk`, `Reman`) VALUES ('', 'f', 's', 'gsd', 'sdf', 'sdf', 'fsd', 'fg', 'sdf', 'sg', 'fsd', 'sdf', 'dfs', 'dfs', NULL, NULL, NULL, 'fsd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";




if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->query("UPDATE `trq` SET `created_at`=now() WHERE 1");
$conn->query($sql_unity);



// $conn->query("INSERT INTO `inventory_prices`(`part_no`, `sku`, `created_at`, `updated_at`)
// SELECT trq.PartNumber AS part_no, trq.PartNumber AS sku, NOW(), NOW() FROM `trq` 
// LEFT JOIN inventory_prices on inventory_prices.part_no = trq.PartNumber
// WHERE inventory_prices.part_no IS NULL
// LIMIT 500");

// $sql1 = "SELECT inventory_prices.id  FROM inventory_prices 
// INNER JOIN trq ON inventory_prices.part_no = trq.PartNumber
// AND inventory_prices.cost != trq.price";
// $conn->query($sql1);



// ---------------------------------------  Upload PF Vendor csv File -------------------------------------------------

$zip = new ZipArchive;
$res = $zip->open('pf/pf.zip');
$file =  $zip->getFromName(str_replace('zip','txt',$pf_file));
echo $res;
$f = fopen('pf/pf.csv','w+');
fwrite($f,$file);
fclose($f);
$zip->close();
$conn->query("TRUNCATE pf");
$conn->query("LOAD DATA local INFILE '/home/saeed/Downloads/apoconsole/cron/pf/pf.csv' INTO TABLE pf FIELDS TERMINATED BY '\t' ENCLOSED BY '\"' ESCAPED BY '' LINES TERMINATED BY '\n' IGNORE 1 LINES (@col1, @col2, @col3, @col4, @col5, @col6, @col7, @col8, @col9, @col10, @col11, @col12, @col13, @col14, @col15, @col16, @col17) 
         set SKU = CONCAT(' ',@col1,' ',@col4,' ',@col5,' '), PARTSLINK = @col4, OEM_NUMBER=@col5, PRICE=@col8, QTY=@col17 ");
// ---------------------------------------------------------------------------------------------------------------------



  $conn->query('UPDATE pf_inventory SET found = 0');

         $conn->query("UPDATE pf_inventory 
INNER JOIN pf ON pf.SKU LIKE CONCAT('% ',pf_inventory.part_no,' %') 
SET pf_inventory.cost = pf.PRICE ,pf_inventory.qty = pf.QTY, pf_inventory.found = 1");  



           
           $conn->query("UPDATE pf_kit_inventory
            SET pf_kit_inventory.price = (SELECT SUM(pf_inventory.cost + pf_inventory.fee + pf_inventory.shipping + pf_inventory.commission + pf_inventory.profit) FROM pf_inventory WHERE kit_id=pf_kit_inventory.id),
            pf_kit_inventory.inventory = (SELECT SUM(pf_inventory.qty) FROM pf_inventory WHERE kit_id=pf_kit_inventory.id)");
            
            $conn->query("UPDATE pf_kit_inventory
            LEFT JOIN pf_inventory ON pf_inventory.kit_id = pf_kit_inventory.id
            SET pf_kit_inventory.inventory = 0
            WHERE pf_inventory.qty = 0");


       
   foreach (mysqli_fetch_all($conn->query("SELECT * FROM `price_setting` WHERE vendor_id=2"),MYSQLI_ASSOC) as $key) {
        $conn->query("UPDATE `pf_inventory` SET `fee`= (`cost` * ".($key['fee']/100).") ,`commission`= (`cost` * ".($key['commission']/100).") ,`shipping`= (`cost` * ".($key['shipping']/100).") ,`profit`= (`cost` * ".($key['profit']/100).")  WHERE  pricemasterrule=1"); 
       }




?>