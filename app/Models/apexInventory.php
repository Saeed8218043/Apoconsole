<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class apexInventory extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'apex_inventory';

    public function kit()
    {
        return $this->belongsTo(apexInventoryItem::class, 'id');
    }
}
