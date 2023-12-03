<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CartItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cart()
    {
        return $this->belongsTo(Cart::class,'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public static function associateGuestCartItems()
    {
        if (Auth::check()) {
            // User is authenticated
            $user = Auth::user();
            $guestCartItems = session()->get('cartItems');

            if ($guestCartItems) {
                // Associate the guest cart items with the authenticated user
                foreach ($guestCartItems as $cartItemData) {
                    $cartItem = new CartItem();
                    $cartItem->cart_id = $user->cart->id;
                    $cartItem->product_id = $cartItemData['product_id'];
                    $cartItem->quantity = $cartItemData['quantity'];
                    // Set other cart item data
                    $cartItem->save();
                }

                // Clear the guest cart items from the session
                session()->forget('cartItems');
            }
        }
    }

   
}
