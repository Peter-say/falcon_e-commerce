<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentService
{
    // This payment section only works for wallet transaction within this application
    public function deductFunds(Request $request, $deductedAmount)
    {

        $user = Auth::user();
        $wallet = $user->wallet;

        if ($wallet->balance < $request->input('amount')) {
            return back()->with('error_message', 'Insufficient balance');
        }

        $deductedAmount = $request->input('amount');
        // Deduct funds from the user's wallet
        $wallet->balance -= $deductedAmount;
        $wallet->save();
         
        return $deductedAmount;

        return back()->with('success_message', 'Your payment has been made successfully');
    }
}
