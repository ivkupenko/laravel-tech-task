<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 flex flex-col items-center">
        <a href="{{ route('products.create') }}"
           class="mb-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            + Add Product
        </a>

        <div class="w-full max-w-4xl bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Description</th>
                    <th class="px-4 py-2 text-left">Count</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ $product->description }}</td>
                        <td class="px-4 py-2">{{ $product->count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">No products found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
