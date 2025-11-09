<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    <div class="py-8 flex justify-center">
        <form method="POST" action="{{ route('products.store') }}"
              class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md space-y-4">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input id="name" name="name" type="text"
                              class="mt-1 block w-full" :value="old('name')" required/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="description" :value="__('Description')"/>
                <textarea id="description" name="description"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="count" :value="__('Count')"/>
                <x-text-input id="count" name="count" type="number" min="0"
                              class="mt-1 block w-full" :value="old('count')" required/>
                <x-input-error :messages="$errors->get('count')" class="mt-2"/>
            </div>

            <div class="flex justify-end">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
