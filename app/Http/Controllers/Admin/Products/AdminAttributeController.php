<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Products\Attribute;
use App\Models\Products\AttributeValue;
use Illuminate\Http\Request;

class AdminAttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::with('values')->get();
        return view('admin.products.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.products.attributes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name',
            'values_raw' => 'nullable|string'
        ]);

        $attribute = Attribute::create(['name' => $data['name']]);
        $this->storeValues($attribute, $data['values_raw'] ?? null);

        return redirect()->route('admin.products.attributes.index')->with('success', 'Attribute created.');
    }

    public function edit(Attribute $attribute)
    {
        $attribute->load('values');
        return view('admin.products.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name,' . $attribute->id,
            'values_raw' => 'nullable|string'
        ]);

        $attribute->update(['name' => $data['name']]);
        $attribute->values()->delete();
        $this->storeValues($attribute, $data['values_raw'] ?? null);

        return redirect()->route('admin.products.attributes.index')->with('success', 'Attribute updated.');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->values()->delete();
        $attribute->delete();

        return redirect()->route('admin.products.attributes.index')
            ->with('warning', 'Attribute deleted successfully.');
    }

    private function storeValues(Attribute $attribute, ?string $raw)
    {
        if (!$raw) return;
        $values = collect(explode(',', $raw))
            ->map(fn($v) => trim($v))
            ->filter();
        foreach ($values as $v) {
            AttributeValue::create(['attribute_id' => $attribute->id, 'value' => $v]);
        }
    }
}
