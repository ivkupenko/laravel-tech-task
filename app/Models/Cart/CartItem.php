<?php

namespace App\Models\Cart;

use App\Models\Product;
use App\Models\Products\ProductVariant;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'product_variant_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
