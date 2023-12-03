<?php

namespace Database\Factories;

use App\Constants\Finance\CurrencyConstants;
use App\Helpers\FileHelpers;
use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {
        $imageDirectory = public_path('assets/img/products/');
        $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        shuffle($images);

        // Pick the first 5 images from the shuffled array
        $randomImages = array_slice($images, 0, 5);

        // Destination directory
        $destinationPath = public_path('product/images/');

        // Create the destination directory if it doesn't exist
        File::ensureDirectoryExists($destinationPath);

        $savedImages = [];

        foreach ($randomImages as $image) {
            $basename = basename($image);
            $destination = $destinationPath . $basename;

            // Check if the file already exists
            if (File::exists($destination)) {
                // If it exists, unlink (delete) it
                File::delete($destination);
            }

            // Copy the image to the destination directory
            File::copy($image, $destination);

            // Save the basename to the array
            $savedImages[] = $basename;
        }

        // Convert the array of saved image basenames to a JSON string
        $serializedImagePaths = json_encode($savedImages);

        $faker = \Faker\Factory::create();
        $meta_keyword = implode(',', $faker->words(mt_rand(3, 5)));

        $product_specifications = [
            [
                'label' => 'Processor',
                'property' => '2.3GHz quad-core Intel Core i5',
            ],
            [
                'label' => 'Memory',
                'property' => '8GB of 2133MHz LPDDR3 onboard memory',
            ],
            [
                'label' => 'Brand Name',
                'property' => 'Apple',
            ],
            [
                'label' => 'Model',
                'property' => 'Mac Book Pro',
            ],
            [
                'label' => 'Display',
                'property' => '13.3-inch (diagonal) LED-backlit display with IPS technology',
            ],
            [
                'label' => 'Storage',
                'property' => '512GB SSD',
            ],
            [
                'label' => 'Graphics',
                'property' => 'Intel Iris Plus Graphics 655',
            ],
            [
                'label' => 'Weight',
                'property' => '7.15 pounds',
            ],
            [
                'label' => 'Finish',
                'property' => 'Silver, Space Gray',
            ],

        ];

        $length = 5;
        $product_identification_number = '#' . rand(pow(10, $length - 1), pow(10, $length) - 1);

        $product = Product::create([
            'user_id' => 1,
            'category_id' => mt_rand(1, 2),
            'store_id' => mt_rand(1, 5),
            'brand_id' => mt_rand(1, 5),
            'currency_id' => 1,
            'name' => $name = $this->faker->sentence($nbWords = rand(10, 15), $variableNbWords = true),
            'slug' => Str::slug($name),
            'amount' => $amount = $this->faker->randomFloat(8, 2, 1000),
            'discount_price' => $discount_price = $this->faker->randomFloat(4, 2, 100),
            'discount_percent' => (($amount - $discount_price) / $amount) * 100,
            'discount_period' => null,
            'basic_unit' => 'kg',
            'identification_no' => $product_identification_number,
            'warranty policy' => 'Do not drop inside water',
            'warranty lenght' => array_rand(['12 months', '6 months', '16 months']),
            'description' => $this->faker->paragraph($nbSentences = 30),
            'meta_description' => $this->faker->sentence(),
            'meta_keyword' => $meta_keyword,
            'images' => $serializedImagePaths,
            'stock_status' => 'Available',
            'status' => 'active',
        ]);


        foreach ($product_specifications as $spec) {
            $product->specifications()->create([
                'label' => $spec['label'],
                'property' => $spec['property'],
            ]);
        }

        return $product->toArray();
    }
}
