<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    public function run()
    {
        $brandsDatas = [
            [
                'logo' => 'brand1.png',
                'name' => 'Brand 1',
                'uuid' => 'brand1-uuid',
                'total_products' => 10,
                'status' => 'active',
            ],
            [
                'logo' => 'brand2.png',
                'name' => 'Brand 2',
                'uuid' => 'brand2-uuid',
                'total_products' => 5,
                'status' => 'active',
            ],
            [
                'logo' => 'brand3.png',
                'name' => 'Brand 3',
                'uuid' => 'brand3-uuid',
                'total_products' => 8,
                'status' => 'active',
            ],
            [
                'logo' => 'brand4.png',
                'name' => 'Brand 4',
                'uuid' => 'brand4-uuid',
                'total_products' => 3,
                'status' => 'active',
            ],
            [
                'logo' => 'brand5.png',
                'name' => 'Brand 5',
                'uuid' => 'brand5-uuid',
                'total_products' => 12,
                'status' => 'active',
            ],
        ];

        foreach ($brandsDatas as $brandData) {
            Brand::create($brandData);
        }
    }
}

