<?php
$dir = '/home/apoconsole/app.apoconsole.com/cron/pf/';
foreach(glob($dir.'*.csv') as $v){
    unlink($v);
}

$file_name = 'carparts_inv_20231019.zip';


$zip = new ZipArchive;
$res = $zip->open('pf/'.$file_name);
$file =  $zip->getFromName(str_replace('zip','txt',$file_name));
$f = fopen('pf/pf.csv','w+');
fwrite($f,$file);
fclose($f);
$zip->close();



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




$conn->query("TRUNCATE pf");
        
        // dd("LOAD DATA local INFILE '/home/autoqete/public_html/miniapp/public/pfvendorcsv/pf.csv' INTO TABLE pf FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '\"' IGNORE 1 LINES");
        
         $conn->query("LOAD DATA local INFILE '/home/apoconsole/app.apoconsole.com/cron/pf/pf.csv' INTO TABLE pf FIELDS TERMINATED BY '\t' ENCLOSED BY '\"' ESCAPED BY '' LINES TERMINATED BY '\n' IGNORE 1 LINES (@col1, @col2, @col3, @col4, @col5, @col6, @col7, @col8, @col9, @col10, @col11, @col12, @col13, @col14, @col15, @col16, @col17) 
         set SKU = @col1, PARTSLINK = @col4, OEM_NUMBER=@col5, PRICE=@col8, QTY=@col17 ");
        
        
//          DB::statement("UPDATE inventory_prices  SET inventory_prices.found = 0 WHERE inventory_prices.vendor = 2");
         
         
//          DB::statement("UPDATE inventory_prices 
//  INNER JOIN pf ON inventory_prices.part_no = pf.PARTSLINK OR inventory_prices.part_no = pf.OEM_NUMBER OR inventory_prices.part_no = pf.SKU
//  SET inventory_prices.cost = pf.PRICE ,inventory_prices.qty = pf.QTY, inventory_prices.found = 1
//  WHERE inventory_prices.vendor = 2");