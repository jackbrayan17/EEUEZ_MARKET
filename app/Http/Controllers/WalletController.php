<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    // Show the wallet form with deposit/withdraw options
    public function showTransactionForm()
    {
        $wallet = Auth::user()->wallet;

        return view('wallet.transaction', compact('wallet'));
    }

    // Handle deposit action
    public function deposit(Request $request)
    {
        $request->validate([
            'transaction_type' => 'required|in:MTN,Orange',
            'phone_number' => 'required|numeric|digits:9',
            'amount' => 'required|numeric|min:100', // Minimum deposit of 100 FCFA
        ]);

        $user = Auth::user();
        $wallet = $user->wallet;

        // Simulate the deposit process
        // In real implementation, this is where you'd call the payment gateway API like MoMo API or Orange API

        // Add the deposit amount to the wallet balance
        $wallet->balance += $request->amount;
        $wallet->save();

        return redirect()->back()->with('success', 'Deposit successful! Your balance has been updated.');
    }

    // Handle withdraw action
    public function withdraw(Request $request)
    {
        $request->validate([
            'transaction_type' => 'required|in:MTN,Orange',
            'phone_number' => 'required|numeric|digits:9',
            'amount' => 'required|numeric|min:100',
        ]);

        $user = Auth::user();
        $wallet = $user->wallet;

        // Ensure the user has enough balance
        if ($wallet->balance >= $request->amount) {
            // Simulate the withdrawal process
            // In real implementation, this is where you'd call the payment gateway API to process withdrawal

            // Deduct the amount from the wallet balance
            $wallet->balance -= $request->amount;
            $wallet->save();

            return redirect()->back()->with('success', 'Withdrawal successful! Your balance has been updated.');
        } else {
            return redirect()->back()->with('error', 'Insufficient balance for withdrawal.');
        }
    }
}
