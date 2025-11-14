<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="min-w-full py-8 px-4 flex flex-col items-center">
        <form method="GET" action="{{ route('client.products.index') }}" class="mb-6 flex flex-wrap gap-6 items-end">
            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input id="name" name="name" type="text"
                              value="{{ request('name') }}"
                              class="mt-1 block h-9"/>
            </div>

            <div>
                <x-input-label for="description" :value="__('Description')"/>
                <x-text-input id="description" name="description" type="text"
                              value="{{ request('description') }}"
                              class="mt-1 block h-9"/>
            </div>

            <div class="flex gap-2 items-end">
                <div>
                    <x-input-label for="count_from" :value="__('Count From')"/>
                    <x-text-input id="count_from" name="count_from" type="number"
                                  value="{{ request('count_from') }}"
                                  class="mt-1 block w-24 h-9"/>
                </div>

                <div>
                    <x-input-label for="count_to" :value="__('Count To')"/>
                    <x-text-input id="count_to" name="count_to" type="number"
                                  value="{{ request('count_to') }}"
                                  class="mt-1 block w-24 h-9"/>
                </div>
            </div>

            <div class="flex gap-2 mt-1">
                <x-primary-button class="h-9">{{ __('Filter') }}</x-primary-button>
                <x-secondary-link-button
                    href="{{ route('client.products.index') }}">{{ __('Reset') }}</x-secondary-link-button>
            </div>
        </form>


        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Description</th>
                    <th class="px-4 py-2 text-left">Count</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ $product->description }}</td>
                        <td class="px-4 py-2">{{ $product->count }}</td>

                        <td class="px-4 py-2 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <x-primary-link-button href="{{ route('client.products.show', $product) }}">View
                                </x-primary-link-button>

                                <form method="POST" action="{{ route('client.cart.add', $product) }}">
                                    @csrf
                                    @method('POST')
                                    <x-secondary-button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor"
                                             class="bi bi-cart" viewBox="0 0 16 16">
                                            <path
                                                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                        </svg>
                                    </x-secondary-button>
                                </form>
                            </div>
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
