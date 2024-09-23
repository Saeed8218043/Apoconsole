<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PfWarehouseOrder extends Model
{
    use HasFactory;


     protected $guarded = [];

    protected $table = 'pf_warehouse_orders';




    public function status(){
        if ($this->qty == 0){
    return 'Stock Out';
     }  elseif ($this->qty > 0) {
         return 'Stock in';
     }elseif($this->inlable != null){
         return 'Ready to Ship';
     }

   }

}
