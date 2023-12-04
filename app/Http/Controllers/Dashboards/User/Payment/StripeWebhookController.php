<?php

namespace App\Http\Controllers\Dashboard\User\Payment;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{

    public function handleCallback(Request $request)
    {

        $user = Auth::user();
        // Set your Stripe secret key
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sig_header = $request->server('HTTP_STRIPE_SIGNATURE');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

            // Handle the event based on its type
            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;

                    // Extract transaction details
                    $transactionId = $paymentIntent->id;
                    $status = $paymentIntent->status;
    
                    // Update the transaction status in your database
                    $transaction = Transaction::where('user_id', $user->id)->first();
                    if ($transaction) {
                        $transaction->status = $status;
                        $transaction->save();
                    }
                    break;
                case 'payment_intent.payment_failed':
                    // Handle failed payment
                    break;
                    // Add more event types as needed
                default:
                    // Handle other event types
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
