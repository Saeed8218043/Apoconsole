<?php






// Set variables for our request
$api_key = "c79ae2004cf9110ba4a751fb5e4226cd";
$shared_secret = "2daf864f9d937103a81f8f77a01a0507";
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
	$resultt =$result;
	curl_close($ch);
	// Store the access token
	$result = json_decode($result, true);
	
	
	
	$access_token = $result['access_token'];
	
	// Show the access token (don't do this in production!)
	$statement = ("INSERT INTO `auto_miniapp_shopify` ( `shop_url`, `access_token`) VALUES ('".$params['shop']."' , '".$access_token."' ) ");
	
	
	
	print_r([$resultt,$statement]);
	exit();
	
	
} else {
	die('This request is NOT from Shopify!');
}
?>