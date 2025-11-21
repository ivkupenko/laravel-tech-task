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

    public function attributeId($id)
    {
        return $this->whereHas('attributeValues', function ($q) use ($id) {
            $q->where('attribute_id', $id);
        });
    }

    public function attributeValueId($valueId)
    {
        $attributeId = request('attributeId');

        if (!$attributeId || !$valueId) {
            return $this;
        }

        return $this->whereHas('attributeValues', function ($q) use ($attributeId, $valueId) {
            $q->where('attribute_id', $attributeId)
                ->where('attribute_values.id', $valueId);
        });
    }
}
