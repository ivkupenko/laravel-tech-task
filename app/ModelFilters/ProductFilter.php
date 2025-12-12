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
}
