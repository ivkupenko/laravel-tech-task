<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800">
            Cart of {{ $cart->user->name }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 flex justify-center">
        <div class="w-full max-w-4xl bg-white p-6 shadow rounded">

            <table class="min-w-full border border-gray-200 mb-6">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Product</th>
                    <th class="px-4 py-2 text-left">Quantity</th>
                    <th class="px-4 py-2 text-left">Attributes</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($cart->items as $item)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $item->product->name }}</td>
                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                        <td class="px-4 py-2">
                            @if($item->attributeValues->isEmpty())
                                <span class="text-gray-500">—</span>
                            @else
                                @foreach($item->attributeValues as $av)
                                    <div>
                                        <strong>{{ $av->attributeValue->attribute->name }}:</strong>
                                        {{ $av->attributeValue->value }}
                                    </div>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="flex justify-between">
                <x-secondary-link-button href="{{ route('admin.carts.index') }}">
                    Back to carts list
                </x-secondary-link-button>

                <x-primary-link-button href="{{ route('admin.carts.edit', $cart) }}">
                    Edit cart
                </x-primary-link-button>
            </div>
        </div>
    </div>
</x-app-layout>
