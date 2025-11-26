<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-center">
            Select Attributes for {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-10 flex justify-center">
        <div class="w-full max-w-3xl bg-white p-6 rounded-lg shadow">

            <form id="variant-form" method="POST" action="{{ route('client.cart.addWithAttributes', $product) }}">
                @csrf
                
                <div id="attribute-selectors" class="space-y-4 mb-6">
                    <!-- Attributes will be dynamically inserted here -->
                </div>

                <div class="flex justify-between items-center mt-6">
                    <x-secondary-link-button href="{{ route('client.products.index') }}">
                        Back to products
                    </x-secondary-link-button>
                    <x-primary-button id="add-to-cart-btn" type="submit" disabled>
                        Add to Cart
                    </x-primary-button>
                </div>
            </form>

            <script>
                const variants = @json($variants);
                const attributes = @json($attributes);
                
                let selectedValues = {};

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
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            ${attribute.name}
                        </label>
                        <div class="flex flex-wrap gap-2">
                            ${availableValues.map(value => `
                                <button type="button" 
                                        class="attribute-btn px-4 py-2 border rounded-md transition-colors
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
                }

                function getAvailableValues(attributeId) {
                    const attribute = attributes.find(a => a.id === attributeId);
                    if (!attribute) return [];

                    if (Object.keys(selectedValues).length === 0) {
                        return attribute.values;
                    }

                    const matchingVariants = variants.filter(variant => {
                        return Object.entries(selectedValues).every(([attrId, valueId]) => {
                            return variant.attribute_values.includes(parseInt(valueId));
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
                            btn.className = 'attribute-btn px-4 py-2 border rounded-md transition-colors bg-blue-600 text-white border-blue-600';
                        } else {
                            btn.className = 'attribute-btn px-4 py-2 border rounded-md transition-colors bg-white text-gray-700 border-gray-300 hover:bg-gray-50';
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

                    if (matchingVariant && matchingVariant.stock > 0) {
                        showVariantInfo(matchingVariant);
                    } else {
                        hideVariantInfo();
                    }
                }

                function showVariantInfo(variant) {
                    document.getElementById('add-to-cart-btn').disabled = false;
                }

                function hideVariantInfo() {
                    document.getElementById('add-to-cart-btn').disabled = true;
                }

                if (attributes.length > 0) {
                    renderAttribute(0);
                }

                document.getElementById('variant-form').addEventListener('submit', function(e) {
                    Object.entries(selectedValues).forEach(([attrId, valueId]) => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `attributes[${attrId}]`;
                        input.value = valueId;
                        this.appendChild(input);
                    });
                });
            </script>

        </div>
    </div>
</x-app-layout>
