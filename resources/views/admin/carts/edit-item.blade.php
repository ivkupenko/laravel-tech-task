<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800">
            Edit Product – {{ $item->product->name }}
        </h2>
    </x-slot>

    <div class="py-10 px-6 flex justify-center">
        <div class="w-full max-w-4xl bg-white p-6 rounded-lg shadow">

            <form method="POST" action="{{ route('admin.carts.updateItem', [$cart, $item]) }}">
                @csrf
                @method('PATCH')

                <table class="min-w-full bg-white border border-gray-200 mb-6">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Quantity</th>
                        <th class="px-4 py-2 text-left">Attributes</th>
                    </tr>
                    </thead>

                    <tbody>
                        <tr class="border-b">
                            <td class="px-4 py-2">
                                {{ $item->product->name }}
                            </td>

                            <td class="px-4 py-2">
                                <input type="number"
                                       class="w-20 border rounded-md p-1"
                                       min="1"
                                       name="items[{{ $item->id }}][quantity]"
                                       value="{{ $item->quantity }}">
                            </td>

                            <td class="px-4 py-2">

                                @php
                                    $groups = $item->product->attributeValues->groupBy(fn($av) => $av->attribute->name);
                                    $selected = $item->attributeValues->pluck('attribute_value_id')->toArray();
                                @endphp

                                @foreach($groups as $attrName => $values)
                                    <div class="mb-2">
                                        <strong>{{ $attrName }}:</strong>

                                        <select name="items[{{ $item->id }}][attributes][]"
                                                class="ml-2 border-gray-300 rounded-md shadow-sm">
                                            @foreach($values as $value)
                                                <option value="{{ $value->id }}"
                                                    {{ in_array($value->id, $selected) ? 'selected' : '' }}>
                                                    {{ $value->value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach

                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-between mt-6">

                    <x-secondary-link-button href="{{ route('admin.carts.show', $cart) }}">
                        Cancel
                    </x-secondary-link-button>

                    <x-primary-button>
                        Save Changes
                    </x-primary-button>

                </div>

            </form>
        </div>
    </div>

</x-app-layout>
