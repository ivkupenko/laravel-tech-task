<script>
    document.addEventListener('DOMContentLoaded', () => {
        const wrapper = document.getElementById('values-wrapper');
        const addBtn = document.getElementById('add-value');

        addBtn.addEventListener('click', () => {
            const row = document.createElement('div');
            row.classList.add('flex', 'gap-2', 'value-row');

            row.innerHTML = `<input type="text" name="values[]" class="w-full border-gray-300 rounded-md shadow-sm">
                    <button type="button" class="remove-value px-3 bg-red-500 text-white rounded-md">✕</button>`;

            wrapper.appendChild(row);

            row.querySelector('.remove-value').addEventListener('click', () => row.remove());
        });

        document.querySelectorAll('.remove-value').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.target.closest('.value-row').remove();
            });
        });
    });
</script>
