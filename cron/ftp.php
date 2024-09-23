<?php

$dir = '/home/apoconsole/app.apoconsole.com/cron/';
foreach(glob($dir.'*.csv') as $v){
    unlink($v);
}


// connect
$conn = ftp_connect('ftp.autooutletllc.com');
ftp_login($conn, 'console@autooutletllc.com', 'Cj4!PO(@OCU]');


ftp_chdir($conn, "autooutletllc.com");
ftp_chdir($conn, "trqinventory");
ftp_chdir($conn, "InventoryAndPrices");


// get list of files on given path
$files = ftp_nlist($conn, '');

$mostRecent = array(
    'time' => 0,
    'file' => null
);

foreach ($files as $file) {
    // get the last modified time for the file
    $time = ftp_mdtm($conn, $file);

    if ($time > $mostRecent['time']) {
        // this file is the most recent so far
        $mostRecent['time'] = $time;
        $mostRecent['file'] = $file;
    }
}


ftp_get($conn, $mostRecent['file'], $mostRecent['file'], FTP_ASCII);
ftp_close($conn);