<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;

class ClientCartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart()->with('items.product')->firstOrCreate([]);

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
}
