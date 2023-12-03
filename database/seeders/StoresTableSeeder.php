<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\User;
use Faker\Factory as Faker;

class StoresTableSeeder extends Seeder
{
    protected $countryIds;
    protected $stateIds;

    public function run()
    {
        $faker = Faker::create();

        $countryIds = Country::pluck('id');
        $stateIds = State::pluck('id');
        
        for ($i = 0; $i < 5; $i++) {
            $user = User::inRandomOrder()->first();

            Store::create([
                'user_id' => $user->id,
                'logo' => $faker->imageUrl(200, 200, 'business'),
                'name' => $faker->company,
                'uuid' => $faker->unique()->uuid,
                'description' => $faker->paragraph,
                'whatsapp_phone' => $faker->phoneNumber,
                'alt_phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'facebook_url' => $faker->url,
                'instagram_url' => $faker->url,
                'twitter_url' => $faker->url,
                'country_id' => $countryIds->random(),
                'state_id' => $stateIds->random(),
                'total_views' => 0,
                'total_products' => 0,
                'total_product_views' => 0,
                'avg_ratings' => 0.0,
                'total_reviews' => 0,
                'address' => $faker->address,
                'meta_keywords' => $faker->words(5, true),
                'meta_description' => $faker->sentence,
                'status' => 'active',
            ]);
        }
    }
}

