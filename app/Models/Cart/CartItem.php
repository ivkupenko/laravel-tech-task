<?php

namespace App\Models\Cart;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $with = ['attributeValues.attributeValue.attribute'];

    protected $fillable = ['cart_id', 'product_id', 'product_variant_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(CartItemAttributeValue::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(\App\Models\Products\ProductVariant::class);
    }
}
