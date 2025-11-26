<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-10 flex justify-center">
        <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-3xl">

            <form method="POST" action="{{ route('admin.products.update', $product) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <x-input-label for="name" :value="__('Name')"/>
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                  value="{{ old('name', $product->name) }}" required/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>
                <div class="mb-6">
                    <x-input-label for="description" :value="__('Description')"/>
                    <textarea id="description" name="description"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                </div>

                <div class="flex items-center justify-between border-t pt-6">
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                        <x-secondary-link-button href="{{ route('admin.products.show', $product) }}">
                            Cancel
                        </x-secondary-link-button>
                    </div>

                    <x-primary-button name="redirect_to" value="variants">Manage Variants</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
