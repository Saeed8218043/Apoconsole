<?php

$host = 'localhost';
$port = '';

$dbname2 = 'consoleautooutle_miniapp';

$root  = 'apoconsole_main';
$dbname  = 'apoconsole_main';
$pass   = 'iv$5iJ6lLoy]qOrU(}=gaStE';


$pdo = new PDO('mysql: host=' . $host . ';port=' . $port . ';dbname=' . $dbname . '', $root, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create database connection
$db = new mysqli($host, $root, $pass, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$conn = mysqli_connect($host, $root, $pass, $dbname);
if (!$conn) {
    die('Could not Connect My Sql:');
}

$pdo2 = new PDO('mysql: host=' . $host . ';port=' . $port . ';dbname=' . $dbname2 . '', $root, $pass);
$pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create database connection
$db2 = new mysqli($host, $root, $pass, $dbname2);

// Check connection
if ($db2->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$conn2 = mysqli_connect($host, $root, $pass, $dbname2);
if (!$conn2) {
    die('Could not Connect My Sql:');
}
