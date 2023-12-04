<?php

namespace App\Http\Controllers\Dashboard\User\Payment;

use App\Http\Controllers\Controller;
use App\Mail\OrderShipped;
use App\Models\Address;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Flutterwave\Payments\Facades\Flutterwave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FlutterwaveController extends Controller
{

    public $order;
    public $transaction;

    public function __construct(Order $order, Transaction $transaction)
    {
       
        $this->order = $order;
        $this->transaction = $transaction;
    }

    public function initiatePayment()
    {
        $user = Auth::user();
        if (!Address::where('user_id', $user->id)->exists()) {
            return redirect()->route('user.dashboard.checkout')->with(
                'error_success',
                'Please update your shipping address before placing an order.'
            );
        }

        $flutterwave = new Flutterwave(env('FLUTTERWAVE_PUBLIC_KEY'), env('FLUTTERWAVE_SECRET_KEY'));

        $paymentData = [
            'tx_ref' => $this->transaction::generateTransactionReference(),
            'amount' => $this->transaction->amount,
            'currency' => 'NGN',
            'payment_type' => 'card',
            'redirect_url' => route('payment.callback'),
        ];

        $paymentLink = $flutterwave->initializePayment($paymentData);

        return redirect($paymentLink);
    }

    public function paymentCallback(Request $request)
    {
        $user = Auth::user();

        $flutterwave = new Flutterwave(env('FLUTTERWAVE_PUBLIC_KEY'), env('FLUTTERWAVE_SECRET_KEY'));
        $transactionId = $request->query('tx_ref');

        $transaction = $flutterwave->verifyTransaction($transactionId);

        if ($transaction->status === 'successful') {
            // send mail to user
            $buyerEmail = $user->email;
            Mail::to($buyerEmail)->send(new OrderShipped($this->order));
            return 'Payment successful';
        } else {
            // Payment was not successful
            // Handle error or redirect to a failure page
            return 'Payment failed';
        }
    }
}
