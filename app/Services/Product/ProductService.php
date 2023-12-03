<?php

namespace App\Services\Product;

use App\Helpers\FileHelpers;
use App\Models\Product;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Decimal;

class ProductService
{
    public static function validateProduct(Request $request)
    {
        try {
            // Validate the form data
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'basic_unit' => 'nullable',
                'cover_image' => 'required|image|max:2048|min:8000|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
                'amount' => 'required|numeric',
                'discount_price' => 'nullable|numeric',
                'description' => 'required',
                'currency_id' => 'required|exists:currencies,id',
                'brand_id' => 'required|exists:brands,id',
                'store_id' => 'nullable|exists:stores,id',
                'category_id' => 'required|exists:product_categories,id',
                'stock_status' => 'Required|string',
                'status' => 'Required|string',
                'meta_description' => 'nullable|max:200',
                'meta_keyword' => 'nullable:array',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        } catch (ValidationException $e) {
            return redirect()->back()->with('error_message', 'An error occurred. Please try again later.', $e);
        }
    }

    public static function storeProduct(Request $request)
    {
        $data = self::validateProduct($request);

        $user_id = Auth::user()->id;
        $cover_image = FileHelpers::saveImageRequest($request->file('cover_image'), 'product/cover_images/');
        $cover_image_path = pathinfo($cover_image, PATHINFO_BASENAME);

        $amount = floatval($request->input('amount'));
        $discount_price = floatval($request->input('discount_price'));

        $discount_percent = null;
        if ($request->has('discount_price') && $amount !== 0) {
            $discount_percent = (($amount - $discount_price) / $amount) * 100;
        }

        $product = Product::create([
            'user_id' => $user_id,
            'name' => $request->input('name'),
            'basic_unit' => $request->input('basic_unit'),
            'category_id' => $request->input('category_id'),
            'brand_id' => $request->input('brand_id'),
            'store_id' => $request->input('store_id') ?? null,
            'currency_id' => $request->input('currency_id'),
            'cover_image' => $cover_image_path,
            'amount' => ($amount - $discount_price),
            'discount_price' => $discount_price ?? null,
            'discount_percent' => $discount_percent,
            'description' => $request->input('description'),
            'stock_status' => $request->input('stock_status'),
            'status' => $request->input('status'),
            'meta_description' => $request->input('meta_description') ?? null,
            'meta_keyword' => is_array($request->input('meta_keyword')) ? implode(',', $request->input('meta_keyword')) : null,
        ]);

        // Return the created product instance
        return $product;
    }

    public static function updateProduct(Request $request, $id)
    {
        $data = self::validateProduct($request);

        $product = Product::where('id', $id)->first();
        $user_id = Auth::user()->id;

        $old_cover_image = $product->cover_image;
        if ($request->file('cover_image')) {
            $cover_image = FileHelpers::saveImageRequest($request->file('cover_image'), 'product/cover_images/');
            $cover_image_path = pathinfo($cover_image, PATHINFO_BASENAME);
        } else {
            $cover_image_path = $old_cover_image;
        }

        $amount = $request->input('amount');
        $discount_price = $request->input('discount_price');

        $discount_percent = null;
        if ($request->has('discount_price')) {
            $discount_percent = (($amount - $discount_price) / $amount) * 100;
        }

        $product->update([
            'user_id' => $user_id,
            'name' => $request->input('name'),
            'basic_unit' => $request->input('basic_unit'),
            'category_id' => $request->input('category_id'),
            'brand_id' => $request->input('brand_id'),
            'store_id' => $request->input('store_id') ?? null,
            'currency_id' => $request->input('currency_id'),
            'cover_image' => $cover_image_path,
            'amount' => ($amount - $discount_price),
            'discount_price' => $discount_price ?? null,
            'discount_percent' => $discount_percent,
            'description' => $request->input('description'),
            'stock_status' => $request->input('stock_status'),
            'status' => $request->input('status'),
            'meta_description' => $request->input('meta_description') ?? null,
            'meta_keyword' => is_array($request->input('meta_keyword')) ? implode(',', $request->input('meta_keyword')) : null,
        ]);

        return $product;
    }
}
