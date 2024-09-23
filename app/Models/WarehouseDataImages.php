<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseDataImages extends Model
{
    use HasFactory;
    
    
     protected $fillable = [
        'id',
         'image',
       
         'user_id',
         'warehouse_data_id',
    ];

    protected $table = 'warehouse_data_images';
    
    
    
    public function user(){
        return $this->BelongsTo(User::class,'user_id','id');
    }
    
    
    
    
    
    
    
}
