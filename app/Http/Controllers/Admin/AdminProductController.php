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
            'attributes' => 'array',
            'attributes.*.value_id' => 'required|exists:attribute_values,id',
            'attributes.*.count' => 'required|integer|min:0',
        ]);

        $product = Product::create($validated);

        if (!empty($validated['attributes'])) {
            $pivotData = [];

            foreach ($validated['attributes'] as $attr) {
                $pivotData[$attr['value_id']] = ['count' => $attr['count']];
            }

            $product->attributeValues()->attach($pivotData);
        }

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
        $attributes = $request->input('attributes', []);

        $filtered = array_filter($attributes, function ($item) {
            return isset($item['value_id']); // keep only valid rows
        });

        $request->merge(['attributes' => $filtered]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attributes' => 'array',
            'attributes.*.value_id' => 'required|exists:attribute_values,id',
            'attributes.*.count' => 'required|integer|min:0',
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        $pivotData = [];

        foreach ($validated['attributes'] as $attr) {
            $pivotData[$attr['value_id']] = ['count' => $attr['count']];
        }

        $product->attributeValues()->sync($pivotData);


        return redirect()->route('admin.products.index', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->attributeValues()->detach();

        $product->delete();

        return redirect()->route('admin.products.index')->with('warning', 'Product deleted!');
    }
}
