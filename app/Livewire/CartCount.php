<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartCount extends Component
{
    public $cartCount;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function updateCartCount()
    {
        $this->cartCount = $this->countCartItems();
    }

    public function mount()
    {
        $this->cartCount = $this->countCartItems();
    }

    public function countCartItems()
    {
        $count = 0;

        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart()->first();
            
            if ($cart) {
                $count = $cart->cartItems()->count();
            }

            $guestCartItems = session()->get('cartItems');
            if ($guestCartItems) {
                $count += count($guestCartItems);
            }
        } else {
            $sessionId = session()->getId();
            $cart = Cart::where('session_id', $sessionId)->first();

            if ($cart) {
                $count = $cart->cartItems()->count();
            }
        }

        return $count;
    }

    public function render()
    {
        return view('livewire.cart-count');
    }
}
