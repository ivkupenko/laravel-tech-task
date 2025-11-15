<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-center">
            Select Attributes for {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-10 flex justify-center">
        <div class="w-full max-w-3xl bg-white p-6 rounded-lg shadow">

            <form method="POST" action="{{ route('client.cart.addWithAttributes', $product) }}">
                @csrf
                @method('POST')

                @foreach ($attributes as $attributeName => $values)
                    <div class="mb-6">
                        <p class="font-semibold mb-2">{{ ucfirst($attributeName) }}</p>

                        @foreach ($values as $value)
                            <label class="flex items-center space-x-2">
                                <input type="radio"
                                       name="attributes[{{ $value->attribute_id }}]"
                                       value="{{ $value->id }}"
                                       required>
                                <span>{{ $value->value }}</span>
                            </label>
                        @endforeach
                    </div>
                @endforeach

                <div class="flex justify-between items-center mt-6">
                    <x-secondary-link-button href="{{ route('client.products.index') }}">Back to products
                    </x-secondary-link-button>
                    <x-primary-button type="submit">Add to Cart</x-primary-button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
