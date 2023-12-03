<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;

class IndexController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::where('status', 'active')  ->whereNull('parent_id')->get();
        $products = Product::where('status', 'active')->paginate(50);
        return View('web.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
