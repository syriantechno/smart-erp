@php
    $codeGenerator = app(\App\Services\DocumentCodeGenerator::class);
    $generatedCode = $codeGenerator->generate('purchase_orders');
@endphp

<x-modal.form id="create-po-modal" title="Add New Purchase Order" size="5xl">
    <form id="create-po-form" action="{{ route('warehouse.purchase-orders.store') }}" method="POST">
        @csrf

        <!-- Purchase Order Information Section -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="file-text" class="h-5 w-5"></x-base.lucide>
                Purchase Order Information
            </h4>
            
            <div class="flex flex-wrap gap-4 gap-y-4">
                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="create-po-code">Code</x-base.form-label>
                    <div class="flex gap-2">
                        <x-base.form-input
                            id="create-po-code"
                            name="code"
                            type="text"
                            class="flex-1"
                            value="{{ old('code', $generatedCode) }}"
                            readonly
                        />
                        <button
                            type="button"
                            class="btn-tonal btn-tonal--info "
                            onclick="refreshPurchaseOrderCode()"
                            title="Refresh Code"
                        >
                            <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                        </button>
                    </div>
                </div>

                <div class="w-full md:w-1/3 lg:w-2/6">
                    <x-base.form-label for="create-po-title">Title <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input
                        id="create-po-title"
                        name="title"
                        type="text"
                        placeholder="Enter purchase order title"
                        class="w-full"
                        required
                    />
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="create-po-date">Order Date <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input
                        id="create-po-date"
                        name="order_date"
                        type="date"
                        value="{{ date('Y-m-d') }}"
                        class="w-full"
                        required
                    />
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="create-po-status">Status</x-base.form-label>
                    <x-base.form-select id="create-po-status" name="status" class="w-full">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </x-base.form-select>
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="create-po-delivery-date">Expected Delivery</x-base.form-label>
                    <x-base.form-input
                        id="create-po-delivery-date"
                        name="expected_delivery_date"
                        type="date"
                        class="w-full"
                    />
                </div>

                <div class="w-full md:w-1/3 lg:w-1/6">
                    <x-base.form-label for="create-po-amount">Total Amount <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input
                        id="create-po-amount"
                        name="total_amount"
                        type="number"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        class="w-full"
                        required
                    />
                </div>
            </div>
        </div>

        <!-- Supplier Information Section -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="building" class="h-5 w-5"></x-base.lucide>
                Supplier Information
            </h4>
            
            <div class="flex flex-wrap gap-4 gap-y-4">
                <div class="w-full md:w-1/2">
                    <x-base.form-label for="create-po-supplier">Supplier</x-base.form-label>
                    <x-base.form-select id="create-po-supplier" name="supplier_id" class="w-full">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers ?? [] as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="w-full md:w-1/2">
                    <label class="flex items-center mt-6">
                        <x-base.form-check.input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            checked
                        />
                        <span class="ml-2">Active</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Description Section -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="file-text" class="h-5 w-5"></x-base.lucide>
                Additional Information
            </h4>
            
            <div class="w-full">
                <x-base.form-label for="create-po-description">Description</x-base.form-label>
                <x-base.form-textarea
                    id="create-po-description"
                    name="description"
                    rows="3"
                    placeholder="Enter purchase order description"
                    class="w-full"
                ></x-base.form-textarea>
            </div>
        </div>

        <!-- Materials Section (Optional for future enhancement) -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="package" class="h-5 w-5"></x-base.lucide>
                Materials
                <span class="text-sm text-slate-500 font-normal">(Optional - can be added after creation)</span>
            </h4>
            
            <div class="bg-slate-50 dark:bg-darkmode-800 rounded-lg p-4 text-center">
                <x-base.lucide icon="info" class="h-8 w-8 mx-auto text-slate-400 mb-2"></x-base.lucide>
                <p class="text-slate-600 dark:text-slate-400">
                    Materials can be added after creating the purchase order using the unified invoice system.
                </p>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button
                type="button"
                class="btn-tonal btn-tonal--neutral group"
                data-tw-dismiss="modal"
            >
                <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                Cancel
            </button>
            <button
                type="submit"
                form="create-po-form"
                id="create-po-btn"
                class="btn-tonal btn-tonal--success group"
            >
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                Save
            </button>
        </div>
    @endslot

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('🔧 Initializing Purchase Order modal...');
            
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available for create purchase order modal.');
                return;
            }

            const $ = jq;
            
            // Wait for modal to be ready
            setTimeout(() => {
                const form = document.getElementById('create-po-form');
                const submitBtn = $('#create-po-btn');

                if (!form) {
                    console.warn('Purchase order form not found');
                    return;
                }
                
                console.log('✅ Purchase order form found');
                
                // Add CSRF token setup
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving...');

                $.ajax({
                    url: '{{ route("warehouse.purchase-orders.store") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log('✅ Purchase order created successfully');
                            
                            // Close modal safely
                            try {
                                const modalElement = document.getElementById('create-po-modal');
                                if (modalElement) {
                                    modalElement.style.display = 'none';
                                    modalElement.classList.remove('show');
                                    document.body.classList.remove('modal-open');
                                    
                                    // Remove backdrop
                                    const backdrop = document.querySelector('.modal-backdrop');
                                    if (backdrop) {
                                        backdrop.remove();
                                    }
                                }
                            } catch (error) {
                                console.warn('Error closing modal:', error);
                            }
                            
                            // Reset form
                            form.reset();
                            
                            // Refresh table
                            if (window.purchaseOrdersTable) {
                                window.purchaseOrdersTable.ajax.reload();
                            }
                            
                            // Show success message using global notifications
                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess(response.message || 'Purchase order created successfully');
                            } else if (typeof window.showToast === 'function') {
                                window.showToast(response.message || 'Purchase order created successfully', 'success');
                            } else {
                                console.log('Success:', response.message || 'Purchase order created successfully');
                            }
                        } else {
                            const errorMsg = response.message || 'Failed to create purchase order.';
                            if (typeof window.showError === 'function') {
                                window.showError(errorMsg);
                            } else if (typeof window.showToast === 'function') {
                                window.showToast(errorMsg, 'error');
                            } else {
                                console.error('Error:', errorMsg);
                            }
                        }
                    },
                    error: function(xhr) {
                        let message = 'An error occurred while saving the purchase order.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        if (typeof window.showError === 'function') {
                            window.showError(message);
                        } else if (typeof window.showToast === 'function') {
                            window.showToast(message, 'error');
                        } else {
                            console.error('Error:', message);
                        }
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                        
                        // Re-initialize Lucide icons
                        if (typeof lucide !== 'undefined') {
                            lucide.createIcons();
                        }
                    }
                });
            }, 500); // Wait 500ms for modal to be ready
        });

        function refreshPurchaseOrderCode() {
            const $ = window.jQuery || window.$;
            $.get('{{ route("warehouse.purchase-orders.preview-code") }}')
                .done(function (response) {
                    if (response && response.code) {
                        document.getElementById('create-po-code').value = response.code;
                    }
                });
        }
    </script>
</x-modal.form>
