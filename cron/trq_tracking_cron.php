<?php
$dir = '/home/apoconsole/app.apoconsole.com/cron/Tracking/';
foreach(glob($dir.'*.csv') as $v){
    unlink($v);
}


$files = scandir("/home/apoconsole/apoconsole.com/trqinventoryfeed/Tracking");

$mostRecent = array(
    'time' => 0,
    'file' => null
);


foreach ($files as $file) {
    // get the last modified time for the file
    if (!is_dir("/home/apoconsole/apoconsole.com/trqinventoryfeed/Tracking/".$file)){
        $time = filemtime("/home/apoconsole/apoconsole.com/trqinventoryfeed/Tracking/".$file);
    
    
        if ($time > $mostRecent['time']) {
            // this file is the most recent so far
            $mostRecent['time'] = $time;
            $mostRecent['file'] = $file;
        }
    }
}


if ($mostRecent['file']){
        $sourceFileTracking = "/home/apoconsole/apoconsole.com/trqinventoryfeed/Tracking/" . $mostRecent['file'];
    $destinationFileTracking = "Tracking/" . $mostRecent['file'];

    // Copy the file
    copy($sourceFileTracking, $destinationFileTracking);

    // Get the original file's modification time
    $originalFileTimeTracking = filemtime($sourceFileTracking);

    // Set the modified time of the new file to match the original file
    touch($destinationFileTracking, $originalFileTimeTracking);

    // Assign the filename to $trq_file (assuming you want to keep track of it)
    $trq_file = $mostRecent['file'];
}



?>