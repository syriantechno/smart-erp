@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Customers - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="users" class="w-7 h-7" />
                <span>Customers Management</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Inactive customers --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="pause-circle" class="w-4 h-4" />
                        </div>
                        <div class="text-4xl md:text-5xl font-semibold tracking-tight">
                            {{ $inactiveCustomers ?? 0 }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Inactive
                    </div>
                </div>

                {{-- Active customers --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div class="text-4xl md:text-5xl font-semibold tracking-tight">
                            {{ $activeCustomers ?? 0 }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Active
                    </div>
                </div>

                {{-- Total customers --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="users" class="w-4 h-4" />
                        </div>
                        <div class="text-4xl md:text-5xl font-semibold tracking-tight">
                            {{ $totalCustomers ?? 0 }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Customers
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    {{-- Filters & Actions in One Row (aligned with HR Departments) --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Search Input --}}
                        <div class="relative min-w-[180px]">
                            <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <x-base.form-input
                                id="customers-filter-value"
                                type="text"
                                placeholder="Search..."
                                class="pl-9 w-full text-sm py-1.5"
                            />
                        </div>

                        {{-- Field Filter --}}
                        <x-base.form-select id="customers-filter-field" class="w-auto text-sm py-1.5">
                            <option value="all">All Fields</option>
                            <option value="name">Name</option>
                            <option value="code">Code</option>
                            <option value="email">Email</option>
                            <option value="phone">Phone</option>
                        </x-base.form-select>

                        {{-- Type Filter --}}
                        <x-base.form-select id="customers-filter-type" class="w-auto text-sm py-1.5">
                            <option value="contains">Contains</option>
                            <option value="equals">Equals</option>
                        </x-base.form-select>

                        {{-- Status Filter --}}
                        <x-base.form-select id="customers-filter-status" class="w-auto text-sm py-1.5">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </x-base.form-select>

                        {{-- Page Length --}}
                        <x-base.form-select id="customers-filter-length" class="w-auto text-sm py-1.5">
                            <option value="10">10</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-base.form-select>

                        {{-- Reset Button --}}
                        <x-base.tippy as="button" id="customers-filter-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button type="button" id="customers-print" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button type="button" id="customers-export-pdf" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-text" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export to Excel" placement="bottom">
                                <button id="customers-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="customers-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Customer Button --}}
                            <x-base.tippy content="Add new customer" placement="bottom">
                                <button
                                    type="button"
                                    id="add-customer-btn"
                                    class="btn-royal btn-royal--gold btn-royal--sm"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-customer-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-4 h-4 mr-2" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="customers-table"
                            data-tw-merge
                            data-erp-table
                            data-customers-datatable-url="{{ route('customers.datatable') }}"
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Type</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Email</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Phone</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Credit Limit</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Linked Account</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    <!-- Create Customer Modal -->
    <x-modal.form id="create-customer-modal" title="Add New Customer" size="xl">
        <form
            id="create-customer-form"
            data-preview-url="{{ route('customers.preview-code') }}"
            data-accounts-url="{{ route('accounting.chart-of-accounts.accounts') }}"
        >
            @csrf

            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="User" class="h-5 w-5"></x-base.lucide>
                    Customer Information
                </h4>

                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-customer-code">Customer Code</x-base.form-label>
                        <div class="flex gap-2">
                            <x-base.form-input
                                id="create-customer-code"
                                name="code"
                                type="text"
                                class="flex-1"
                                placeholder="Auto-generated"
                                required
                                readonly
                            />
                            <x-base.button
                                type="button"
                                variant="outline-secondary"
                                onclick="refreshCustomerCode()"
                                title="Generate New Code"
                            >
                                <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                            </x-base.button>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-customer-name">Customer Name <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input
                            id="create-customer-name"
                            name="name"
                            type="text"
                            class="w-full"
                            placeholder="Enter customer name"
                            required
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-customer-type">Customer Type <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select id="create-customer-type" name="customer_type" class="w-full" required>
                            <option value="individual">Individual</option>
                            <option value="company">Company</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-customer-status">Status <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select id="create-customer-status" name="status" class="w-full" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-customer-email">Email Address</x-base.form-label>
                        <x-base.form-input
                            id="create-customer-email"
                            name="email"
                            type="email"
                            class="w-full"
                            placeholder="customer@example.com"
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-customer-phone">Phone Number</x-base.form-label>
                        <x-base.form-input
                            id="create-customer-phone"
                            name="phone"
                            type="text"
                            class="w-full"
                            placeholder="+1 234 567 8900"
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-customer-mobile">Mobile Number</x-base.form-label>
                        <x-base.form-input
                            id="create-customer-mobile"
                            name="mobile"
                            type="text"
                            class="w-full"
                            placeholder="+1 234 567 8900"
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-customer-tax-id">Tax ID</x-base.form-label>
                        <x-base.form-input
                            id="create-customer-tax-id"
                            name="tax_id"
                            type="text"
                            class="w-full"
                            placeholder="Tax identification number"
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-customer-credit-limit">Credit Limit</x-base.form-label>
                        <x-base.form-input
                            id="create-customer-credit-limit"
                            name="credit_limit"
                            type="number"
                            step="0.01"
                            min="0"
                            class="w-full"
                            placeholder="0.00"
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-customer-category">Customer Category</x-base.form-label>
                        <x-base.form-select id="create-customer-category" name="category" class="w-full">
                            <option value="">Select category</option>
                            <option value="vip">VIP</option>
                            <option value="regular">Regular</option>
                            <option value="wholesale">Wholesale</option>
                            <option value="retail">Retail</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-customer-payment-terms">Payment Terms</x-base.form-label>
                        <x-base.form-input
                            id="create-customer-payment-terms"
                            name="payment_terms"
                            type="text"
                            class="w-full"
                            placeholder="Net 30, COD, etc."
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-customer-account">Linked Account (Optional)</x-base.form-label>
                        <x-base.form-select id="create-customer-account" name="account_id" class="w-full">
                            <option value="">Auto-create account</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12">
                        <x-base.form-label for="create-customer-address">Address</x-base.form-label>
                        <x-base.form-textarea
                            id="create-customer-address"
                            name="address"
                            class="w-full"
                            rows="3"
                            placeholder="Enter complete address"
                        ></x-base.form-textarea>
                    </div>

                    <div class="col-span-12">
                        <x-base.form-label for="create-customer-notes">Notes</x-base.form-label>
                        <x-base.form-textarea
                            id="create-customer-notes"
                            name="notes"
                            class="w-full"
                            rows="3"
                            placeholder="Additional notes or comments"
                        ></x-base.form-textarea>
                    </div>
                </div>
            </div>
        </form>

        @slot('footer')
            <div class="custom-modal-footer">
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
                    form="create-customer-form"
                    id="create-customer-btn"
                    class="btn-royal btn-royal--gold group"
                >
                    <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                    Save Customer
                </button>
            </div>
        @endslot
    </x-modal.form>

    <form
        id="customers-export-pdf-form"
        action="{{ route('customers.export-pdf') }}"
        method="POST"
        target="_blank"
        class="hidden"
    >
        @csrf
        <input type="hidden" name="field" id="customers-export-field">
        <input type="hidden" name="type" id="customers-export-type">
        <input type="hidden" name="value" id="customers-export-value">
        <input type="hidden" name="status" id="customers-export-status">
    </form>
    <form
        id="customers-export-excel-form"
        action="{{ route('customers.export-excel') }}"
        method="GET"
        target="_blank"
        class="hidden"
    >
        <input type="hidden" name="field" id="customers-export-excel-field">
        <input type="hidden" name="type" id="customers-export-excel-type">
        <input type="hidden" name="value" id="customers-export-excel-value">
        <input type="hidden" name="status" id="customers-export-excel-status">
    </form>
@endsection

@include('components.datatable.scripts')

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jq = window.jQuery || window.$;
        if (!jq) {
            console.error('jQuery not available for create customer modal.');
            return;
        }

        const $ = jq;
        const form = document.getElementById('create-customer-form');
        const submitBtn = $('#create-customer-btn');

        if (!form) {
            return;
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const originalText = submitBtn.html();

            submitBtn.prop('disabled', true).html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving...');

            $.ajax({
                url: '{{ route("customers.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        const modalEl = document.getElementById('create-customer-modal');
                        if (modalEl && window.tailwind && window.tailwind.Modal) {
                            const modalInstance = window.tailwind.Modal.getOrCreateInstance(modalEl);
                            modalInstance.hide();
                        }

                        form.reset();
                        if (window.customersTable) {
                            window.customersTable.ajax.reload();
                        }

                        if (typeof window.showSuccess === 'function') {
                            window.showSuccess(response.message || 'Customer created successfully');
                        }
                    } else if (typeof window.showError === 'function') {
                        window.showError(response.message || 'Failed to create customer.');
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors || {};
                    let errorMessage = xhr.responseJSON?.message || 'An error occurred';

                    if (Object.keys(errors).length > 0) {
                        errorMessage = Object.values(errors).flat().join('\n');
                    }

                    if (typeof window.showError === 'function') {
                        window.showError(errorMessage);
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                    if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                        lucide.createIcons();
                    }
                }
            });
        });
    });

    function deleteCustomer(id, name) {
        const confirmFn = typeof window.confirmDelete === 'function'
            ? window.confirmDelete
            : null;

        const runDelete = () => {
            const $ = window.jQuery || window.$;
            $.ajax({
                url: `/customers/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        if (window.customersTable) {
                            window.customersTable.ajax.reload();
                        }

                        const msg = response.message || 'Customer deleted successfully';
                        if (typeof window.showSuccess === 'function') {
                            window.showSuccess(msg, 'Deleted!');
                        } else if (typeof window.showToast === 'function') {
                            window.showToast(msg, 'delete');
                        } else {
                            console.log('Deleted:', msg);
                        }
                    } else {
                        const err = response.message || 'Failed to delete customer';
                        if (typeof window.showError === 'function') {
                            window.showError(err);
                        } else if (typeof window.showToast === 'function') {
                            window.showToast(err, 'error');
                        } else {
                            console.error('Error:', err);
                        }
                    }
                },
                error: function(xhr) {
                    const err = (xhr.responseJSON && xhr.responseJSON.message) || 'Failed to delete customer';
                    if (typeof window.showError === 'function') {
                        window.showError(err);
                    } else if (typeof window.showToast === 'function') {
                        window.showToast(err, 'error');
                    } else {
                        console.error('Error:', err);
                    }
                }
            });
        };

        if (confirmFn) {
            confirmFn(name, runDelete);
        } else if (typeof window.confirmDelete === 'function') {
            window.confirmDelete(name, runDelete);
        } else {
            runDelete();
        }
    }
</script>
@endpush
