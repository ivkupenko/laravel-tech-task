<?php

namespace App\Models;

use App\Models\Products\AttributeValue;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Filterable;

    protected $with = ['attributeValues.attribute'];
    protected $fillable = [
        'name',
        'description',
    ];

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_value_product')
            ->withPivot('count');
    }

    public function scopeInStock($query)
    {
        return $query->whereHas('attributeValues', function ($q) {
            $q->where('attribute_value_product.count', '>', 0);
        });
    }
}
