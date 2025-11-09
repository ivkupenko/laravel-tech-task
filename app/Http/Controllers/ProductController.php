<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::filter(request()->all())
            ->with('attributeValues.attribute')
            ->orderByRaw('CASE WHEN count = 0 THEN 1 ELSE 0 END')
            ->orderBy('name')
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $attributes = Attribute::with('values')->get();
        return view('products.create', compact('attributes'));
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

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load('attributeValues.attribute');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('attributeValues.attribute');

        $attributes = Attribute::with('values')->get();

        return view('products.edit', compact('product', 'attributes'));
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

        return redirect()->route('products.index', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->attributeValues()->detach();

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
}
