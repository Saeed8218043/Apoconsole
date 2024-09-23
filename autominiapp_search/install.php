<?php
require_once("inc/functions.php");
require_once("inc/database.php");

$ngrok_url = NGROK_URL;
$shop = $_GET['shop'];
$api_key = SHOPIFY_API_KEY;
// $scopes = "read_orders,write_orders,read_products,write_products,write_script_tags, read_themes,write_themes,read_content,write_content,read_product_listings,read_customers,write_customers,write_locales,write_locales,read_locations,read_inventory,write_inventory";
$scopes = "read_orders,write_orders,read_products,write_products,write_script_tags,read_themes,write_themes,read_content,write_content,read_product_listings,read_customers,write_customers,write_locales,write_locales,read_locations,read_inventory,write_inventory,";
$redirect_uri =  Domain_URL_ . "/token.php";

$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

?>
<script>
    window.top.location.href = "<?php echo $install_url; ?>";
</script>
<?php
die();
?>