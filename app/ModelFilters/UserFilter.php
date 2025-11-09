<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use App\Models\Gender;

class UserFilter extends ModelFilter
{
    public function name($value)
    {
        return $this->where('name', 'like', "%{$value}%");
    }

    public function email($value)
    {
        return $this->where('email', 'like', "%{$value}%");
    }
    public function gender($value)
    {
        return $this->where('gender_id', $value);
    }
    public function ageFrom($min)
    {
        return $this->where('age', '>=', $min);
    }

    public function ageTo($max)
    {
        return $this->where('age', '<=', $max);
    }
}
