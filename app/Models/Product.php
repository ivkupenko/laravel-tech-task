<?php

namespace App\Models;

use App\Models\Products\ProductVariant;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Filterable;

    protected $with = ['variants.attributeValues.attribute'];
    protected $fillable = ['name', 'description'];

    public function variants(){
        return $this->hasMany(ProductVariant::class);
    }

    public function scopeInStock($query)
    {
        return $query->whereHas('variants', function ($q) {
            $q->where('product_variants.stock', '>', 0);
        });
    }
}
