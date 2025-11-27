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
                <div class="mb-4">
                    <x-input-label for="description" :value="__('Description')"/>
                    <textarea id="description" name="description"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                </div>
                <h3 class="font-semibold text-lg mb-3">Attributes and Counts</h3>

                @php $i = 0; @endphp
                @foreach($attributes as $attribute)
                    <div class="mb-6">
                        <p class="font-semibold mb-2">{{ $attribute->name }}</p>

                        <div class="flex flex-wrap gap-3">
                            @foreach($attribute->values as $value)

                                @php
                                    $isSelected = $product->attributeValues->contains($value->id);
                                    $currentCount = $product->attributeValues->find($value->id)->pivot->count ?? '';
                                @endphp

                                <div class="flex items-center space-x-2">

                                    <input type="checkbox"
                                           name="attributes[{{ $i }}][value_id]"
                                           value="{{ $value->id }}"
                                           class="attr-checkbox"
                                        {{ $isSelected ? 'checked' : '' }}>
                                    <span>{{ $value->value }}</span>

                                    <input type="number"
                                           name="attributes[{{ $i }}][count]"
                                           class="attr-count w-24 border rounded-md"
                                           placeholder="Count"
                                           min="0"
                                           value="{{ $currentCount }}"
                                        {{ $isSelected ? '' : 'disabled' }}>
                                </div>

                                @php $i++; @endphp

                            @endforeach
                        </div>
                    </div>
                @endforeach
                <div class="mt-6 flex justify-center gap-4">
                    <x-primary-button>{{ __('Save Changes') }}</x-primary-button>

                    <x-secondary-link-button href="{{ route('admin.products.show', $product) }}">Cancel
                    </x-secondary-link-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.attr-checkbox').forEach(cb => {
            cb.addEventListener('change', function () {
                const countInput = this.parentElement.querySelector('.attr-count');
                if (this.checked) {
                    countInput.disabled = false;
                    if (!countInput.value) countInput.value = 1;
                } else {
                    countInput.disabled = true;
                    countInput.value = '';
                }
            });
        });
    </script>
</x-app-layout>
