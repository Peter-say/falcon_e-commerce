<?php

namespace App\Http\Controllers\Dashboard\User\Payment;

use App\Http\Controllers\Controller;
use App\Mail\OrderShipped;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;

class StripeController extends Controller
{

    public $order;
    public $transaction;

    public function __construct(Order $order, Transaction $transaction)
    {
        $this->order = $order;
        $this->transaction = $transaction;
    }

    public function paymentSuccessCallback()
    {
        return redirect()->route('user.dashboard.checkout')->with('success_message', 'Payment successful');
    }

    public function paymentCancelCallback()
    {
        $errorMessage = 'Payment process cancelled';
        Log::error($errorMessage); // Log the error message

        return redirect()->route('user.dashboard.checkout')->with('error_message', $errorMessage);
    }


    public function initiatePayment(Request $request)
    {


        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)->first();
        $cartItems = null;
        $total = 0;

        if ($cart) {
            $cartItems = $cart->cartItems;
            $total = $cartItems->count(); // This calculates the count of cart items, not the total cost. Confirm if this is your intention.
        } else {
            return back()->with('error_message', 'No Items found in your cart. Kindly add items to continue');
        }

        if (!Address::where('user_id', $user->id)->exists()) {
            return redirect()->route('user.dashboard.checkout')->with(
                'error_message',
                'Please update your shipping address before placing an order.'
            );
        }

        // Fetch address with mark_as_default
        $address = Address::where('user_id', $user->id)->where('mark_as_default', '1')->first();

        // Create a new order
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $total, // This might need to be calculated based on individual cart item prices.
            'status' => 'Pending',
            'shipping_address_id' => $address->id,
            'tracking_number' => Order::generateTrackingNumber(),
        ]);

        $order->update(['tracking_link' => route('user.dashboard.order.products', $order->id)]);
        $order->save;

        foreach ($cartItems as $cartItemData) {
            // Create order items
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItemData['product_id'],
                'quantity' => $cartItemData['quantity'],
                'price' => $cartItemData['price'],
            ]);
        }
        // dd($cart, $cartItems, $order, $cartItemData);
        try {
            // Create a new transaction instance
            $payment_method = $request->input('payment_method');
            $amount = $request->input('amount'); // Corrected variable assignment

            $transaction = $this->transaction->create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'payment_method' => $payment_method,
                'amount' => $amount, // Corrected variable name
                'type' => 'Purchase',
                'reference_no' => $this->transaction->generateTransactionReference(),
            ]);
        } catch (Exception $e) {
            return 'Transaction Could not be completed' . $e->getMessage();
        }


        // Set your Stripe secret API key
        Stripe::setApiKey(config('services.stripe.secret'));

        try {

            try {
                // Create a Stripe payment session
                $lineItems = [];

                foreach ($cartItems as $cartItemData) {
                    $product = Product::find($cartItemData['product_id']);
                    $unitAmountInCents = intval(floatval($cartItemData['price']) * 100);
                    $lineItems[] = [
                        'price_data' => [
                            'currency' => 'usd',
                            'unit_amount' => $unitAmountInCents,
                            'product_data' => [
                                'name' => $product->name,
                            ],
                        ],
                        'quantity' => $cartItemData['quantity'],
                    ];
                }

                $paymentIntent = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'success_url' => 'http://localhost:9000/user/dashboard/thank-you',
                    'cancel_url' => 'http://localhost:9000/user/dashboard/checkout',
                ]);
            } catch (Exception) {
                return back()->with('error_message', 'Something unexpected went wrong');
            }

            // clear the carts from database if successful
            $cart->cartItems()->delete();
            $cart->delete();


            // Update the Order status if the order was successful
            $order->status = 'Completed';
            $order->save();

            // Update the Transaction status if the Transaction order was successful
            $transaction->status = 'Completed';
            $transaction->save();


            // send mail to user
            $buyerEmail = $user->email;
            Mail::to($buyerEmail)->send(new OrderShipped($order));

            // Redirect the user to the Stripe payment page
            return redirect()->to($paymentIntent->url);
        } catch (\Exception $e) {
            // Handle any errors that occur
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
