@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Edit Purchase Order - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Edit Purchase Order</h2>
        <a href="{{ route('warehouse.purchase-orders.show', $purchaseOrder->id) }}" class="btn-tonal btn-tonal--secondary">
            <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" />
            Back to Details
        </a>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Edit Purchase Order Modal (unified invoice design) -->
            <x-invoice.unified-form 
                id="edit-po-modal" 
                title="Edit Purchase Order" 
                type="purchase_order"
                :suppliers="$suppliers ?? []"
                :materials="$materials ?? []"
            />

            <!-- Form Container -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <form id="edit-po-form" action="{{ route('warehouse.purchase-orders.update', $purchaseOrder->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Purchase Order Information -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <x-base.lucide icon="file-text" class="h-5 w-5"></x-base.lucide>
                                Purchase Order Information
                            </h4>
                            
                            <div class="grid grid-cols-12 gap-4">
                                <!-- Code -->
                                <div class="col-span-12 md:col-span-3">
                                    <x-base.form-label for="edit-po-code">Code</x-base.form-label>
                                    <x-base.form-input
                                        id="edit-po-code"
                                        name="code"
                                        type="text"
                                        value="{{ $purchaseOrder->code }}"
                                        required
                                    />
                                </div>
                                
                                <!-- Title -->
                                <div class="col-span-12 md:col-span-4">
                                    <x-base.form-label for="edit-po-title">Title</x-base.form-label>
                                    <x-base.form-input
                                        id="edit-po-title"
                                        name="title"
                                        type="text"
                                        value="{{ $purchaseOrder->title }}"
                                        required
                                    />
                                </div>
                                
                                <!-- Order Date -->
                                <div class="col-span-12 md:col-span-2">
                                    <x-base.form-label for="edit-po-date">Order Date</x-base.form-label>
                                    <x-base.form-input
                                        id="edit-po-date"
                                        name="order_date"
                                        type="date"
                                        value="{{ $purchaseOrder->order_date->format('Y-m-d') }}"
                                        required
                                    />
                                </div>
                                
                                <!-- Status -->
                                <div class="col-span-12 md:col-span-3">
                                    <x-base.form-label for="edit-po-status">Status</x-base.form-label>
                                    <x-base.form-select id="edit-po-status" name="status">
                                        <option value="pending" {{ $purchaseOrder->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $purchaseOrder->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="shipped" {{ $purchaseOrder->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $purchaseOrder->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $purchaseOrder->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </x-base.form-select>
                                </div>
                                
                                <!-- Expected Delivery Date -->
                                <div class="col-span-12 md:col-span-4">
                                    <x-base.form-label for="edit-po-delivery-date">Expected Delivery Date</x-base.form-label>
                                    <x-base.form-input
                                        id="edit-po-delivery-date"
                                        name="expected_delivery_date"
                                        type="date"
                                        value="{{ $purchaseOrder->expected_delivery_date ? $purchaseOrder->expected_delivery_date->format('Y-m-d') : '' }}"
                                    />
                                </div>
                                
                                <!-- Total Amount -->
                                <div class="col-span-12 md:col-span-4">
                                    <x-base.form-label for="edit-po-amount">Total Amount</x-base.form-label>
                                    <x-base.form-input
                                        id="edit-po-amount"
                                        name="total_amount"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        value="{{ $purchaseOrder->total_amount }}"
                                        required
                                    />
                                </div>
                                
                                <!-- Active Status -->
                                <div class="col-span-12 md:col-span-4 flex items-end">
                                    <label class="flex items-center">
                                        <x-base.form-check.input 
                                            type="checkbox" 
                                            name="is_active" 
                                            value="1"
                                            {{ $purchaseOrder->is_active ? 'checked' : '' }}
                                        />
                                        <span class="ml-2">Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <x-base.form-label for="edit-po-description">Description</x-base.form-label>
                            <x-base.form-textarea
                                id="edit-po-description"
                                name="description"
                                rows="3"
                                placeholder="Purchase order description"
                            >{{ $purchaseOrder->description }}</x-base.form-textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('warehouse.purchase-orders.show', $purchaseOrder->id) }}" class="btn-tonal btn-tonal--warning">
                                Cancel
                            </a>
                            <button type="submit" class="btn-tonal btn-tonal--success">
                                <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                                Update Purchase Order
                            </button>
                        </div>
                    </form>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('edit-po-form');
            
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    
                    const formData = new FormData(form);
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Updating...';
                    
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '{{ route("warehouse.purchase-orders.show", $purchaseOrder->id) }}';
                        } else {
                            alert(data.message || 'Error updating purchase order');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error updating purchase order');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    });
                });
            }
        });
    </script>
@endsection
