<x-modal.form id="edit-inventory-modal" title="Adjust Inventory" size="md">
    <form id="edit-inventory-form">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit-inventory-id" name="id">

        <div class="space-y-4">
            <div class="rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-3">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-[0.18em] mb-1">Material</p>
                <p id="edit-inventory-material-name" class="text-sm font-semibold text-slate-800">—</p>
                <p id="edit-inventory-warehouse-name" class="text-xs text-slate-500">—</p>
            </div>

            <div class="grid grid-cols-12 gap-3">
                <div class="col-span-12 sm:col-span-6">
                    <x-base.form-label for="edit-inventory-quantity">Quantity</x-base.form-label>
                    <div class="flex rounded-lg border border-slate-200 overflow-hidden">
                        <button type="button" id="edit-inventory-qty-minus" class="w-10 flex items-center justify-center text-slate-500 hover:bg-slate-50 text-sm">-</button>
                        <x-base.form-input
                            id="edit-inventory-quantity"
                            name="quantity"
                            type="number"
                            step="0.0001"
                            min="0"
                            class="w-full border-0 focus:ring-0 text-right"
                            required
                        />
                        <button type="button" id="edit-inventory-qty-plus" class="w-10 flex items-center justify-center text-slate-500 hover:bg-slate-50 text-sm">+</button>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <x-base.form-label for="edit-inventory-unit-price">Unit Price</x-base.form-label>
                    <x-base.form-input
                        id="edit-inventory-unit-price"
                        name="unit_price"
                        type="number"
                        step="0.01"
                        min="0"
                        class="w-full"
                        required
                    />
                </div>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button
                type="button"
                class="btn-royal btn-royal--outline group"
                data-tw-dismiss="modal"
            >
                <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                Cancel
            </button>
            <button
                type="submit"
                form="edit-inventory-form"
                id="edit-inventory-submit"
                class="btn-royal btn-royal--gold group"
            >
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                Save Changes
            </button>
        </div>
    @endslot

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available for edit inventory modal.');
                return;
            }

            const $ = jq;
            const form = document.getElementById('edit-inventory-form');
            const submitBtn = $('#edit-inventory-submit');

            const idInput = document.getElementById('edit-inventory-id');
            const quantityInput = document.getElementById('edit-inventory-quantity');
            const unitPriceInput = document.getElementById('edit-inventory-unit-price');
            const materialNameEl = document.getElementById('edit-inventory-material-name');
            const warehouseNameEl = document.getElementById('edit-inventory-warehouse-name');

            if (!form || !idInput || !quantityInput || !unitPriceInput) {
                return;
            }

            window.editInventory = function (id) {
                if (!id) return;

                $.get('{{ route("warehouse.inventory.show", ':id') }}'.replace(':id', id))
                    .done(function (response) {
                        if (!response.success || !response.inventory) {
                            window.showError && window.showError('Unable to load inventory entry.');
                            return;
                        }

                        const inv = response.inventory;
                        idInput.value = inv.id;
                        quantityInput.value = inv.quantity ?? 0;
                        unitPriceInput.value = inv.unit_price ?? 0;

                        materialNameEl.textContent = inv.material?.name || '—';
                        warehouseNameEl.textContent = inv.warehouse?.name || '—';

                        const modalEl = document.getElementById('edit-inventory-modal');
                        if (modalEl && window.tailwind?.Modal?.getOrCreateInstance) {
                            const instance = window.tailwind.Modal.getOrCreateInstance(modalEl);
                            instance.show();
                        }
                    })
                    .fail(function () {
                        window.showError && window.showError('Failed to load inventory entry.');
                    });
            };

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const inventoryId = idInput.value;
                if (!inventoryId) {
                    window.showError && window.showError('Missing inventory id.');
                    return;
                }

                const formData = new FormData(form);
                const originalHtml = submitBtn.html();

                submitBtn.prop('disabled', true)
                    .html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving...');

                $.ajax({
                    url: '{{ route("warehouse.inventory.update", ':id') }}'.replace(':id', inventoryId),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']")?.getAttribute('content') || ''
                    },
                    success: function (response) {
                        if (response.success) {
                            const modalEl = document.getElementById('edit-inventory-modal');
                            if (modalEl && window.tailwind?.Modal?.getOrCreateInstance) {
                                const instance = window.tailwind.Modal.getOrCreateInstance(modalEl);
                                instance.hide();
                            }

                            if (window.inventoryTable) {
                                window.inventoryTable.ajax.reload();
                            }

                            window.showSuccess && window.showSuccess(response.message || 'Inventory updated successfully');
                        } else if (response.errors) {
                            const messages = Object.values(response.errors).flat().join('\n');
                            window.showError && window.showError(messages || 'Failed to update inventory.');
                        } else {
                            window.showError && window.showError(response.message || 'Failed to update inventory.');
                        }
                    },
                    error: function (xhr) {
                        let message = 'An error occurred while updating inventory.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        window.showError && window.showError(message);
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).html(originalHtml);
                        if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                            lucide.createIcons();
                        }
                    }
                });
            });
        });
    </script>
</x-modal.form>
