<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800">
            Edit cart item – {{ $item->product->name }}
        </h2>
    </x-slot>

    <div class="py-10 px-6 flex justify-center">
        <div class="w-full max-w-4xl bg-white p-6 rounded-lg shadow">

            <form id="edit-item-form" method="POST" action="{{ route('admin.carts.updateItem', [$cart, $item]) }}">
                @csrf
                @method('PATCH')

                <table class="min-w-full bg-white border border-gray-200 mb-6">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Quantity</th>
                        <th class="px-4 py-2 text-left">Attributes</th>
                    </tr>
                    </thead>

                    <tbody>
                        <tr class="border-b">
                            <td class="px-4 py-2">
                                {{ $item->product->name }}
                            </td>

                            <td class="px-4 py-2">
                                <input type="number"
                                       class="w-20 border rounded-md p-1"
                                       min="1"
                                       name="items[{{ $item->id }}][quantity]"
                                       value="{{ $item->quantity }}">
                            </td>

                            <td class="px-4 py-2">
                                <div id="attribute-selectors" class="space-y-4">
                                    <!-- Attributes will be dynamically inserted here -->
                                </div>
                                <div id="variant-info" class="mt-4 hidden text-sm text-gray-600">
                                    SKU: <span id="selected-sku" class="font-mono font-bold"></span> | 
                                    Stock: <span id="selected-stock" class="font-bold"></span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-between mt-6">

                    <x-secondary-link-button href="{{ route('admin.carts.show', $cart) }}">
                        Cancel
                    </x-secondary-link-button>

                    <x-primary-button id="save-btn" disabled>
                        Save Changes
                    </x-primary-button>

                </div>

            </form>
        </div>
    </div>

    <script>
        const variants = @json($variants);
        const attributes = @json($attributes);
        const initialSelected = @json($selected);
        
        let selectedValues = {};

        if (initialSelected && initialSelected.length > 0) {
            attributes.forEach(attr => {
                const foundValue = attr.values.find(v => initialSelected.includes(v.id));
                if (foundValue) {
                    selectedValues[attr.id] = foundValue.id;
                }
            });
        }

        function renderAttribute(index) {
            if (index >= attributes.length) {
                findMatchingVariant();
                return;
            }

            const attribute = attributes[index];
            const container = document.getElementById('attribute-selectors');
            
            const availableValues = getAvailableValues(attribute.id);
            
            if (availableValues.length === 0) {
                renderAttribute(index + 1);
                return;
            }

            const attributeDiv = document.createElement('div');
            attributeDiv.id = `attribute-${attribute.id}`;
            attributeDiv.innerHTML = `
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    ${attribute.name}
                </label>
                <div class="flex flex-wrap gap-2">
                    ${availableValues.map(value => `
                        <button type="button" 
                                class="attribute-btn px-3 py-1 border rounded-md text-sm transition-colors
                                       ${selectedValues[attribute.id] === value.id 
                                           ? 'bg-blue-600 text-white border-blue-600' 
                                           : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'}"
                                data-attribute-id="${attribute.id}"
                                data-value-id="${value.id}"
                                onclick="selectValue(${attribute.id}, ${value.id})">
                            ${value.value}
                        </button>
                    `).join('')}
                </div>
            `;
            
            container.appendChild(attributeDiv);
            
            if (selectedValues[attribute.id]) {
                renderAttribute(index + 1);
            }
        }

        function getAvailableValues(attributeId) {
            const attribute = attributes.find(a => a.id === attributeId);
            if (!attribute) return [];

            const currentIndex = attributes.findIndex(a => a.id === attributeId);
            const previousAttributes = attributes.slice(0, currentIndex);
            
            const matchingVariants = variants.filter(variant => {
                return previousAttributes.every(prevAttr => {
                    const prevValueId = selectedValues[prevAttr.id];
                    if (!prevValueId) return true; 
                    return variant.attribute_values.includes(parseInt(prevValueId));
                });
            });

            const availableValueIds = new Set();
            matchingVariants.forEach(variant => {
                variant.attribute_values.forEach(valueId => {
                    const value = attribute.values.find(v => v.id === valueId);
                    if (value) {
                        availableValueIds.add(valueId);
                    }
                });
            });

            return attribute.values.filter(v => availableValueIds.has(v.id));
        }

        function selectValue(attributeId, valueId) {
            selectedValues[attributeId] = valueId;
            
            const currentIndex = attributes.findIndex(a => a.id === attributeId);
            for (let i = currentIndex + 1; i < attributes.length; i++) {
                const attrDiv = document.getElementById(`attribute-${attributes[i].id}`);
                if (attrDiv) {
                    attrDiv.remove();
                }
                delete selectedValues[attributes[i].id];
            }

            document.querySelectorAll(`[data-attribute-id="${attributeId}"]`).forEach(btn => {
                if (parseInt(btn.dataset.valueId) === valueId) {
                    btn.className = 'attribute-btn px-3 py-1 border rounded-md text-sm transition-colors bg-blue-600 text-white border-blue-600';
                } else {
                    btn.className = 'attribute-btn px-3 py-1 border rounded-md text-sm transition-colors bg-white text-gray-700 border-gray-300 hover:bg-gray-50';
                }
            });

            renderAttribute(currentIndex + 1);
            
            findMatchingVariant();
        }

        function findMatchingVariant() {
           
            const selectedCount = Object.keys(selectedValues).length;
            
            if (selectedCount === 0) {
                hideVariantInfo();
                return;
            }

            const matchingVariant = variants.find(variant => {
                if (variant.attribute_values.length !== selectedCount) {
                    return false;
                }
                return Object.values(selectedValues).every(valueId => {
                    return variant.attribute_values.includes(parseInt(valueId));
                });
            });
            
            if (matchingVariant) {
                showVariantInfo(matchingVariant);
            } else {
                hideVariantInfo();
            }
        }

        function showVariantInfo(variant) {
            document.getElementById('selected-sku').textContent = variant.sku;
            document.getElementById('selected-stock').textContent = variant.stock;
            document.getElementById('variant-info').classList.remove('hidden');
            document.getElementById('save-btn').disabled = false;
        }

        function hideVariantInfo() {
            document.getElementById('variant-info').classList.add('hidden');
            document.getElementById('save-btn').disabled = true;
        }

        if (attributes.length > 0) {
            renderAttribute(0);
            findMatchingVariant();
        }

        document.getElementById('edit-item-form').addEventListener('submit', function(e) {
            Object.entries(selectedValues).forEach(([attrId, valueId]) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `items[{{ $item->id }}][attributes][]`;
                input.value = valueId;
                this.appendChild(input);
            });
        });
    </script>

</x-app-layout>
