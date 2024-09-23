<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class apexInventoryItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'apex_inventory_items';

    public function kitInventory()
    {
        return $this->hasMany(apexInventory::class, 'item_no');
    }
}
