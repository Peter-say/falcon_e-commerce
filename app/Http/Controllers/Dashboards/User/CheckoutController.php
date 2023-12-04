<?php

namespace App\Http\Controllers\Dashboards\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
  public function checkout()
  {
    // session for redirecting users to checout page
    session(['checkout_page' => route('user.dashboard.checkout')]);

    $user = auth()->user();
    $shipping_address = Address::where('user_id', $user->id)->first();
    $cart = Cart::where('user_id', $user->id)->first();
    if ($cart) {
      $cartItems = $cart->cartItems;
      $totalPrice = $cart->calculateTotalPrice() ?? 0;
    } else {
      $cartItems = [];
      $totalPrice = 0;
    }

    $wallet = $user->wallet;

    return view('dashboard.user.cart.checkout', [
      'user' => $user,
      'shipping_address' => $shipping_address,
      'cartItems' => $cartItems,
      'totalPrice' => $totalPrice,
      'wallet' => $wallet,
    ]);
  }
}
