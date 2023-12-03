<?php

namespace App\Services;

use App\Mail\OrderShipped;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    public static function processOrder(Request $request, PaymentService $paymentService)
    {

        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)->first();
        $cartItems = null;
        $total = 0;

        if ($cart) {
            $cartItems = $cart->cartItems;
            $total = $cartItems->count();
        } else {
            return back()->with('error_message', 'No Items found in your cart. Kindly add items to continue');
        }


        // Retrieve the existing address
        $address = Address::where('user_id', $user->id)->where('mark_as_default', '1')->first();
        
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $total,
            'status' => 'Pending',
            'shipping_address_id' => $address->id,
            'tracking_number' => Order::generateTrackingNumber(),
           
        ]);

        $order->update([ 'tracking_link' => route('user.dashboard.order.products', $order->id)]);
        $order->save;

        foreach ($cartItems as $cartItemData) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItemData['product_id'],
                'quantity' => $cartItemData['quantity'],
                'price' => $cartItemData['price'],
            ]);
        }

        // clear the carts from database
        $cart->cartItems()->delete();
        $cart->delete();

        try {
            // get the payment from the input
            $payment_method = $request->input('payment_method');
            // Process the payment here
            $deductedAmount = $request->input('amount');
            $deductedAmount = $paymentService->deductFunds($request, $deductedAmount);
            // Create a new wallet transaction record to store the deducted amount and other details
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $deductedAmount;
            $transaction->type = 'deduction';
            $transaction->status = 'completed';
            $transaction->order_id = $order->id;
            $transaction->payment_method = $payment_method;
            $transaction->reference_no = Transaction::generateTransactionReference();
            $transaction->description = 'Paid Purchase';
            $transaction->save();
        } catch (Exception $e) {
            return back()->with('error_message', 'Payment Processing error', $e->getMessage());
        }


        try {
            // create new transaction instance //
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'payment_method' => $payment_method,
                'amount' => $request->input('amount'),
                'type' => 'Purchase',
                'reference_no' => Transaction::generateTransactionReference(),
            ]);
        } catch (Exception $e) {
            return back()->with('error_message', 'Transaction Could not be completed', $e->getMessage());
        }

        // Update the transaction status if the payment was successful
        $transaction->status = 'Completed';
        $transaction->save();


        // Update the Order status if the order was successful
        $order->status = 'Completed';
        $order->save();

        // send mail to user
        $buyerEmail = $user->email;
        Mail::to($buyerEmail)->send(new OrderShipped($order));

        return $order;
    }
}
