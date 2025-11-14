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

    public function edit(Cart $cart)
    {
        return view('admin.carts.edit', compact('cart'));
    }

    public function update(Request $request, Cart $cart)
    {
        foreach ($cart->items as $item) {

            $quantity = $request->input("items.$item->id.quantity");
            $item->update(['quantity' => $quantity]);

            $attributes = $request->input("items.$item->id.attributes", []);

            $item->attributeValues()->delete();

            foreach ($attributes as $valueId) {
                $item->attributeValues()->create([
                    'attribute_value_id' => $valueId,
                ]);
            }
        }

        return redirect()
            ->route('admin.carts.show', $cart)
            ->with('success', 'Cart updated successfully.');
    }

    public function removeItemsPage(Cart $cart)
    {
        $cart->load('items.product');

        return view('admin.carts.remove-items', compact('cart'));
    }

    public function removeItems(Request $request, Cart $cart)
    {
        $itemIds = $request->input('items', []);

        if (!empty($itemIds)) {
            $cart->items()->whereIn('id', $itemIds)->delete();
        }

        if ($cart->items()->count() === 0) {
            $cart->delete();

            return redirect()->route('admin.carts.index')->with('success', 'Cart was empty and has been deleted.');
        }

        return redirect()->route('admin.carts.edit', $cart)->with('success', 'Selected items removed.');
    }

    public function editItemAttributes(Cart $cart, CartItem $item)
    {
        $groups = $item->product->attributeValues->groupBy(fn($av) => $av->attribute->name);

        $selected = $item->attributeValues->pluck('attribute_value_id')->toArray();

        return view('admin.carts.edit-attributes', compact('cart', 'item', 'groups', 'selected'));
    }

    public function updateItemAttributes(Request $request, Cart $cart, CartItem $item)
    {
        $attributes = $request->input('attributes', []);

        $item->attributeValues()->delete();

        foreach ($attributes as $valueId) {
            $item->attributeValues()->create([
                'attribute_value_id' => $valueId,
            ]);
        }

        return redirect()->route('admin.carts.edit', $cart)
            ->with('success', 'Attributes updated successfully.');
    }
}
