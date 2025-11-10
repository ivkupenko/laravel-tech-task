<?php

namespace Database\Seeders;

use App\Models\Products\Attribute;
use App\Models\Products\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $attributes = [
            'Color' => ['Red', 'Orange', 'Yellow', 'Green', 'Blue', 'Indigo', 'Violet'],
            'Size' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
            'Material' => ['Cotton', 'Leather', 'Silk', 'Wood', 'ABS', 'Paper'],
        ];

        foreach ($attributes as $name => $values) {
            $attribute = Attribute::create(['name' => $name]);
            foreach ($values as $value) {
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value' => $value,
                ]);
            }
        }
    }
}
