<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    
    
     protected $fillable = [
        'id',
        'key',
        'value',
        'user_id'
     ];

    protected $table = 'settings';
    
    
   
    
    
    
    
    public static function get($key,$default){
        $f = Setting::where('key',$key)->first();
        
        if (isset($f->id) ){
            return $f->value;
        } else {
            return $default;
        }
    }
    
    
    public static function set($key,$value){
        Setting::updateOrCreate(
            ['key'=>$key],
            ['value' => $value,'user_id' => auth()->user()->id]
            );
            
            
          
        
    
    }
    
    
    
    
    
}
