<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

    public function image(Product $product): BinaryFileResponse
    {
        abort_unless($product->image_path && Storage::disk('public')->exists($product->image_path), 404);

        return response()->file(Storage::disk('public')->path($product->image_path));
    }
}
