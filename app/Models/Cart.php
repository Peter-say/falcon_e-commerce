<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class Cart extends Model
{
    public $cartItemCount = 0;

    use HasFactory;

    protected $guarded = [];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'cart_id');
    }

  

    // this function handle the calculation of the total price of items added to cart //

    public function calculateTotalPrice()
    {
        $cartItems = $this->cartItems()->get();
        return $cartItems->sum(function ($cartItem) {
            return $cartItem->price * $cartItem->quantity;
        });
    }
}
