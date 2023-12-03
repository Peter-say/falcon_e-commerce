<?php

namespace Database\Seeders;

use App\Constants\Finance\CurrencyConstants;
use App\Constants\StatusConstants;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                "name" => "US Dollar",
                "type" => CurrencyConstants::DOLLAR_CURRENCY,
                "price_per_dollar" => 1,
                "symbol" => "$",
                "status" => StatusConstants::ACTIVE,
            ],
            [
                "name" => "Nigerian Naira",
                "type" => CurrencyConstants::NAIRA_CURRENCY,
                "price_per_dollar" => 570,
                "symbol" => "₦",
                "status" => StatusConstants::ACTIVE
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
