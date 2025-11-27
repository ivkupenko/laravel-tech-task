<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="min-w-full py-8 px-4 flex flex-col items-center">
        <x-primary-link-button href="{{ route('admin.products.create') }}">Add Product
        </x-primary-link-button>
        <br>

        <form method="GET" action="{{ route('admin.products.index') }}" class="mb-6 flex flex-wrap gap-6 items-end">
            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input id="name" name="name" type="text" placeholder="Filter by name"
                              value="{{ request('name') }}"
                              class="mt-1 block h-9"/>
            </div>

            <div>
                <x-input-label for="description" :value="__('Description')"/>
                <x-text-input id="description" name="description" type="text" placeholder="Filter by description"
                              value="{{ request('description') }}"
                              class="mt-1 block h-9"/>
            </div>

            <div class="flex gap-2 items-end">
                <div>
                    <x-input-label for="attribute_id" value="Attribute name" />
                    <select id="attribute_name" name="attributeId"
                            class="mt-1 block w-40 border-gray-300 rounded-md">
                        <option value="">Select Attribute</option>
                        @foreach($attributes as $attribute)
                            <option value="{{ $attribute->id }}"
                                {{ request('attributeId') == $attribute->id ? 'selected' : '' }}>
                                {{ ucfirst($attribute->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="attribute_value_id" value="Attribute value" />
                    <select id="attribute_value" name="attributeValueId"
                            class="mt-1 block w-40 border-gray-300 rounded-md">

                        <option value="">Select Value</option>

                        @if(request('attributeId'))
                            @foreach($attributes->firstWhere('id', request('attributeId'))->values as $value)
                                <option value="{{ $value->id }}"
                                    {{ request('attributeValueId') == $value->id ? 'selected' : '' }}>
                                    {{ $value->value }}
                                </option>
                            @endforeach
                        @endif

                    </select>
                </div>
            </div>

            <div class="flex gap-2 mt-1">
                <x-primary-button class="h-9">{{ __('Filter') }}</x-primary-button>
                <x-secondary-link-button
                    href="{{ route('admin.products.index') }}">{{ __('Reset') }}</x-secondary-link-button>
            </div>
        </form>


        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Description</th>
                    <th class="px-6 py-2 text-left w-40">Counts</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ $product->description }}</td>
                        <td class="px-6 py-2">
                            @php
                                $grouped = $product->attributeValues->groupBy('attribute.name');
                            @endphp

                            @foreach($grouped as $attributeName => $values)
                                <div class="mb-2">
                                    <strong>{{ $attributeName }}:</strong>

                                    @foreach($values as $value)
                                        <div>{{ $value->value }} – <strong>{{ $value->pivot->count }}</strong></div>
                                    @endforeach
                                </div>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 text-center">
                            <x-secondary-link-button href="{{ route('admin.products.show', $product) }}">View
                            </x-secondary-link-button>
                        </td>
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

@include('components.scripts.attribute-filter')
