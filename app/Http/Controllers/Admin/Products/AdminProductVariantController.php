<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Products\Attribute;
use App\Models\Products\ProductVariant;
use App\Services\Products\SkuGenerator;
use Illuminate\Http\Request;

class AdminProductVariantController extends Controller
{
    public function index(Product $product)
    {
        $attributes = Attribute::with('values')->get();
        $variants = $product->variants()->with('attributeValues.attribute')->get();

        return view('admin.products.variants.index', compact('product', 'attributes', 'variants'));
    }

    public function create(Product $product)
    {
        $attributes = Attribute::with('values')->get();

        return view('admin.products.variants.create', compact('product', 'attributes'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'attributes' => 'array',
            'attributes.*' => 'nullable|exists:attribute_values,id',
            'stock' => 'required|integer|min:0',
        ]);

        $valueIds = collect($validated['attributes'] ?? [])
            ->filter(fn($id) => !empty($id))
            ->values()
            ->all();

        $sku = app(\App\Services\Products\SkuGenerator::class)
            ->generateForValues($product, $valueIds);

        $variant = $product->variants()->create([
            'sku' => $sku,
            'stock' => $validated['stock'],
        ]);

        if (!empty($valueIds)) {
            $variant->attributeValues()->attach($valueIds);
        }

        return redirect()->route('admin.products.variants.index', $product)->with('success', 'Variant created successfully.');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        $variant->attributeValues()->detach();
        $variant->delete();

        return redirect()->route('admin.products.variants.index', $product)->with('success', 'Variant deleted!');
    }
}
