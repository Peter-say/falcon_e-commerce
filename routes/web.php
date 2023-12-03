<?php

use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [IndexController::class, 'index']);

Route::prefix('shop')->as('shop.')->group(function () {
  Route::prefix('product')->as('product.')->group(function () {
    Route::get('{product:slug}/details', [ProductController::class, 'details'])->name('details');
    // Route::post('/add-to-cart/{id}', [CartController::class, 'index'])->name('add-to-cart');
  });


  Route::get('/cart', [CartController::class, 'cartList'])->name('cart.cartList');
});


// Route::get('/', function () {
//     return view('welcome');
// });
