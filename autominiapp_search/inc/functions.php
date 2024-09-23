<?php
define('NGROK_URL', "https://console.autooutletllc.com"); // Replace with your DOMAIN URL
define('SHOPIFY_API_KEY', "e5d2f906015f02ed6a3364899d4bd83c"); // Replace with your API KEY
define('SHOPIFY_SECRUT_KEY', "2526e17634e0c8242cab2e6c08e9d263"); // Replace with your SECRET KEY
define('Domain_URL_', "https://console.autooutletllc.com/autominiapp_search"); 
define('SHOPIFY__VERSION', "2022-04"); 

$fun____temp__test = "Runing fine";
/*
https://console.autooutletllc.com/miniapp_shopify/webhooks/app/uninstalled.php
	https://console.autooutletllc.com/miniapp_shopify/install.php
	https://console.autooutletllc.com/miniapp_shopify/token.php
	https://console.autooutletllc.com/miniapp_shopify/inc/database.php
	https://console.autooutletllc.com/miniapp_shopify/inc/functions.php
*/

function shopify_call($token, $shop, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array())
{

	// Build URL
	//	$url = "https://" . $shop . ".myshopify.com" . $api_endpoint;
	$url = "https://" . $shop . ".myshopify.com" . $api_endpoint;
	if (!is_null($query) && in_array($method, array('GET', 	'DELETE'))) $url = $url . "?" . http_build_query($query);

	// Configure cURL
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, TRUE);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 3);
	// curl_setopt($curl, CURLOPT_SSLVERSION, 3);
	curl_setopt($curl, CURLOPT_USERAGENT, 'My New Shopify App v.1');
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

	// Setup headers
	$request_headers[] = "";
	if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
	curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

	if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
		if (is_array($query)) $query = http_build_query($query);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
	}

	// Send request to Shopify and capture any errors
	$response = curl_exec($curl);
	$error_number = curl_errno($curl);
	$error_message = curl_error($curl);

	// Close cURL to be nice
	curl_close($curl);

	// Return an error is cURL has a problem
	if ($error_number) {
		return $error_message;
	} else {

		// No error, return Shopify's response by parsing out the body and the headers
		$response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

		// Convert headers into an array
		$headers = array();
		$header_data = explode("\n", $response[0]);
		$headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
		array_shift($header_data); // Remove status, we've already set it above
		foreach ($header_data as $part) {
			$h = explode(":", $part);
			$headers[trim($h[0])] = trim($h[1]);
		}

		// Return headers and Shopify's response
		return array('headers' => $headers, 'response' => $response[1]);
	}
}

function shopify_graphQL_call($token, $shop, $version, $query)
{

	// Build URL
	//	$url = "https://" . $shop . ".myshopify.com" . $api_endpoint;
	$url = "https://" . $shop . ".myshopify.com" . "/admin/api/" . $version . "/graphql.json";

	// Configure cURL
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, TRUE);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	// curl_setopt($curl, CURLOPT_RETURNTRANSFER, FALSE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

	// Setup headers
	$request_headers[] = "";
	$request_headers[] = "Content-Type:	application/json";

	if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
	curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($query));
	curl_setopt($curl, CURLOPT_POST, true);

	// Send request to Shopify and capture any errors
	$response = curl_exec($curl);
	$error_number = curl_errno($curl);
	$error_message = curl_error($curl);

	// Close cURL to be nice
	curl_close($curl);

	// Return an error is cURL has a problem
	if ($error_number) {
		return $error_message;
	} else {

		// No error, return Shopify's response by parsing out the body and the headers
		$response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

		// Convert headers into an array
		$headers = array();
		$header_data = explode("\n", $response[0]);
		$headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
		array_shift($header_data); // Remove status, we've already set it above
		foreach ($header_data as $part) {
			$h = explode(":", $part);
			$headers[trim($h[0])] = trim($h[1]);
		}

		// Return headers and Shopify's response
		return array('headers' => $headers, 'response' => $response[1]);
	}
}

function proper_parse_str($str)
{
	# result array
	$arr = array();

	# split on outer delimiter
	$pairs = explode('&', $str);

	# loop through each pair
	foreach ($pairs as $i) {
		# split into name and value
		list($name, $value) = explode('=', $i, 2);

		# if name already exists
		if (isset($arr[$name])) {
			# stick multiple values into an array
			if (is_array($arr[$name])) {
				$arr[$name][] = $value;
			} else {
				$arr[$name] = array($arr[$name], $value);
			}
		}
		# otherwise, simply stick it in a scalar
		else {
			$arr[$name] = $value;
		}
	}

	# return result array
	return $arr;
}

function Get_host_shop($shop)
{
	$url = parse_url('https://' . $shop);
	$host = explode('.', $url['host']);
	//  echo $host[0];
	$host_shop = $host[0];
	return $host_shop;
}
function graphQL__id__spliting($string)
{
	$temp = $string;
	$f_split =  (explode("://", $temp))[1];
	$s_slpit = (explode("/", $f_split));
	$result = $s_slpit[(count($s_slpit) - 1)];
	return  $result;
}
function Query_get__product_with_sku($sku)
{
	$Query__graphQl = array(
		"query" => '{
			products(first: 1, query: "sku:' . $sku . '") {
			  edges {
				node {
				  id
				  title
				  variants(first: 1) {
					edges {
					  node {
						id
						title
						sku
						price
						inventoryQuantity
						inventoryItem {
							id
						}
						fulfillmentService {
							location {
							  id
							  name
							}
						}
					  }
					}
				  }
				}
			  }
			}
		  }'
	);
	return $Query__graphQl;
}

function Query_get__products____()
{
	$Query__graphQl = array(
		"query" => '{
			products(first: 10) {
				edges {
				  cursor
				  node {
					id
					title
					variants(first: 1) {
					  edges {
						node {
						  id
						  title
						  sku
						  price
						  inventoryQuantity
						  inventoryItem {
							id
						  }
						  fulfillmentService {
							location {
							  id
							  name
							}
						  }
						}
					  }
					}
				  }
				}
				pageInfo {
				  hasNextPage
				  hasPreviousPage
				}
			}	
		}'
	);
	return $Query__graphQl;
}

function Query_get__NEXT__products____($cursor)
{
	$Query__graphQl = array(
		"query" => '{
			products(first: 10, after: "'. $cursor .'") {
				edges {
				  cursor
				  node {
					id
					title
					variants(first: 1) {
					  edges {
						node {
						  id
						  title
						  sku
						  price
						  inventoryQuantity
						  inventoryItem {
							id
						  }
						  fulfillmentService {
							location {
							  id
							  name
							}
						  }
						}
					  }
					}
				  }
				}
				pageInfo {
				  hasNextPage
				  hasPreviousPage
				}
			}	
		}'
	);
	return $Query__graphQl;
}

function Query_throttleStatus_reSet()
{
	$Query__graphQl = array(
		"query" => '{
			products(first: -1000) {
			  edges {
				cursor
				node {
				  id
				}
			  }
			}
		}'
	);
	return $Query__graphQl;
}
function Adject_Quantity__Function($access_token, $host_shop, $varsion, $location_ID, $inventory_item_iD, $available_Adjustment)
{
	$modify_data = array(
		"location_id" => $location_ID,
		"inventory_item_id" => $inventory_item_iD,
		"available_adjustment" => $available_Adjustment
	);

	$modified_product_inventory_quantity = shopify_call($access_token, $host_shop, "/admin/api/" . $varsion . "/inventory_levels/adjust.json", $modify_data, 'POST');
	$modified_product_inventory_quantity_response = $modified_product_inventory_quantity['response'];
}

function Adject_Price__Function($access_token, $host_shop, $varsion, $variant_ID, $adjustment_Price)
{

	$modify_data = array(
		"variant" => array(
			"id" => $variant_ID,
			"price" => $adjustment_Price
		)
	);

	$modified_product = shopify_call($access_token, $host_shop, "/admin/api/" . $varsion . "/variants/" . $variant_ID . ".json", $modify_data, 'PUT');
	$modified_product_response = $modified_product['response'];
	// print_r($modified_product_response);
	// if($modified_product_response){
	//     return true;
	// }
}


// $products = shopify_call($access_token, $host_shop, "/admin/api/2022-04/products.json", 
//     array( 
//         'limit' => 3,
//     ), 'GET');
// $products_pre = ($products['response']);
// $products = json_decode($products['response'], JSON_PRETTY_PRINT);
// $product_json =  $products_pre;
// print_r($products);