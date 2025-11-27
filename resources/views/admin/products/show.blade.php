<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-10 px-6 flex justify-center">
        <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-3xl">
            <h1 class="text-2xl font-bold mb-4 text-gray-800">{{ $product->name }}</h1>

            <p class="text-gray-700 mb-2">
                <strong>{{ __('Description') }}:</strong>
                {{ $product->description ?? '—' }}
            </p>

            <h3 class="text-lg font-semibold mb-3 text-gray-800">{{ __('More Details') }}</h3>

            @php
                $groupedAttributes = $product->variants
                    ->flatMap(fn($v) => $v->attributeValues)
                    ->unique('id')
                    ->groupBy(fn($av) => $av->attribute->name);
            @endphp

            @if($groupedAttributes->isEmpty())
                <p class="text-gray-500 italic mb-4">No attributes assigned.</p>
            @else
                <div class="space-y-2">
                    @foreach($groupedAttributes as $attributeName => $values)
                        <div class="flex items-start">
                            <span class="font-semibold w-32 text-gray-700">{{ $attributeName }}:</span>
                            <span class="text-gray-800">
                                {{ $values->pluck('value')->join(', ') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-8 flex justify-between gap-4">
                <x-primary-link-button href="{{ route('admin.products.index') }}">Back to Products
                </x-primary-link-button>

                @if(auth()->user()?->isAdmin())
                    <x-secondary-link-button href="{{ route('admin.products.edit', $product) }}">Edit Product details
                    </x-secondary-link-button>

                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                          onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')

                        <x-danger-button type="submit">Delete Product</x-danger-button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
