<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ProductFilter extends ModelFilter
{
    public function name($value)
    {
        return $this->where('name', 'like', "%{$value}%");
    }

    public function description($value)
    {
        return $this->where('description', 'like', "%{$value}%");
    }

    public function countFrom($min)
    {
        return $this->where('count', '>=', $min);
    }

    public function countTo($max)
    {
        return $this->where('count', '<=', $max);
    }
}
