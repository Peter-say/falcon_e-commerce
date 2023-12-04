<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Livewire\CartCount;


class CartController extends Controller
{

    public function shoppingCart()
    {
       $cartCount = (new CartCount)->countCartItems();
        return view('web.shop.cart.list', compact('cartCount'));
    }
}
