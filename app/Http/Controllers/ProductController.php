<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()->where('active', true)->latest()->get();
        $featured = $products->where('featured', true)->take(3);

        return view('store.home', compact('products', 'featured'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->active, 404);

        return view('store.show', compact('product'));
    }
}
