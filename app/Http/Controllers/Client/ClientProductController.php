<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Products\Attribute;

class ClientProductController extends Controller
{
    public function index()
    {
        $products = Product::inStock()->filter(request()->all())
            ->with('attributeValues.attribute')
            ->orderBy('name')->paginate(10);

        $attributes = Attribute::with('values')->get();

        return view('client.products.index', compact('products', 'attributes'));
    }

    public function show(Product $product)
    {
        if ($product->attributeValues->sum('pivot.count') === 0) {
            abort(404);
        }
        return view('client.products.show', compact('product'));
    }
}
