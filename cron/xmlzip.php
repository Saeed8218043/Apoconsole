
<?php
//set the correct xml headers to output to browser
// header("Content-type: text/xml");
ini_set ( 'max_execution_time', -1);

$servername = "localhost";
$username = "autoqete_ali";
$password = "ali@ranksol";
$database = "autoqete_miniapp";

// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_errno) {
  die("Connection failed: " . $conn->connect_error);
}



function xml_open($name){
    $zipFile = $name;
    $zip = new ZipArchive;
    if ($zip->open($zipFile))
    {
    //get the xml filename inside the zip
    $xmlFile =  $zip->getNameIndex(0); //you only  have 1 xml file iside of the zip
    $zip->close();
    //read the xml file inside the zip without extracting it to disk (memory)
    $xml = file_get_contents("zip://$zipFile#$xmlFile");
    
    
    // print_r( new SimpleXMLElement($xml)); 
    $doc = new DOMDocument;
    $doc->loadXML($xml);
    return new DOMXPath($doc);
    } else {
    echo "Failed to Open file";
    return false;
    }
}



    
    $xml= xml_open("/home/autoqete/autooutletllc.com/trqinventory/AcesAndPies/20220315/ACES_Trail_Ridge_Full_20220314.xml.zip");
   
    $t=0;
    
    unlink('fitment.csv');
    $f = fopen('fitment.csv', 'w');
    fputcsv($f, ['id','part_no','from_year','from_to','make_id','model_id','note']);
 
    //  $conn->query("TRUNCATE TABLE `xml_test`");
    
    foreach($xml->query('//App') as $x){
        
        $comment = $xml->query('.//comment()', $x);
        $notes = $xml->query('.//Note', $x);
        $Part =  $xml->query('.//Part', $x)[0]->nodeValue;
        
        $note = " ";
        
        $comment = explode(" ",$comment[0]->nodeValue);
        $year = $comment[0];
        $make = $comment[1];
        unset($comment[0]);
        unset($comment[1]);
        
        $model = implode(" ",$comment);
        
        foreach($notes as $node){
            $note .= " ".$node->nodeValue;
        }
        
        
        // print_r($Part."\n");
        
        
        //fputcsv($f, [$Part,$year,$year,$make,$model,$note]);
        
        
        
$part       = $Part;         
$from       = $year;          
$to         = $year;  
$make       = $make;         
$model      = $model;           
$Note       = $note;    

fputcsv($f, [$part,$from,$to,$make,$model,$Note]);

// print_r([
// $part,
// $from,
// $to,
// $make,
// $model,
// $Note]);

//  $conn->query("INSERT INTO `xml_test` (`id`, `part_no`, `from_year`, `from_to`, `make_id`, `model_id`, `note`) VALUES (NULL, '$part', '$from', '$to', '$make', '$model', '$Note');");
        
        
        
        
        // print_r($a[0]->data."\n");
        
        
        // $from = $x->childNodes->item(1)->getAttribute('from');
        // $to   = $x->childNodes->item(1)->getAttribute('to');
        
     
      
        // if($t>100){
        //  fclose($f);
        //  echo "done";
        // break;
        // }
        $t++;
    }
    
    
    
    
    
    
    
    
    // ###################################################################################################################################
    // ###################################################################################################################################
    // ###################################################################################################################################
    // ###################################################################################################################################
    echo $t."<br>";
    
    $xml= xml_open("/home/autoqete/autooutletllc.com/trqinventory/AcesAndPies/20220315/ACES_TRQ_Performance_Full_20220314.xml.zip");
    
    $t=0;
    foreach($xml->query('//App') as $x){
        
        $comment = $xml->query('.//comment()', $x);
        $notes = $xml->query('.//Note', $x);
        $Part =  $xml->query('.//Part', $x)[0]->nodeValue;
        
        $note = " ";
        
        $comment = explode(" ",$comment[0]->nodeValue);
        $year = $comment[0];
        $make = $comment[1];
        unset($comment[0]);
        unset($comment[1]);
        
        $model = implode(" ",$comment);
        
        foreach($notes as $node){
            $note .= " ".$node->nodeValue;
        }
        
        
        // print_r($Part."\n");
        
        
        //fputcsv($f, [$Part,$year,$year,$make,$model,$note]);
        
        
        
$part       = $Part;         
$from       = $year;          
$to         = $year;  
$make       = $make;         
$model      = $model;           
$Note       = $note;    

fputcsv($f, [$part,$from,$to,$make,$model,$Note]);

// print_r([
// $part,
// $from,
// $to,
// $make,
// $model,
// $Note]);

     
      
        // if($t>100){
        //  fclose($f);
        //  echo "done";
        // break;
        // }
        $t++;
    }
    
    
    
     // ###################################################################################################################################
    // ###################################################################################################################################
    // ###################################################################################################################################
    // ###################################################################################################################################
    echo $t."<br>";
    
    
   
    
    
$zip = new ZipArchive;
$zip->open("/home/autoqete/autooutletllc.com/trqinventory/AcesAndPies/20220315/ACES_DIY_Solutions_Full_20220314.xml.zip");
$xmlFile =  $zip->getNameIndex(0);
$zip->extractTo('/home/autoqete/tmp/');
$zip->close();

 $xml = file_get_contents('/home/autoqete/tmp/'.$xmlFile);
 
 


$xml = explode("<App ",$xml);
    
    
   
    
    
    
    $t=0;
    foreach($xml as $x){
        
       
        
        
       if($t>=1){ 
           
           
            
            $x = "<App ".$x;
            
    $doc = new DOMDocument;
    $doc->loadXML($x);
    $xml = new DOMXPath($doc);
    $x = $xml->query('//App')[0];
   
            
       
           
        $comment = $xml->query('.//comment()', $x);
        $notes = $xml->query('.//Note', $x);
        $Part =  $xml->query('.//Part', $x)[0]->nodeValue;
        
        $note = " ";
        
        $comment = explode(" ",$comment[0]->nodeValue);
        $year = $comment[0];
        $make = $comment[1];
        unset($comment[0]);
        unset($comment[1]);
        
        $model = implode(" ",$comment);
        
        foreach($notes as $node){
            $note .= " ".$node->nodeValue;
        }
        
        
        // print_r($Part."\n");
        
        
        //fputcsv($f, [$Part,$year,$year,$make,$model,$note]);
        
        
        
$part       = $Part;         
$from       = $year;          
$to         = $year;  
$make       = $make;         
$model      = $model;           
$Note       = $note;    

fputcsv($f, [$part,$from,$to,$make,$model,$Note]);

// print_r([
// $part,
// $from,
// $to,
// $make,
// $model,
// $Note]);
}
     
      
        // if($t>100){
        //  fclose($f);
        //  echo "done";
        // break;
        // }
        $t++;
    }
    
    echo $t."<br>";
    
    
   
   
    // #######################################################################################################################
   
   fclose($f); 
   
   
   
        unlink('fitment2.csv');
    $f = fopen('fitment2.csv', 'w');

    
    $zip = new ZipArchive;
$zip->open("/home/autoqete/autooutletllc.com/trqinventory/AcesAndPies/20220315/ACES_TRQ_Full_20220314.xml.zip");
$xmlFile =  $zip->getNameIndex(0);
$zip->extractTo('/home/autoqete/tmp/');
$zip->close();

 $xml = file_get_contents('/home/autoqete/tmp/'.$xmlFile);
 
 


$xml = explode("<App ",$xml);
    
    

    
    
    
    $t=0;
    foreach($xml as $x){
        
       
        
        
       if($t>=1){ 
         
           
            
            $x = "<App ".$x;
            
    $doc = new DOMDocument;
    $doc->loadXML($x);
    $xml = new DOMXPath($doc);
    $x = $xml->query('//App')[0];
   
           
           
        $comment = $xml->query('.//comment()', $x);
        $notes = $xml->query('.//Note', $x);
        $Part =  $xml->query('.//Part', $x)[0]->nodeValue;
        
        $note = " ";
        
        $comment = explode(" ",$comment[0]->nodeValue);
        $year = $comment[0];
        $make = $comment[1];
        unset($comment[0]);
        unset($comment[1]);
        
        $model = implode(" ",$comment);
        
        foreach($notes as $node){
            $note .= " ".$node->nodeValue;
        }
        
        
        // print_r($Part."\n");
        
        
        //fputcsv($f, [$Part,$year,$year,$make,$model,$note]);
        
        
        
$part       = $Part;         
$from       = $year;          
$to         = $year;  
$make       = $make;         
$model      = $model;           
$Note       = $note;    

fputcsv($f, [$part,$from,$to,$make,$model,$Note]);

// print_r([
// $part,
// $from,
// $to,
// $make,
// $model,
// $Note]);
}
     
      
        // if($t>100){
         
        //  echo "done";
        // break;
        // }
        $t++;
    }
    
    echo $t."<br>";
    fclose($f);
    
    echo "done";
   

?>
