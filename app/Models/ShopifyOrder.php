<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ShopifyOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'shop_url',
        'order_json',
        'po_number',
        'sales_price',
        'vendor_json',
        'user_id',
        'store',
        'created_at'
    ];

    const TABLE_NAME = 'shopify_orders_log';
    protected $table = self::TABLE_NAME;




    public function scopeValidJson($query)
    {
        return $query->whereRaw("JSON_VALID(vendor_json)")
        ->where(function ($query) {
            $query->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(vendor_json, '$.error')) IS NULL")
                ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(vendor_json, '$.errors')) IS NULL")
                ->orWhereRaw("JSON_LENGTH(JSON_EXTRACT(vendor_json, '$.items[*].trackingNumbers')) > 0");
        });
    }

    private function baseOrderQuery($query, $date, $store)
    {
        return $query->where('created_at', '>=', $date)
            ->validJson()
            ->where('store', 'LIKE', "%$store%");
    }

    public function getOrderCount($date, $store)
    {
        return $this->baseOrderQuery($this->newQuery(), $date, $store)->count();
    }

    public function getOrderCountBetweenDates($startDate, $endDate, $store)
    {
        return $this->baseOrderQuery($this->newQuery(), $startDate, $store)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }

    public function getSalesSum($date, $store)
    {
        return $this->baseOrderQuery($this->newQuery(), $date, $store)->sum('sales_price');
    }

    public function getCostSum($date, $store)
    {
        return $this->baseOrderQuery($this->newQuery(), $date, $store)
            ->sum(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(vendor_json, '$.orderTotal'))"));
    }


}
