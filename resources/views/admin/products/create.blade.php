<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Create Product') }}
        </h2>
    </x-slot>

    <div class="py-8 flex justify-center">
        <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-3xl">
            <form method="POST" action="{{ route('admin.products.store') }}">
                @csrf

                <div class="mb-6">
                    <x-input-label for="name" :value="__('Product Name')" />
                    <x-text-input id="name" name="name" type="text"
                                  class="mt-1 block w-full"
                                  :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description"
                              name="description"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                              rows="5">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button>
                        {{ __('Create Product') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
