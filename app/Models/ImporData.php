<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImporData extends Model
{
    use HasFactory;
    protected $table = 'importdata';
    public $timestamps = false;
}
