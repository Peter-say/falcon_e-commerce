<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class);
    }

    public static function generateTrackingNumber()
    {
        $prefix = 'TRC_CODE'; 
        return $prefix.'_'.Str::random(10);
    }
}
