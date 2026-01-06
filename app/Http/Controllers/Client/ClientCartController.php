<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientCartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart()
            ->with('items.product', 'items.productVariant.attributeValues.attribute')
            ->firstOrCreate([]);
        return view('client.cart.index', compact('cart'));
    }

    public function add(Product $product)
    {
        $cart = auth()->user()->cart()->firstOrCreate([]);

        $variant = $product->variants()
            ->doesntHave('attributeValues')
            ->first();

        $variantId = $variant ? $variant->id : null;

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'product_variant_id' => $variantId,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function update(CartItem $item, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item->update([
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(CartItem $item)
    {
        $item->delete();

        return back()->with('warning', 'Product removed from cart.');
    }

    private function buildVariantData(Product $product)
    {
        return $product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'stock' => $variant->stock,
                'attribute_values' => $variant->attributeValues->pluck('id')->toArray()
            ];
        });
    }

    private function buildAttributeData(Product $product)
    {
        return $product->variants
            ->flatMap(fn($v) => $v->attributeValues)
            ->unique('id')
            ->groupBy('attribute_id')
            ->map(function ($group) {
                $firstItem = $group->first();
                return [
                    'id' => $firstItem->attribute_id,
                    'name' => $firstItem->attribute->name,
                    'values' => $group->map(fn($v) => [
                        'id' => $v->id,
                        'value' => $v->value
                    ])->values()
                ];
            })
            ->values();
    }

    public function selectAttributes(Product $product)
    {
        $variantData = $this->buildVariantData($product);
        $attributesData = $this->buildAttributeData($product);

        return view('client.cart.select-attributes', compact('product', 'variantData', 'attributesData'));

    }

    public function addWithAttributes(Request $request, Product $product)
    {
        $request->validate([
            'attributes' => 'required|array',
            'attributes.*' => 'exists:attribute_values,id'
        ]);

        $valueIds = array_values($request->input('attributes', []));

        $variant = $product->variants()
            ->whereHas('attributeValues', function ($q) use ($valueIds) {
                $q->whereIn('attribute_values.id', $valueIds);
            }, '=', count($valueIds))
            ->withCount('attributeValues')
            ->having('attribute_values_count', count($valueIds))
            ->first();

        if (!$variant) {
            return back()->with('error', 'Selected combination is unavailable.');
        }

        $cart = auth()->user()->cart()->firstOrCreate([]);

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variant->id)
            ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $item = $cart->items()->create([
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('client.products.index')
            ->with('success', 'Product added to cart.');
    }

    public static function itemsCount()
    {
        return auth()->user()->cartItemsCount();
    }
}
