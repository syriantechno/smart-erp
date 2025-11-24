@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Customers - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        /* Make table more compact with better readability */
        #customers-table {
            font-size: 0.95rem; /* 15px - slightly larger */
            line-height: 1.4;
        }

        #customers-table tbody tr {
            height: 2.25rem; /* 36px - more compact */
        }

        #customers-table th {
            font-size: 0.8rem; /* 13px - slightly larger headers */
            font-weight: 700;
            padding: 0.5rem 1.25rem; /* py-2 px-5 */
        }

        #customers-table td {
            padding: 0.375rem 1.25rem; /* py-1.5 px-5 - even more compact */
        }

        /* Status badges - compact and readable */
        #customers-table .inline-flex {
            padding: 0.125rem 0.5rem; /* 2px 8px */
            font-weight: 600;
        }

        /* Actions column - keep compact */
        #customers-table .px-5.py-1\.5 {
            padding: 0.375rem 1.25rem;
        }

        #customers-table thead th,
        #customers-table tbody td {
            text-align: center;
            font-size: 0.9rem;
        }

        #customers-table .datatable-cell-wrap {
            text-align: center;
        }

        #customers-table [class^="stats-card-"],
        #customers-table [class*=" stats-card-"] {
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .icon-hover-rise {
            transition: transform 200ms ease;
        }

        .group:hover .icon-hover-rise {
            transform: translateY(-2px);
        }

        .custom-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
            margin-top: 1.5rem;
        }

        .custom-modal-footer button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 200ms ease;
        }
    </style>
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
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="customers-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="customers-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="name">Name</option>
                                    <option value="code">Code</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Phone</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="customers-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="customers-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Status
                                </label>
                                <x-base.form-select id="customers-filter-status" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="">All</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="suspended">Suspended</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <x-base.form-select id="customers-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25" selected>25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <x-base.tippy content="Apply filters" placement="top">
                                    <button id="customers-filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
                                        <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                        Go
                                    </button>
                                </x-base.tippy>
                                <x-base.tippy content="Reset filters" placement="top">
                                    <button id="customers-filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
                                        <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                        Reset
                                    </button>
                                </x-base.tippy>
                            </div>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <x-base.tippy content="Print" placement="bottom">
                                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export to Excel" placement="bottom">
                                <button id="customers-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="customers-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark">
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>

                            {{-- Add button at the right end of the toolbar --}}
                            <x-base.tippy content="Add new customer" placement="bottom">
                                <button
                                    type="button"
                                    id="add-customer-btn"
                                    class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group bg-amber-500 hover:bg-amber-600 text-white border-0"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-customer-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible">
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
        <form id="create-customer-form">
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
                    class="btn-royal btn-royal--dark group bg-blue-600 hover:bg-blue-700 text-white border-0 px-6 py-2"
                >
                    <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                    Save Customer
                </button>
            </div>
        @endslot

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
                    console.log('Form submitted');

                    const formData = new FormData(form);
                    const originalText = submitBtn.html();

                    console.log('Form data:');
                    for (let [key, value] of formData.entries()) {
                        console.log(key, value);
                    }

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
                            console.log('Success response:', response);
                            if (response.success) {
                                const modalEl = document.getElementById('create-customer-modal');
                                if (modalEl && modalEl.__tippy?.hide) {
                                    modalEl.__tippy.hide();
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
                        error: function(xhr, status, error) {
                            console.log('Error response:', xhr.responseText);
                            console.log('Status:', status);
                            console.log('Error:', error);
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
        </script>
    </x-modal.form>
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let customersTable;

        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM Content Loaded');

            // Wait for jQuery to be available
            if (typeof window.jQuery === 'undefined') {
                console.error('jQuery not available');
                setTimeout(function() {
                    initializeCustomersTable();
                }, 1000);
            } else {
                const $ = window.jQuery;
                $(function () {
                    console.log('jQuery ready');
                    initializeCustomersTable();

                    const openBtn = document.getElementById('add-customer-btn');
                    if (openBtn) {
                        openBtn.addEventListener('click', function () {
                            window.refreshCustomerCode();
                            loadAccountsForCustomer();
                        });
                    }
                });
            }
        });

        window.refreshCustomerCode = function() {
            const codeInput = document.getElementById('create-customer-code');
            if (!codeInput) return;

            fetch('{{ route("customers.preview-code") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to preview customer code');
                    }
                    return response.json();
                })
                .then(data => {
                    const code = data.code || '-';
                    codeInput.value = code;
                })
                .catch(() => {
                    codeInput.value = '-';
                });
        };

        function loadAccountsForCustomer() {
            // Load accounts for customer selection (same as vendor)
            const accountSelect = document.getElementById('create-customer-account');
            if (!accountSelect) return;

            // Clear existing options except the first one
            accountSelect.innerHTML = '<option value="">Auto-create account</option>';

            fetch('{{ route("accounting.chart-of-accounts.accounts") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to load accounts');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.data) {
                        data.data.forEach(account => {
                            const option = document.createElement('option');
                            option.value = account.id;
                            option.textContent = account.text;
                            accountSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading accounts:', error);
                });
        }

        function initializeCustomersTable() {
            if (!window.erpCrud || !window.erpCrud.initDataTable) {
                console.error('erpCrud not available');
                return;
            }

            customersTable = window.erpCrud.initDataTable({
                tableSelector: '#customers-table',
                ajaxUrl: '{{ route("customers.datatable") }}',
                ajaxData: function(d) {
                    d.field = $('#customers-filter-field').val();
                    d.type = $('#customers-filter-type').val();
                    d.value = $('#customers-filter-value').val();
                    d.status = $('#customers-filter-status').val();
                },
                pageLength: 25,
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                    { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                    { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700' },
                    { data: 'customer_type', name: 'customer_type', className: 'px-5 py-3 border-b dark:border-darkmode-300 capitalize' },
                    { data: 'email', name: 'email', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'phone', name: 'phone', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'credit_limit_formatted', name: 'credit_limit', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center' },
                    { data: 'linked_account', name: 'linked_account', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        orderable: false,
                        render: function(value) {
                            if (window.erpCrud && typeof window.erpCrud.renderStatusBadge === 'function') {
                                return window.erpCrud.renderStatusBadge(value === 'active');
                            }
                            const isActive = value === 'active';
                            const badgeClass = isActive ? 'bg-green-100 text-green-700' : value === 'inactive' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700';
                            const label = isActive ? 'Active' : value === 'inactive' ? 'Inactive' : 'Suspended';
                            return `<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${badgeClass}">${label}</span>`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function(settings) {
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    }
                }
            });

            window.customersTable = customersTable;

            // Setup filter buttons
            $('#customers-filter-go').on('click', function() {
                customersTable.ajax.reload();
            });

            $('#customers-filter-reset').on('click', function() {
                $('#customers-filter-field').val('all');
                $('#customers-filter-type').val('contains');
                $('#customers-filter-value').val('');
                $('#customers-filter-status').val('');
                customersTable.ajax.reload();
            });

            $('#customers-refresh').on('click', function() {
                customersTable.ajax.reload();
            });

            $('#customers-filter-length').on('change', function() {
                customersTable.page.len($(this).val()).draw();
            });
        }

        function viewCustomer(id) {
            Swal.fire({
                title: 'View Customer',
                text: 'View functionality will be implemented soon',
                icon: 'info'
            });
        }

        function editCustomer(id) {
            Swal.fire({
                title: 'Edit Customer',
                text: 'Edit functionality will be implemented soon',
                icon: 'info'
            });
        }

        function deleteCustomer(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const jq = window.jQuery || window.$;
                    if (!jq) return;

                    jq.ajax({
                        url: '{{ route("customers.destroy", ":id") }}'.replace(':id', id),
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Deleted!', response.message, 'success');
                                if (customersTable) {
                                    customersTable.ajax.reload();
                                }
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', xhr.responseJSON?.message || 'Failed to delete', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endpush
