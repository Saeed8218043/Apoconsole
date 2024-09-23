<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderrrc extends Model
{
    use HasFactory;
    
    
     protected $fillable = [
        'id',
        'order_id',
        'rma',
        'refund',
        'cancel'
    ];

    protected $table = 'orders_rrc';
}
