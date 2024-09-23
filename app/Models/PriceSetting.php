<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceSetting extends Model
{
    use HasFactory;


    protected $table = "price_setting";

      protected $fillable = [
        'id',
        'vendor_name',
        'commission',
        'fee',
        'shipping',
        'profit',
        'quantity'

    ];
}
