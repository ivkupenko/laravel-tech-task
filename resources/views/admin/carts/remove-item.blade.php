<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-red-600">
            Remove Items from Cart – {{ $cart->user->name }}
        </h2>
    </x-slot>

    <div class="py-10 px-6 flex justify-center">
        <div class="w-full max-w-3xl bg-white p-6 rounded-lg shadow">

            <form method="POST" action="{{ route('admin.carts.removeItems', $cart) }}">
                @csrf
                @method('DELETE')

                <table class="min-w-full bg-white border border-gray-200 mb-6">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 w-16"></th>
                        <th class="px-4 py-2 text-left">Product name</th>
                        <th class="px-4 py-2 text-left">Product description</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($cart->items as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2 text-center">
                                <input type="checkbox" name="items[]" value="{{ $item->id }}">
                            </td>

                            <td class="px-4 py-2">{{ $item->product->name }}</td>
                            <td class="px-4 py-2">{{ $item->product->description }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="flex justify-between mt-6">
                    <x-secondary-link-button href="{{ route('admin.carts.edit', $cart) }}">
                        Cancel
                    </x-secondary-link-button>

                    <x-danger-button type="submit">
                        Remove Selected Items
                    </x-danger-button>
                </div>
            </form>

        </div>
    </div>

</x-app-layout>
