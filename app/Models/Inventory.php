<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;


     protected $guarded = [];

    protected $table = 'pf_warehouse_inventory';



    public function user(){
        return $this->BelongsTo(User::class,'user_id','id');
    }


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
