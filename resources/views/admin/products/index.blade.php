<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="min-w-full py-8 px-4 flex flex-col items-center">

        <x-primary-link-button href="{{ route('admin.products.create') }}">{{ __('Add Product') }}
        </x-primary-link-button>

        <br>

        <form method="GET" action="{{ route('admin.products.index') }}" class="mb-6 flex gap-4 items-end">
            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input id="name" name="name" value="{{ request('name') }}"
                              class="mt-1 block h-9" placeholder="Filter by name"/>
            </div>

            <div>
                <x-input-label for="description" :value="__('Description')"/>
                <x-text-input id="description" name="description" value="{{ request('description') }}"
                              class="mt-1 block h-9" placeholder="Filter by description"/>
            </div>

            <x-primary-button class="h-9">{{ __('Filter') }}</x-primary-button>
            <x-secondary-link-button href="{{ route('admin.products.index') }}">{{ __('Reset') }}</x-secondary-link-button>
        </form>


        <div class="bg-white shadow rounded-lg overflow-hidden w-full">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Description</th>
                    <th class="px-4 py-2 text-left">Variants</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ $product->description }}</td>
                        <td class="px-4 py-2">{{ $product->variants->count() }} variants</td>

                        <td class="px-4 py-2 text-center flex gap-2">
                            <x-secondary-link-button href="{{ route('admin.products.show', $product) }}">
                                {{ __('View') }}
                            </x-secondary-link-button>

                            <x-primary-link-button href="{{ route('admin.products.variants.index', $product) }}">
                                {{ __('Manage Variants') }}
                            </x-primary-link-button>
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
