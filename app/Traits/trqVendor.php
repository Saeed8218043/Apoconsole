<?php
namespace App\Traits;
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
