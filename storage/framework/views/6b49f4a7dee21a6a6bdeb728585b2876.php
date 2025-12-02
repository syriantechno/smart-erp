<?php if (isset($component)) { $__componentOriginal8ffb2951ef6cc6f4f3162130bd0a3e82 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ffb2951ef6cc6f4f3162130bd0a3e82 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.form','data' => ['id' => 'edit-inventory-modal','title' => 'Adjust Inventory','size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'edit-inventory-modal','title' => 'Adjust Inventory','size' => 'md']); ?>
    <form id="edit-inventory-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" id="edit-inventory-id" name="id">

        <div class="space-y-4">
            <div class="rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-3">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-[0.18em] mb-1">Material</p>
                <p id="edit-inventory-material-name" class="text-sm font-semibold text-slate-800">—</p>
                <p id="edit-inventory-warehouse-name" class="text-xs text-slate-500">—</p>
            </div>

            <div class="grid grid-cols-12 gap-3">
                <div class="col-span-12 sm:col-span-6">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'edit-inventory-quantity']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'edit-inventory-quantity']); ?>Quantity <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                    <div class="flex rounded-lg border border-slate-200 overflow-hidden">
                        <button type="button" id="edit-inventory-qty-minus" class="w-10 flex items-center justify-center text-slate-500 hover:bg-slate-50 text-sm">-</button>
                        <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'edit-inventory-quantity','name' => 'quantity','type' => 'number','step' => '0.0001','min' => '0','class' => 'w-full border-0 focus:ring-0 text-right','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'edit-inventory-quantity','name' => 'quantity','type' => 'number','step' => '0.0001','min' => '0','class' => 'w-full border-0 focus:ring-0 text-right','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                        <button type="button" id="edit-inventory-qty-plus" class="w-10 flex items-center justify-center text-slate-500 hover:bg-slate-50 text-sm">+</button>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => ['for' => 'edit-inventory-unit-price']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'edit-inventory-unit-price']); ?>Unit Price <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'edit-inventory-unit-price','name' => 'unit_price','type' => 'number','step' => '0.01','min' => '0','class' => 'w-full','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'edit-inventory-unit-price','name' => 'unit_price','type' => 'number','step' => '0.01','min' => '0','class' => 'w-full','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                </div>
            </div>
        </div>
    </form>

    <?php $__env->slot('footer'); ?>
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button
                type="button"
                class="btn-royal btn-royal--outline group"
                data-tw-dismiss="modal"
            >
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'x-circle','class' => 'w-5 h-5 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'x-circle','class' => 'w-5 h-5 icon-hover-rise']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                Cancel
            </button>
            <button
                type="submit"
                form="edit-inventory-form"
                id="edit-inventory-submit"
                class="btn-royal btn-royal--gold group"
            >
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'save','class' => 'w-5 h-5 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'save','class' => 'w-5 h-5 icon-hover-rise']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                Save Changes
            </button>
        </div>
    <?php $__env->endSlot(); ?>

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

                $.get('<?php echo e(route("warehouse.inventory.show", ':id')); ?>'.replace(':id', id))
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
                    url: '<?php echo e(route("warehouse.inventory.update", ':id')); ?>'.replace(':id', inventoryId),
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ffb2951ef6cc6f4f3162130bd0a3e82)): ?>
<?php $attributes = $__attributesOriginal8ffb2951ef6cc6f4f3162130bd0a3e82; ?>
<?php unset($__attributesOriginal8ffb2951ef6cc6f4f3162130bd0a3e82); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ffb2951ef6cc6f4f3162130bd0a3e82)): ?>
<?php $component = $__componentOriginal8ffb2951ef6cc6f4f3162130bd0a3e82; ?>
<?php unset($__componentOriginal8ffb2951ef6cc6f4f3162130bd0a3e82); ?>
<?php endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/warehouse/inventory/modals/edit.blade.php ENDPATH**/ ?>