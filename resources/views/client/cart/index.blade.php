<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-center">Your Cart</h2>
    </x-slot>

    <div class="py-10 flex justify-center">
        <div class="w-full max-w-3xl bg-white p-6 rounded-lg shadow">

            @if($cart->items->isEmpty())
                <p class="text-center text-gray-500">Your cart is empty.</p>
            @else
                <table class="w-full">
                    <thead>
                    <tr class="border-b">
                        <th class="py-2">Product</th>
                        <th class="py-2">Quantity</th>
                        <th class="py-2">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($cart->items as $item)
                        <tr class="border-b text-center">
                            <td>{{ $item->product->name }}</td>
                            <td class="text-center">
                                <form action="{{ route('client.cart.update', $item) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <x-text-input
                                        type="number" name="quantity" value="{{ $item->quantity }}"
                                        min="1" class="w-16 text-center border border-gray-300 rounded-md"
                                        onchange="this.form.submit()"/>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('client.cart.remove', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>Remove</x-danger-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
</x-app-layout>
