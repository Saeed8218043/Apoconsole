<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hybridInventoryItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'hybrid_inventory_items';

    public function kitInventory()
    {
        return $this->hasMany(hybridInventory::class, 'item_no');
    }
}
