<?php

namespace App\Models\Products;

use App\Models\Product;
use App\Models\Products\AttributeValue;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory, Filterable;

    protected $with = ['attributeValues.attribute'];
    protected $fillable = ['product_id', 'sku', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_values');
    }
}
