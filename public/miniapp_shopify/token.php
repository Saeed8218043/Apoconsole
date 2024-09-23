<?php

// Get our helper functions
require_once("./inc/functions.php");
require_once("./inc/database.php");

// Set variables for our request
$api_key = "70042480b77b7728f9bc27ea162704f3";
$shared_secret = "421de511e020d6f887d03f1a787e84d2";
$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically
$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

if (hash_equals($hmac, $computed_hmac)) {
	$query = array(
		"client_id" => $api_key, // Your API key
		"client_secret" => $shared_secret, // Your app credentials (secret key)
		"code" => $params['code'] // Grab the access key from the URL
	);
	// Generate access token URL
	$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";
	// Configure curl client and execute request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $access_token_url);
	curl_setopt($ch, CURLOPT_POST, count($query));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
	$result = curl_exec($ch);
	curl_close($ch);
	// Store the access token
	$result = json_decode($result, true);
	$access_token = $result['access_token'];
	// Show the access token (don't do this in production!)
	$statement = $pdo->prepare("INSERT INTO `auto_miniapp_shopify` ( `shop_url`, `access_token`) VALUES (:shop_url , :access_token ) ");
	$statement->bindValue(':shop_url', $params['shop']);
	$statement->bindValue(':access_token', $access_token);
	$check =  $statement->execute();
	if ($check) {
		header("Location: https://" . $params['shop'] . "/admin/apps/autominiapp");
		exit();
	} else {
		echo 'Fail to store Access Token...';
	}
} else {
	die('This request is NOT from Shopify!');
}
?>