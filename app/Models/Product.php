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
        'count',
    ];

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_value_product');
    }
}
