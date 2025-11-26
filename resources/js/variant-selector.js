document.addEventListener("DOMContentLoaded", () => {
    const root = document.getElementById("variant-selector");
    const variants = JSON.parse(root.dataset.variants);

    let selected = {};

    function updateUI() {
        let filtered = variants.filter(v =>
            Object.values(selected).every(val =>
                v.values.some(vv => vv.value_id == val)
            )
        );

        let available = new Set();
        filtered.forEach(variant => {
            variant.values.forEach(vv => {
                if (variant.stock > 0) {
                    available.add(vv.value_id);
                }
            });
        });

        document.querySelectorAll(".value-btn").forEach(btn => {

            let id = parseInt(btn.dataset.valueId);

            if (available.has(id)) {
                btn.disabled = false;
            } else {
                btn.disabled = true;
            }

            let attr = btn.dataset.attributeId;
            if (selected[attr] == id) {
                btn.classList.add("selected");
            } else {
                btn.classList.remove("selected");
            }
        });
    }

    document.querySelectorAll(".value-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            let attr = btn.dataset.attributeId;
            let val = parseInt(btn.dataset.valueId);

            selected[attr] = val;

            updateUI();
        });
    });

    updateUI();
});
