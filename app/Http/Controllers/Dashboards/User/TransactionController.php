<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function view($reference_no)
    {
        $transaction = Transaction::findOrFail($reference_no);
        return view('dashboard.user.transaction.invoice', compact('transaction'));
    }

    public function print($id)
    {
        $transaction = Transaction::findOrFail($id);
        $pdf = PDF::loadView('transaction.pdf', compact('transaction'));
        return $pdf->stream('transaction_receipt.pdf');
    }
}
