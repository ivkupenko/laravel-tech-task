<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantValue extends Model
{
    use HasFactory;

    protected $table = 'product_variant_values';
    protected $fillable = ['product_variant_id', 'attribute_value_id'];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function attributeValues()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
}
