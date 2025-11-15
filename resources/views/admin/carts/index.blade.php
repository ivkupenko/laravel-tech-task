<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800">
            All User Carts
        </h2>
    </x-slot>

    <div class="py-8 flex justify-center">
        <div class="w-full max-w-5xl bg-white p-6 shadow rounded">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">User</th>
                    <th class="px-4 py-2 text-left">Items Count</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($carts as $cart)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $cart->user->name }}</td>
                        <td class="px-4 py-2">{{ $cart->items->count() }}</td>
                        <td class="px-4 py-2">
                            <x-primary-link-button href="{{ route('admin.carts.show', $cart) }}">
                                View Cart
                            </x-primary-link-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-center text-gray-500">
                            No carts found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $carts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
