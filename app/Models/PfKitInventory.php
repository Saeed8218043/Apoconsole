<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PfKitInventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'sku',
        'price',
        'inventory',
        'warehouse_name',

    ];

    protected $table = "pf_kit_inventory";


    public function kitInventory()
    {
        return $this->hasMany(PfInventory::class, 'kit_id');
    }

}
