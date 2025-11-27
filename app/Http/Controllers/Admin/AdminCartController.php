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

    public function editItem(Cart $cart, CartItem $item)
    {
        $groups = $item->product->attributeValues->groupBy(fn($av) => $av->attribute->name);

        $selected = $item->attributeValues->pluck('attribute_value_id')->toArray();

        return view('admin.carts.edit-item', compact('cart', 'item', 'groups', 'selected'));
    }

    public function updateItem(Request $request, Cart $cart, CartItem $item)
    {

        $quantity = $request->input("items.$item->id.quantity");
        $item->update(['quantity' => $quantity]);

        $attributes = $request->input("items.$item->id.attributes", []);

        $item->attributeValues()->delete();

        foreach ($attributes as $valueId) {
            $item->attributeValues()->create([
                'attribute_value_id' => $valueId,
            ]);
        }

        return redirect()->route('admin.carts.show', $cart)
            ->with('success', 'Product in your cart updated successfully.');
    }
}
