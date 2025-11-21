<script>
    document.addEventListener('DOMContentLoaded', function () {
        const attributes = @json($attributes ?? []);

        const nameSelect = document.getElementById('attribute_name');
        const valueSelect = document.getElementById('attribute_value');

        if (!nameSelect || !valueSelect) return;

        nameSelect.addEventListener('change', function () {
            const attributeId = this.value;

            valueSelect.innerHTML = '<option value="">Select Value</option>';

            if (!attributeId) return;

            const selected = attributes.find(a => a.id == attributeId);

            selected.values.forEach(v => {
                valueSelect.innerHTML += `<option value="${v.id}">${v.value}</option>`;
            });
        });
    });
</script>
