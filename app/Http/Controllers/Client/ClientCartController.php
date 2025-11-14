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
            ->with('items.product', 'items.attributeValues.attributeValue.attribute')
            ->firstOrCreate([]);
        return view('client.cart.index', compact('cart'));
    }

    public function add(Product $product)
    {
        $cart = auth()->user()->cart()->firstOrCreate([]);

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->update(['quantity' => $item->quantity + 1]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
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

    public function selectAttributes(Product $product)
    {
        $attributes = $product->attributeValues->groupBy(fn($item) => $item->attribute->name);

        return view('client.cart.select-attributes', compact('product', 'attributes'));
    }

    public function addWithAttributes(Request $request, Product $product)
    {
        $request->validate([
            'attributes' => 'required|array',
            'attributes.*' => 'exists:attribute_values,id'
        ]);

        $cart = auth()->user()->cart()->firstOrCreate([]);

        $item = $cart->items()->create([
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);

        $attributes = $request->input('attributes', []);

        foreach ($attributes as $valueId) {
            $item->attributeValues()->create([
                'attribute_value_id' => $valueId
            ]);
        }

        return redirect()->route('client.cart.index')
            ->with('success', 'Product added to cart.');
    }
}
