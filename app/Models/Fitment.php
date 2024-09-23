<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fitment extends Model
{
    use HasFactory;
    protected $fillable = [
       'id',
'part_no',
'from_year',
'from_to',
'make_id',
'model_id',
'note'
    ];

    protected $table = "xml_test";
}
