<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Models\Products\AttributeValue;
use Illuminate\Support\Str;

class SkuGenerator
{
    public function generateForValues(Product $product, array $valueIds): string
    {
        $parts = [strtoupper(Str::slug($product->name))];

        $values = AttributeValue::whereIn('id', $valueIds)
            ->with('attribute')
            ->get();

        foreach ($values as $value) {
            $parts[] = strtoupper(Str::slug($value->value));
        }

        return implode('-', $parts);
    }
}
