<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShoppingCart extends Component
{

    public $cartItems;
    public $totalPrice;
    public $item;

    public function __construct($item = null)
    {
        $this->item = $item;
    }
    
        public function mount()
        {
            $this->updateCartItems();
            $this->calculateTotalPrice();
        }
    
        public function incrementQuantity($item)
        {
            $cartItem = $this->cartItems[$item];
            $cartItem->quantity++;
            $cartItem->save();
            $this->calculateTotalPrice();
        }
    
        public function decrementQuantity($item)
        {
            $cartItem = $this->cartItems[$item];
            if ($cartItem->quantity > 1) {
                $cartItem->quantity--;
                $cartItem->save();
                $this->calculateTotalPrice();
            }
        }

        public function removeFromCart($item)
        {
            try {
                DB::beginTransaction();
    
                $cartItem = $this->cartItems[$item];
                $cartItem->delete();
                $this->updateCartItems();
                $this->calculateTotalPrice();
    
                DB::commit();
    
                return back()->with('success_message', 'Item removed from cart successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error_message', 'An error occurred while removing the item from the cart.');
            }
        }
    
        public function closePopup()
        {
            // This method will be called when the close button is clicked
        }
    
        public function calculateTotalPrice()
        {
            $this->totalPrice = collect($this->cartItems)->sum(function ($cartItem) {
                return $cartItem->price * $cartItem->quantity;
            });
        }

        public function updateCartItems()
        {
            if (Auth::check()) {
                // User is authenticated
                $user = Auth::user();
    
                // Retrieve guest cart items from the session
                $guestCartItems = session()->get('cartItems');
    
                // Ensure $guestCartItems is an array
                $guestCartItems = $guestCartItems ?: [];
    
                $cart = Cart::where('user_id', $user->id)->first();
    
                if ($cart) {
                    // Merge guest cart items with the user's cart items
                    if (!empty($guestCartItems)) {
                        $this->mergeGuestCartItems($cart, $guestCartItems);
                        session()->forget('cartItems');
                    }
    
    
                    // Retrieve updated cart items associated with the user's cart
                    $this->cartItems = $cart->cartItems;
                } else {
                    $this->cartItems = [];
                }
            } else {
                // User is not authenticated (guest)
                $sessionId = session()->getId();
                $cart = Cart::where('session_id', $sessionId)->first();
    
                // Retrieve cart items associated with the guest cart
                $this->cartItems = $cart ? $cart->cartItems : [];
            }
        }

    public function render()
    {
        return view('livewire.cart.shopping-cart');
    }
}
