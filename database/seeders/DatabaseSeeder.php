<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
use Illuminate\Database\Seeder;

// $fakar->addProvider(new ProductFactory($fakar));


class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(StoresTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
        \App\Models\Product::factory(30)->create();
        $this->call(WalletSeeder::class);
       

    }
}
