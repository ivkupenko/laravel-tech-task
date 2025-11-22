<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    <div class="py-8 flex justify-center">
        <div class="bg-white shadow-md rounded-lg p-6 min-w-full max-w-3xl">
            <form method="POST" action="{{ route('admin.products.store') }}">
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

                <h3 class="font-semibold text-lg mb-3">Attributes and Counts</h3>

                @php $i = 0; @endphp
                @foreach($attributes as $attribute)
                    <div class="mb-6">
                        <p class="font-semibold text-gray-800 mb-2">{{ $attribute->name }}</p>

                        <div class="flex flex-wrap gap-3">

                            @foreach($attribute->values as $value)
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox"
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                           data-index="{{ $i }}"
                                           value="{{ $value->id }}"
                                           onchange="toggleAttributeRow(this)">
                                    <span>{{ $value->value }}</span>

                                    <input type="hidden"
                                           name="attributes[{{ $i }}][value_id]"
                                           class="value-id-input"
                                           value=""
                                           disabled>

                                    <input type="number"
                                           name="attributes[{{ $i }}][count]"
                                           class="w-24 border-gray-300 rounded-md count-input"
                                           min="0"
                                           placeholder="Count"
                                           disabled>

                                </div>

                                @php $i++; @endphp
                            @endforeach

                        </div>
                    </div>
                @endforeach

                <div class="flex justify-end">
                    <x-primary-button>{{ __('Create') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleAttributeRow(checkbox) {
            let valueInput = checkbox.closest('div').querySelector('.value-id-input');
            let countInput = checkbox.closest('div').querySelector('.count-input');

            if (checkbox.checked) {
                valueInput.value = checkbox.value;
                valueInput.disabled = false;
                countInput.disabled = false;
            } else {
                valueInput.value = "";
                valueInput.disabled = true;
                countInput.disabled = true;
            }
        }
    </script>

</x-app-layout>
