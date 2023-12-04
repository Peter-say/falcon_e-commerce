<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function showBalance()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
    }
    public function addFunds(Request $request)
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        // Perform validation on the request data

        // Update the wallet balance
        $wallet->balance += $request->input('amount');
        $wallet->save();

        // Redirect or display success message
    }


    public function deductFunds(Request $request)
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

        // Create a new transaction record to collect the deducted amount from wallet
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $deductedAmount;
        $transaction->type = 'deduction';
        $transaction->save();
        return back()->with('success_message', 'Your payment has been made successfully');
    }
}
