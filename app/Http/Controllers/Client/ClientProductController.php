<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ClientProductController extends Controller
{
    public function index()
    {
        $products = Product::inStock()->filter(request()->all())->orderBy('name')->paginate(10);

        return view('client.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        if ($product->attributeValues->sum('pivot.count') === 0) {
            abort(404);
        }
        return view('client.products.show', compact('product'));
    }
}
