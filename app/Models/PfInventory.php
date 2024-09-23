<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PfInventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
       'part_no',
        'sku',
        'kit_id',
        'cost',
        'fee',
        'commission',
        'shipping',
        'original_price',
        'warehouse_name',
        'profit',
        'handling',
        'qty',
    ];

    protected $table = "pf_inventory";


    public function update_master_price(){

        if ($this->pricemasterrule == 1){


       $setting =  PriceSetting::where('vendor_id',$this->vendor)->first();

       if (isset($setting->id) ){




        $cost = $this->cost;

           if ($cost > 0){

            if ($setting->fee == 0) { $this->fee = 0; }
            if ($setting->commission == 0) { $this->commission = 0; }
            if ($setting->shipping == 0) { $this->shipping = 0; }
            if ($setting->profit == 0) { $this->profit = 0; }


            if ($setting->fee != null && $setting->fee != 0) { $this->fee = $cost*((float)$setting->fee/100); }
            if ($setting->commission != null && $setting->commission != 0) { $this->commission = $cost*((float)$setting->commission/100); }
            if ($setting->shipping != null && $setting->shipping != 0) { $this->shipping = $cost*((float)$setting->shipping/100); }
            if ($setting->profit != null && $setting->profit != 0) {

                $invenfee = $cost*((float)$setting->fee/100);
                $invencommission = $cost*((float)$setting->commission/100);
                $invenshipping = $cost*((float)$setting->shipping/100);

                $total = $cost + $invenfee + $invencommission + $invenshipping;


                $this->profit = $total*((float)$setting->profit/100);


            }
            $this->save();

           }
       }

    }

    }

    public function kit()
    {
        return $this->belongsTo(PfKitInventory::class, 'id');
    }

}
