<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 text-center">
            {{ __('Create Attribute') }}
        </h2>
    </x-slot>

    <div class="py-10 flex justify-center">
        <div class="bg-white shadow rounded-lg p-6 w-full max-w-3xl">

            <form method="POST" action="{{ route('admin.products.attributes.store') }}">
                @csrf

                <div class="mb-4">
                    <x-input-label for="name" :value="'Attribute Name'"/>
                    <x-text-input id="name" name="name" type="text"
                                  class="mt-1 block w-full"
                                  value="{{ old('name') }}" required/>
                </div>

                <div class="mb-4">
                    <x-input-label value="Attribute Values"/>

                    <div id="values-wrapper" class="space-y-2">
                        <div class="flex gap-2 value-row">
                            <x-text-input type="text" name="values[]" class="w-full"/>
                            <button type="button" class="remove-value px-3 bg-red-500 text-white rounded-md">
                                ✕
                            </button>
                        </div>
                    </div>


                    <button type="button" id="add-value"
                            class="mt-3 px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                        + Add new value
                    </button>
                </div>

                <div class="mt-6 flex justify-center gap-4">
                    <x-primary-button>Create</x-primary-button>

                    <x-secondary-link-button
                        href="{{ route('admin.products.attributes.index') }}">
                        Cancel
                    </x-secondary-link-button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>

@include('components.scripts.attribute-value-add');
