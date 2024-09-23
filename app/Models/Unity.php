<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unity extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_number',
        'qoc',
        'cost'
    ];

    protected $table = "unity";
    
    
    
    
    
}
