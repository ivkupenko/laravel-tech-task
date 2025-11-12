<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ClientProductController extends Controller
{
    public function index()
    {
        $products = Product::filter(request()->all())
            ->orderByRaw('CASE WHEN count = 0 THEN 1 ELSE 0 END')
            ->orderBy('name')
            ->paginate(10);

        return view('client.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('client.products.show', compact('product'));
    }
}
