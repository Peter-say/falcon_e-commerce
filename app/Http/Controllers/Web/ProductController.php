<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function details($productSlug)
{
    $product = Product::where('status', 'active')->where('slug', $productSlug)->firstOrFail();
    $product->increment('view_count');

    $featuredProducts = Product::where('status', 'active')->where('is_featured', 1)->get();

    $related_products = Product::where('category_id', $product->category_id)
        ->where('status', 'active')
        ->where('id', '!=', $product->id)
        ->get();

    return view('web.shop.product.details', [
        'product' => $product,
        'related_products' => $related_products,
        'featuredProducts' => $featuredProducts,
    ]);
}

}
