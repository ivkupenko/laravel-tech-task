<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 text-center">{{ __('Create Attribute') }}</h2>
    </x-slot>

    <div class="py-10 flex justify-center">
        <div class="bg-white shadow rounded-lg p-6 w-full max-w-3xl">
            <form method="POST"
                  action="{{ route('admin.products.attributes.store') }}">
                @csrf

                <div class="mb-4">
                    <x-input-label for="name" :value="'Attribute Name'"/>
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                  value="{{ old('name', $attribute->name ?? '') }}" required/>
                </div>

                <div class="mb-4">
                    <x-input-label for="values_raw" :value="'Attribute Values (comma separated)'"/>
                    <textarea id="values_raw" name="values_raw"
                              class="block w-full border-gray-300 rounded-md shadow-sm">{{ old('values_raw', '') }}</textarea>
                </div>

                <div class="mt-6 flex justify-center gap-4">
                    <x-primary-button>{{ 'Create' }}</x-primary-button>
                    <x-secondary-link-button href="{{ route('admin.products.attributes.index') }}">Cancel</x-secondary-link-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
