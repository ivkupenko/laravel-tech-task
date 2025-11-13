<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Products\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::filter(request()->all())
            ->orderByRaw('CASE WHEN count = 0 THEN 1 ELSE 0 END')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $attributes = Attribute::with('values')->get();
        return view('admin.products.create', compact('attributes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'count' => ['required', 'integer', 'min:0'],
            'attribute_values' => ['array'],
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'count' => $validated['count'],
        ]);

        $product->attributeValues()->attach($validated['attribute_values'] ?? []);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $attributes = Attribute::with('values')->get();

        return view('admin.products.edit', compact('product', 'attributes'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'count' => ['required', 'integer', 'min:0'],
            'attribute_values' => ['array'],
        ]);

        $product->update($validated);
        $product->attributeValues()->sync($validated['attribute_values'] ?? []);

        return redirect()->route('admin.products.index', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->attributeValues()->detach();

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted!');
    }
}
