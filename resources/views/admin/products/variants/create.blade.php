<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Create Variant for: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-8 flex justify-center">
        <div class="bg-white shadow-md rounded-lg p-6 min-w-full max-w-3xl">

            <form method="POST" action="{{ route('admin.products.variants.store', $product) }}">
                @csrf

                <h3 class="font-semibold text-lg mb-4">Select Attribute Values</h3>

                @foreach($attributes as $attribute)
                    <div class="mb-6 border-b pb-4">
                        <p class="font-semibold text-gray-800 mb-2">
                            {{ $attribute->name }}
                        </p>
                        <div class="flex flex-wrap gap-4">
                            @foreach($attribute->values as $value)
                                <label class="flex items-center space-x-2">

                                    <input type="radio"
                                           name="attributes[{{ $attribute->id }}]"
                                           value="{{ $value->id }}"
                                           class="attribute-radio"
                                           data-attribute="{{ $attribute->id }}">


                                    <span>{{ $value->value }}</span>

                                </label>
                            @endforeach

                            <label class="flex items-center space-x-2">
                                <input type="radio"
                                       name="attributes[{{ $attribute->id }}]"
                                       value=""
                                       class="attribute-radio"
                                       data-attribute="{{ $attribute->id }}">
                                <span>None</span>
                            </label>
                        </div>
                    </div>
                @endforeach

                <div class="mb-6">
                    <x-input-label for="stock" value="Stock"/>
                    <x-text-input id="stock" name="stock" type="number" min="0" class="mt-1 block w-32" required/>
                    <x-input-error :messages="$errors->get('stock')" class="mt-2"/>
                </div>

                <div class="flex justify-between mt-6">
                    <x-secondary-link-button href="{{ route('admin.products.variants.index', $product) }}">Back
                    </x-secondary-link-button>

                    <x-primary-button>Save Variant</x-primary-button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
