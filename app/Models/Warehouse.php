<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;


     protected $fillable = [
        'id',
         'inMarket_Place',
         'inOrder_ID',
         'Tracking_ID',
         'Customer_Name',
         'Part',
         'ASINItem_ID',
         'Part_Condition',
         'Picture',
         'inlabel',
         'outlabel',
         'status',
         'Ship_button',
         'Shipping_Label',
         'outMarket_Place',
         'outOrder_ID',
         'Shipped_Button',
         'user_id',
         'warehouse_id',
         'admin',
         'userr',

    ];

    protected $table = 'warehouse_data';



    public function user(){
        return $this->BelongsTo(User::class,'user_id','id');
    }




    public function is_shipped(){

         if ($this->outOrder_ID == ''){
     return false      ;
      }   else {
          return true ;
      }



      if (
$this->outMarket_Place == '' &&
$this->outOrder_ID == '' &&
$this->Shipping_Label == ''
){
     return false      ;
      }   else {
          return true ;
      }
    }


    public function status(){
         if ($this->admin == NULL){
     return ['Stock In',1];
      }  elseif ($this->userr == NULL) {
          return ['Ready to Ship',2];
      }
      return ['Shipped',3];

    }



    public function images(){
        return $this->HasMany(WarehouseDataImages::class,'warehouse_data_id','id');
    }


     public function warehouse(){
        return $this->BelongsTo(Warehouses::class,'warehouse_id','id');
    }





}
