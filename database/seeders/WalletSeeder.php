<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Type\Decimal;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Wallet::create([
        'user_id' => 1,
        'balance' => number_format(500.00),
        'currency' => 'USD',
        'symbol' => '$',
        'status' => 'active',
        'withdrawal_limit' => null,
        'transaction_fee' => 0,
       ]);
    }
}
