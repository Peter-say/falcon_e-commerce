<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = glob(public_path('assets/img/products/*'));
        $random_images = basename($images[array_rand($images)]);

        $datas = [
            [
                'image' => $random_images,
                'name' => 'Wristwatch',
                'parent_id' => 2,
            ],

            [
                'image' => $random_images,
                'name' => 'Electronics',
                'parent_id' => 1,
            ],

            [
                'image' => $random_images,
                'name' => 'Apple',
                'parent_id' => 1,
            ],

            [
                'image' => $random_images,
                'name' => 'Phones',
                'parent_id' => 2,
            ],

            [
                'image' => $random_images,
                'name' => 'Laptop',
                'parent_id' => 2,
            ],
        ];

        foreach ($datas as $key => $data) {
            ProductCategory::create($data);
        }
    }
}
