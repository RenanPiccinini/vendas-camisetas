<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()->latest()->paginate(12);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.create', ['product' => new Product(['sizes' => ['P', 'M', 'G', 'GG']])]);
    }

    public function store(Request $request): RedirectResponse
    {
        Product::create($this->validated($request));

        return redirect()->route('admin.products.index')->with('success', 'Camiseta cadastrada com sucesso.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $oldImagePath = $product->image_path;
        $data = $this->validated($request, $product);
        $product->update($data);

        if ($oldImagePath && $oldImagePath !== $product->image_path) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()->route('admin.products.index')->with('success', 'Camiseta atualizada com sucesso.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $imagePath = $product->image_path;
        $product->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->route('admin.products.index')->with('success', 'Camiseta removida com sucesso.');
    }

    private function validated(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'team' => ['required', 'string', 'max:80'],
            'season' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'sizes_text' => ['nullable', 'string', 'max:100'],
            'stock' => ['required', 'integer', 'min:0'],
            'featured' => ['nullable', 'boolean'],
            'active' => ['nullable', 'boolean'],
        ]);

        $data['sizes'] = array_values(array_filter(preg_split('/[\s,]+/', trim($data['sizes_text'] ?? 'P M G GG'))));
        unset($data['sizes_text']);
        $data['featured'] = $request->boolean('featured');
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('image_file')) {
            $data['image_path'] = $request->file('image_file')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image_path'] = null;
        } elseif ($product) {
            $data['image_path'] = $product->image_path;
        }

        return $data;
    }
}
