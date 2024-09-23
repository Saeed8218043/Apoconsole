<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hybridInventory extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'hybrid_inventory';

    public function kit()
    {
        return $this->belongsTo(hybridInventoryItem::class, 'id');
    }
}
