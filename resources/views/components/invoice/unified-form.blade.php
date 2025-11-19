<!-- Unified Invoice Form Component -->
@props([
    'id' => 'unified-invoice-modal',
    'title' => 'Create Invoice',
    'type' => 'purchase_order', // purchase_order, sale_order, delivery_order
    'suppliers' => [],
    'customers' => [],
    'materials' => [],
    'warehouses' => []
])

<x-modal.form :id="$id" :title="$title" size="full">
    <form :id="$id . '-form'">
        @csrf
        
        <!-- Invoice Header -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="file-text" class="h-5 w-5"></x-base.lucide>
                Invoice Information
            </h4>
            
            <div class="grid grid-cols-12 gap-4">
                <!-- Code -->
                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="{{ $id }}-code">Code</x-base.form-label>
                    <div class="flex gap-2">
                        <x-base.form-input
                            id="{{ $id }}-code"
                            name="code"
                            type="text"
                            class="flex-1"
                            placeholder="Auto-generated"
                            readonly
                        />
                        <button
                            type="button"
                            class="btn-tonal btn-tonal--info btn-tonal--icon"
                            onclick="refreshInvoiceCode('{{ $type }}')"
                            title="Refresh Code"
                        >
                            <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                        </button>
                    </div>
                </div>
                
                <!-- Title -->
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="{{ $id }}-title">Title</x-base.form-label>
                    <x-base.form-input
                        id="{{ $id }}-title"
                        name="title"
                        type="text"
                        placeholder="Invoice title"
                        required
                    />
                </div>
                
                <!-- Date -->
                <div class="col-span-12 md:col-span-2">
                    <x-base.form-label for="{{ $id }}-date">Date</x-base.form-label>
                    <x-base.form-input
                        id="{{ $id }}-date"
                        name="order_date"
                        type="date"
                        value="{{ date('Y-m-d') }}"
                        required
                    />
                </div>
                
                <!-- Status -->
                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="{{ $id }}-status">Status</x-base.form-label>
                    <x-base.form-select id="{{ $id }}-status" name="status">
                        <option value="draft">Draft</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                    </x-base.form-select>
                </div>
            </div>
        </div>

        <!-- Party Information -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="users" class="h-5 w-5"></x-base.lucide>
                @if($type === 'purchase_order')
                    Supplier Information
                @else
                    Customer Information
                @endif
            </h4>
            
            <div class="grid grid-cols-12 gap-4">
                @if($type === 'purchase_order')
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="{{ $id }}-supplier">Supplier</x-base.form-label>
                        <x-base.form-select id="{{ $id }}-supplier" name="supplier_id">
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                @else
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="{{ $id }}-customer">Customer</x-base.form-label>
                        <x-base.form-select id="{{ $id }}-customer" name="customer_id">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                @endif
                
                @if(in_array($type, ['sale_order', 'delivery_order']))
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="{{ $id }}-warehouse">Warehouse</x-base.form-label>
                        <x-base.form-select id="{{ $id }}-warehouse" name="warehouse_id">
                            <option value="">Select Warehouse</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                @endif
            </div>
        </div>

        <!-- Materials Section -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white flex items-center gap-2">
                    <x-base.lucide icon="package" class="h-5 w-5"></x-base.lucide>
                    Materials
                </h4>
                <button
                    type="button"
                    class="btn-tonal btn-tonal--success"
                    onclick="addMaterialRow('{{ $id }}')"
                >
                    <x-base.lucide icon="plus" class="w-4 h-4 mr-2" />
                    Add Material
                </button>
            </div>
            
            <!-- Materials Table -->
            <div class="overflow-x-auto">
                <table class="table table-bordered" id="{{ $id }}-materials-table">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-darkmode-800">
                            <th class="w-8">#</th>
                            <th class="min-w-[200px]">Material</th>
                            <th class="w-24">Unit</th>
                            <th class="w-32">Quantity</th>
                            <th class="w-32">Unit Price</th>
                            <th class="w-32">Total</th>
                            <th class="w-16">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="{{ $id }}-materials-tbody">
                        <!-- Material rows will be added here -->
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-100 dark:bg-darkmode-700 font-semibold">
                            <td colspan="5" class="text-right">Total Amount:</td>
                            <td id="{{ $id }}-total-amount">$0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Notes -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="file-text" class="h-5 w-5"></x-base.lucide>
                Additional Information
            </h4>
            
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-base.form-label for="{{ $id }}-description">Description</x-base.form-label>
                    <x-base.form-textarea
                        id="{{ $id }}-description"
                        name="description"
                        rows="3"
                        placeholder="Additional notes or description"
                    ></x-base.form-textarea>
                </div>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <div class="flex justify-end gap-2 w-full">
            <button
                class="btn-tonal btn-tonal--warning"
                data-tw-dismiss="modal"
                type="button"
            >
                Cancel
            </button>
            <button
                class="btn-tonal btn-tonal--success"
                type="submit"
                form="{{ $id }}-form"
            >
                <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                Save {{ ucfirst(str_replace('_', ' ', $type)) }}
            </button>
        </div>
    </x-slot>
</x-modal.form>

<!-- Material Row Template -->
<template id="{{ $id }}-material-row-template">
    <tr class="material-row">
        <td class="text-center row-number">1</td>
        <td>
            <select class="form-select material-select w-full" name="materials[INDEX][material_id]" required>
                <option value="">Select Material</option>
                @foreach($materials as $material)
                    <option value="{{ $material->id }}" data-unit="{{ $material->unit }}" data-price="{{ $material->price }}">
                        {{ $material->name }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" class="form-input unit-display w-full" readonly placeholder="Unit">
        </td>
        <td>
            <input type="number" class="form-input quantity-input w-full" name="materials[INDEX][quantity]" 
                   min="1" step="0.01" placeholder="0" required>
        </td>
        <td>
            <input type="number" class="form-input price-input w-full" name="materials[INDEX][unit_price]" 
                   min="0" step="0.01" placeholder="0.00" required>
        </td>
        <td>
            <input type="text" class="form-input total-display w-full" readonly placeholder="0.00">
        </td>
        <td class="text-center">
            <button type="button" class="btn-tonal btn-tonal--danger btn-tonal--icon remove-row" title="Remove">
                <x-base.lucide icon="trash-2" class="w-4 h-4" />
            </button>
        </td>
    </tr>
</template>

<script>
// Unified Invoice JavaScript
let materialRowIndex = 0;

function addMaterialRow(modalId) {
    const template = document.getElementById(modalId + '-material-row-template');
    const tbody = document.getElementById(modalId + '-materials-tbody');
    
    if (template && tbody) {
        const clone = template.content.cloneNode(true);
        
        // Replace INDEX with actual index
        const html = clone.querySelector('tr').outerHTML.replace(/INDEX/g, materialRowIndex);
        tbody.insertAdjacentHTML('beforeend', html);
        
        // Update row numbers
        updateRowNumbers(modalId);
        
        // Add event listeners to new row
        setupRowEventListeners(modalId, materialRowIndex);
        
        materialRowIndex++;
    }
}

function setupRowEventListeners(modalId, index) {
    const row = document.querySelector(`#${modalId}-materials-tbody tr:last-child`);
    if (!row) return;
    
    // Material selection
    const materialSelect = row.querySelector('.material-select');
    materialSelect.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const unitDisplay = row.querySelector('.unit-display');
        const priceInput = row.querySelector('.price-input');
        
        if (option.value) {
            unitDisplay.value = option.dataset.unit || '';
            priceInput.value = option.dataset.price || '0.00';
            calculateRowTotal(row);
        }
    });
    
    // Quantity and price changes
    const quantityInput = row.querySelector('.quantity-input');
    const priceInput = row.querySelector('.price-input');
    
    [quantityInput, priceInput].forEach(input => {
        input.addEventListener('input', () => calculateRowTotal(row));
    });
    
    // Remove row
    const removeBtn = row.querySelector('.remove-row');
    removeBtn.addEventListener('click', function() {
        row.remove();
        updateRowNumbers(modalId);
        calculateGrandTotal(modalId);
    });
}

function calculateRowTotal(row) {
    const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    const total = quantity * price;
    
    row.querySelector('.total-display').value = total.toFixed(2);
    
    // Update grand total
    const modalId = row.closest('[id$="-materials-table"]').id.replace('-materials-table', '');
    calculateGrandTotal(modalId);
}

function calculateGrandTotal(modalId) {
    const rows = document.querySelectorAll(`#${modalId}-materials-tbody .material-row`);
    let grandTotal = 0;
    
    rows.forEach(row => {
        const total = parseFloat(row.querySelector('.total-display').value) || 0;
        grandTotal += total;
    });
    
    document.getElementById(modalId + '-total-amount').textContent = '$' + grandTotal.toFixed(2);
}

function updateRowNumbers(modalId) {
    const rows = document.querySelectorAll(`#${modalId}-materials-tbody .material-row`);
    rows.forEach((row, index) => {
        row.querySelector('.row-number').textContent = index + 1;
    });
}

function refreshInvoiceCode(type) {
    // Implementation for refreshing invoice code
    console.log('Refreshing code for:', type);
}

// Initialize when modal opens
document.addEventListener('DOMContentLoaded', function() {
    // Add initial row when modal opens
    const modalTriggers = document.querySelectorAll('[data-tw-toggle="modal"]');
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const targetId = this.getAttribute('data-tw-target');
            if (targetId && targetId.includes('invoice')) {
                setTimeout(() => {
                    const modalId = targetId.replace('#', '');
                    addMaterialRow(modalId);
                }, 100);
            }
        });
    });
});
</script>
