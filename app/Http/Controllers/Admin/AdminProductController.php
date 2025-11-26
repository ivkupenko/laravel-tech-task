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
        $products = Product::filter(request()->all())->orderBy('name')->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $product = Product::create($validated);

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Product created. Now add variants.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        if ($request->input('redirect_to') === 'variants') {
            return redirect()->route('admin.products.variants.index', $product)
                ->with('success', 'Product name and description updated. Now managing variants.');
        }

        return redirect()->route('admin.products.index', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->variants()->delete();

        $product->delete();

        return redirect()->route('admin.products.index')->with('warning', 'Product deleted!');
    }
}
