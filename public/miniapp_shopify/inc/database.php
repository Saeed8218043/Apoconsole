<?php

$host = 'localhost';
$port = '';


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
