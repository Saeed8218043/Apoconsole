<?php
trait TrqTrait {



    public function trq_get_token()
    {

    $host   = 'localhost';
    $port   = '';
    $dbname = 'apoconsole_main';
    $root   = 'apoconsole_main';
    $pass   = 'iv$5iJ6lLoy]qOrU(}=gaStE';

    $db = new mysqli($host, $root, $pass, $dbname);

    $conn = mysqli_connect($host, $root, $pass, $dbname);
    if (!$conn) {
        die('Could not Connect My Sql:');
    }

    $sql = "SELECT * FROM settings  WHERE `key` = 'trq_email' LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();



    $trq_email = (isset($row['value'])) ? $row['value'] : '';

    $sql = "SELECT * FROM settings  WHERE `key` = 'trq_password' LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $trq_password = (isset($row['value'])) ? $row['value'] : '';

    //autooutlet@login.trqautoparts.comkO44^j1vY52Ojvpd


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://trqui.b2clogin.com/trqui.onmicrosoft.com/B2C_1_ROPC_Auth/oauth2/v2.0/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "grant_type=password&client_id=23c5476a-4276-4d30-baf0-4d21b06b4a05&scope=openid  offline_access https://trqui.onmicrosoft.com/1655a760-49d5-410d-8dca-4b9015d2b649/access.full&username=".$trq_email."&password=".$trq_password."&response_type=token id_token");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }



    public function trq_get_orders($token,$page,$size,$search)
    {
        $ch = curl_init();
        if ($search != NULL){
            $size .= '&search=/.*'.$search.'.*/&queryTypeFullSearch=1';
        }
        curl_setopt($ch, CURLOPT_URL, 'https://api1.trqautoparts.com/api/v3/orders?page='.$page.'&size='.$size);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'authorization: Bearer '.$token,
            'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function update_login(){

    // $host = 'localhost';
    // $port = '';
    // $dbname = 'autoqete_miniapp';
    // $root = 'autoqete';
    // $pass = 'qzT58g196&S81qt*';
    $host   = 'localhost';
    $port   = '';
    $dbname = 'apoconsole_main';
    $root   = 'apoconsole_main';
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


    $sql = "SELECT * FROM settings  WHERE `key` = 'trq_token'";
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();

    if (isset($row['value'])) {
        $token = $row['value'];
        $res = json_decode($this->trq_get_orders($token,1,10,null),true);
        if (!isset($res['_embedded'])){
        $res = json_decode($this->trq_get_token(),true);
          if (isset($res['id_token'])){
           $token = $res['id_token'];
            $conn->query("UPDATE `settings` SET `value`='$token' WHERE `key` = 'trq_token'");
          }
        }


    } else {
       $res = json_decode($this->trq_get_token(),true);

       if (isset($res['id_token'])){
           $token = $res['id_token'];
            $conn->query("INSERT INTO `settings`(`id`, `key`, `value`, `user_id`, `updated_at`, `created_at`) VALUES (NULL,'trq_token','$token',0,'2022-05-12 12:56:22','2022-05-12 12:56:22')");
       }

    }


    return $token;






    }


    public function post_order($token,$data){


        $data = json_decode($data,true);



$items = array ();

 $db = new mysqli('localhost', 'apoconsole_main', 'iv$5iJ6lLoy]qOrU(}=gaStE', 'apoconsole_main');

foreach ($data['line_items'] as $item) {
    $sku = $item['sku'];
    $trqdata = $db->query("SELECT * FROM `trq` WHERE `PartNumber` = '$sku'");
     if (mysqli_num_rows($trqdata) > 0) {
        $brandId = $trqdata->fetch_assoc()['brand_abbr'];
         } else { $brandId = '';  }
	array_push($items, array('sku' => $item['sku'],'brandId' => $brandId,'quantity' => $item['quantity']));
}



$data = array (
  'poNumber'           => (isset($data['name'])) ? str_replace('#','',$data['name']) : 0 ,
  'shippingName'       => (isset($data['shipping_address']['first_name'])) ? $data['shipping_address']['first_name']." ".$data['shipping_address']['last_name'] : '' ,
  'shippingAddress1'   => (isset($data['shipping_address']['address1'])) ? $data['shipping_address']['address1'] : '' ,
  'shippingAddress2'   => (isset($data['shipping_address']['address2'])) ? $data['shipping_address']['address2'] : '' ,
  'shippingPostalCode' => (isset($data['shipping_address']['zip'])) ? explode('-', $data['shipping_address']['zip'])[0] : '' ,
  'shippingCity'       => (isset($data['shipping_address']['city'])) ? $data['shipping_address']['city'] : '' ,
  'shippingCountry'    => (isset($data['shipping_address']['country_code'])) ? $data['shipping_address']['country_code'] : '' ,
  'shippingRegion'     => (isset($data['shipping_address']['province_code'])) ? $data['shipping_address']['province_code'] : '' ,
  'shippingMethod'     =>  'REG' ,
  'clientSegment'      => "",
  'items' => $items
);




$data = json_encode($data);



     $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api1.trqautoparts.com/api/v3/orders');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'authorization: Bearer '.$token,
            'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }


    public function trq_get_order($token,$id){
      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api1.trqautoparts.com/api/v3/orders/po/'.$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'authorization: Bearer '.$token,
            'ocp-apim-subscription-key: 2799e2449a7549c69eaab21fffec451f'
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }






}




class trqVendor {

    use TrqTrait;


    public $token;


     function __construct(){
      $this->token =  $this->update_login();
    }

    public function place_order($data){
        return $this->post_order($this->token,$data);
    }

    public function get_order($id){
      return $this->trq_get_order($this->token,$id);
    }

    public function get_orders($page,$size,$search){
      return $this->trq_get_orders($this->token,$page,$size,$search);
    }



}

class pfVendor {

    use TrqTrait;


    public $token;


     function __construct(){
      $this->token =  $this->update_login();
    }

    // public function place_order($data){
    //     return $this->post_order($this->token,$data);
    // }

    // public function get_order($id){
    //   return $this->trq_get_order($this->token,$id);
    // }

    // public function get_orders($page,$size,$search){
    //   return $this->trq_get_orders($this->token,$page,$size,$search);
    // }



}





