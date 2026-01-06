<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;
use Illuminate\Http\Request;

class AdminCartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('user')->latest()->paginate(10);

        return view('admin.carts.index', compact('carts'));
    }

    public function show(Cart $cart)
    {
        return view('admin.carts.show', compact('cart'));
    }

    public function removeItem(Cart $cart, CartItem $item)
    {
        $item->delete();
        return redirect()->route('admin.carts.show', $cart)->with('warning', 'Product removed from cart successfully.');
    }

    private function buildVariantsData(CartItem $item)
    {
        return $item->product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'stock' => $variant->stock,
                'attribute_values' => $variant->attributeValues->pluck('id')->toArray()
            ];
        });
    }

    private function buildAttributesData(CartItem $item)
    {
        return $item->product->variants
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
            })->values();
    }


    public function editItem(Cart $cart, CartItem $item)
    {
        $variants = $this->buildVariantsData($item);
        $attributes = $this->buildAttributesData($item);
        $selected = $item->productVariant->attributeValues->pluck('value')->toArray();

        return view('admin.carts.edit-item', compact('cart', 'item', 'variants', 'attributes', 'selected'));
    }

    public function updateItem(Request $request, Cart $cart, CartItem $item)
    {
        $quantity = $request->input("items.$item->id.quantity");
        $item->update(['quantity' => $quantity]);

        $attributes = $request->input("items.$item->id.attributes", []);

        $item->attributeValues()->delete();

        return redirect()->route('admin.carts.show', $cart)
            ->with('success', 'Product in your cart updated successfully.');
    }
}
