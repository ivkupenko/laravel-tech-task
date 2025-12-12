<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Variants for: "{{ $product->name }}"
            </h2>

            <div class="flex gap-2">
                <x-secondary-link-button href="{{ route('admin.products.index') }}">
                    ← Back to products
                </x-secondary-link-button>

                <x-primary-link-button href="{{ route('admin.products.variants.create', $product) }}">
                    + Add variant
                </x-primary-link-button>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 flex justify-center">
        <div class="bg-white shadow-md rounded-lg p-6 min-w-full max-w-4xl">
            <h3 class="font-semibold text-lg mb-4">Existing variants</h3>

            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-2 text-left w-28">Variant Id</th>
                    <th class="px-4 py-2 text-left">Attributes</th>
                    <th class="px-4 py-2 text-left w-32">Stock</th>
                    <th class="px-4 py-2 text-left w-32">Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse($variants as $variant)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">
                            {{ $variant->id }}
                        </td>

                        <td class="px-4 py-2">
                            @php
                                $grouped = $variant->attributeValues->groupBy(fn($v) => $v->attribute->name);
                            @endphp

                            @foreach($grouped as $attributeName => $values)
                                <div class="mb-1">
                                    <strong>{{ ucfirst($attributeName) }}:</strong>
                                    {{ $values->pluck('value')->join(', ') }}
                                </div>
                            @endforeach
                        </td>

                        <td class="px-4 py-2">
                            {{ $variant->stock }}
                        </td>

                        <td class="px-4 py-2">
                            <div class="flex gap-2">
                                <form method="POST"
                                      action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}"
                                      onsubmit="return confirm('Delete this variant?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>Delete</x-danger-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">
                            No variants yet.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
