<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public static function generateTransactionReference()
    {
        $prefix = 'TRN'; // Prefix for the transaction reference
        $uniqueId = uniqid(); // Generate a unique ID
        $numericUniqueId = preg_replace('/[^0-9]/', '', $uniqueId);
        $paddedUniqueId = str_pad($numericUniqueId, 10, '0', STR_PAD_LEFT);
        $transactionReference = $prefix . '_' . $paddedUniqueId;
        return $transactionReference;
    }
}
