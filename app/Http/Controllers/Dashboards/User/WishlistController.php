<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function wishlist()
    {
        $user = Auth::user();
        $wishlist = Wishlist::with('product')->where('user_id', $user->id)->get();
        return view('web.shop.wishlist', compact('wishlist'));
    }
}
