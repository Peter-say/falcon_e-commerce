<?php


use App\Http\Controllers\Dashboards\User\CheckoutController;
use App\Http\Controllers\Dashboards\User\IndexController;
use App\Http\Controllers\Dashboards\User\OrderController;
use App\Http\Controllers\Dashboards\User\Payment\StripeController;
use App\Http\Controllers\Dashboards\User\Payment\StripeWebhookController;
use App\Http\Controllers\Dashboards\User\TransactionController;
use App\Http\Controllers\Dashboards\User\WishlistController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\IndexController as WebIndexController;
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

Route::get('/', [WebIndexController::class, 'index']);

Route::prefix('shop')->as('shop.')->group(function () {
  Route::prefix('product')->as('product.')->group(function () {
    Route::get('{product:slug}/details', [ProductController::class, 'details'])->name('details');
    // Route::post('/add-to-cart/{id}', [CartController::class, 'index'])->name('add-to-cart');
  });


  Route::get('/cart', [CartController::class, 'shoppingCart'])->name('cart');
});


Route::prefix('user')->as('user.')->group(function () {
  Route::prefix('dashboard')->as('dashboard.')->middleware(['auth'])->group(function () {
      Route::get('home', [IndexController::class, 'home'])->name('home');
      Route::get('thank-you', [IndexController::class, 'thankYou'])->name('thank-you');
      Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
      Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place-order');
      Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
      Route::get('/order/{id}/products', [UserOrderController::class, 'orderProducts'])->name('order.products');
      Route::get('/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');

      Route::get('transaction/{transaction_no}/view', [TransactionController::class, 'view'])->name('view.transaction');
      Route::get('transaction/{id}/print', [TransactionController::class, 'print'])->name('print.transaction');

      Route::post('/stripe/checkout', [StripeController::class, 'initiatePayment'])->name('stripe.checkout');
      Route::get('/stripe/transaction/webhook', [StripeWebhookController::class, 'handleTransactionWebhook'])->name('stripe.transaction.webhook');
      // Route::get('/store-stripe-payment-info', [PaymentController::class, 'storePaymentInfo'])->name('store.stripe-payment.info');

      
  });
});

Route::prefix('account')->as('account.')->group(function () {
  Route::get('profile/index', [ProfileController::class, 'index'])->name('profile.index');
  Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');

  Route::post('address', [AddressController::class, 'saveAddress'])->name('address.save');
  Route::put('address', [AddressController::class, 'saveAddress'])->name('address.update');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
