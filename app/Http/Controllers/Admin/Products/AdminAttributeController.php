<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Products\Attribute;
use App\Services\Logging\Logger;
use App\Enums\LogLevel;
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

    public function store(Request $request, Logger $logger)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name',
            'values' => 'array',
            'values.*' => 'nullable|string|max:255',
        ]);

        $attribute = Attribute::create(['name' => $validated['name']]);
        $this->storeValues($attribute, $validated['values'] ?? null);

        $logger('Attribute created: ' . $attribute->name);

        return redirect()->route('admin.products.attributes.index')->with('success', 'Attribute created.');
    }

    public function edit(Attribute $attribute)
    {
        $attribute->load('values');
        return view('admin.products.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute, Logger $logger)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name,' . $attribute->id,
            'values' => 'array',
            'values.*' => 'nullable|string|max:255',
        ]);

        $attribute->update(['name' => $validated['name']]);

        $attribute->values()->delete();

        if (!empty($validated['values'])) {
            $this->storeValues($attribute, $validated['values']);
        }

        $logger('Attribute updated: ' . $attribute->name);

        return redirect()->route('admin.products.attributes.index')->with('success', 'Attribute updated.');
    }

    public function destroy(Attribute $attribute, Logger $logger)
    {
        $attribute->values()->delete();
        $attribute->delete();

        $logger('Attribute deleted: ' . $attribute->name, LogLevel::warning);

        return redirect()->route('admin.products.attributes.index')
            ->with('warning', 'Attribute deleted successfully.');
    }

    private function storeValues(Attribute $attribute, array $values): void
    {
        $values = collect($values)
            ->map(fn($v) => trim($v))
            ->filter()
            ->unique();
        foreach ($values as $value) {
            $attribute->values()->create([
                'value' => $value,
            ]);
        }
    }
}
