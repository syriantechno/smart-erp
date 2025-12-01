@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Vendors - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        /* Make table more compact with better readability */
        #vendors-table {
            font-size: 0.95rem; /* 15px - slightly larger */
            line-height: 1.4;
        }

        #vendors-table tbody tr {
            height: 2.25rem; /* 36px - more compact */
        }

        #vendors-table th {
            font-size: 0.8rem; /* 13px - slightly larger headers */
            font-weight: 700;
            padding: 0.5rem 1.25rem; /* py-2 px-5 */
        }

        #vendors-table td {
            padding: 0.375rem 1.25rem; /* py-1.5 px-5 - even more compact */
        }

        /* Status badges - compact and readable */
        #vendors-table .inline-flex {
            padding: 0.125rem 0.5rem; /* 2px 8px */
            font-weight: 600;
        }

        /* Actions column - keep compact */
        #vendors-table .px-5.py-1\.5 {
            padding: 0.375rem 1.25rem;
        }

        #vendors-table thead th,
        #vendors-table tbody td {
            text-align: center;
            font-size: 0.9rem;
        }

        #vendors-table .datatable-cell-wrap {
            text-align: center;
        }

        #vendors-table [class^="stats-card-"],
        #vendors-table [class*=" stats-card-"] {
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
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="truck" class="w-7 h-7" />
                <span>Vendors Management</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Inactive vendors --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="pause-circle" class="w-4 h-4" />
                        </div>
                        <div class="text-4xl md:text-5xl font-semibold tracking-tight">
                            {{ $inactiveVendors ?? 0 }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Inactive
                    </div>
                </div>

                {{-- Active vendors --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div class="text-4xl md:text-5xl font-semibold tracking-tight">
                            {{ $activeVendors ?? 0 }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Active
                    </div>
                </div>

                {{-- Total vendors --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="truck" class="w-4 h-4" />
                        </div>
                        <div class="text-4xl md:text-5xl font-semibold tracking-tight">
                            {{ $totalVendors ?? 0 }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Vendors
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
                        <form id="vendors-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="vendors-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="name">Name</option>
                                    <option value="code">Code</option>
                                    <option value="email">Email</option>
                                    <option value="contact_person">Contact Person</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="vendors-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="vendors-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Status
                                </label>
                                <x-base.form-select id="vendors-filter-status" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="">All</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <x-base.form-select id="vendors-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25" selected>25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <x-base.tippy content="Apply filters" placement="top">
                                    <button id="vendors-filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
                                        <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                        Go
                                    </button>
                                </x-base.tippy>
                                <x-base.tippy content="Reset filters" placement="top">
                                    <button id="vendors-filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
                                        <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                        Reset
                                    </button>
                                </x-base.tippy>
                            </div>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <x-base.tippy content="Print" placement="bottom">
                                <button type="button" id="vendors-print" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export to Excel" placement="bottom">
                                <button id="vendors-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="vendors-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>

                            {{-- Add button at the right end of the toolbar --}}
                            <x-base.tippy content="Add new vendor" placement="bottom">
                                <button
                                    type="button"
                                    id="add-vendor-btn"
                                    class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-vendor-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible">
                        <table
                            id="vendors-table"
                            data-tw-merge
                            data-erp-table
                            data-vendors-datatable-url="{{ route('supplier.vendors.datatable') }}"
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Email</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Phone</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Contact Person</th>
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

    <!-- Create Vendor Modal -->
    <x-modal.form id="create-vendor-modal" title="Add New Vendor" size="xl">
        <form id="create-vendor-form">
            @csrf

            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="Building" class="h-5 w-5"></x-base.lucide>
                    Basic Information
                </h4>

                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-vendor-code">Vendor Code</x-base.form-label>
                        <div class="flex gap-2">
                            <x-base.form-input
                                id="create-vendor-code"
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
                                onclick="refreshVendorCode()"
                                title="Generate New Code"
                            >
                                <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                            </x-base.button>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-vendor-name">Vendor Name</x-base.form-label>
                        <x-base.form-input
                            id="create-vendor-name"
                            name="name"
                            type="text"
                            class="w-full"
                            placeholder="Enter vendor name"
                            required
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-vendor-email">Email Address</x-base.form-label>
                        <x-base.form-input
                            id="create-vendor-email"
                            name="email"
                            type="email"
                            class="w-full"
                            placeholder="vendor@example.com"
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-vendor-phone">Phone Number</x-base.form-label>
                        <x-base.form-input
                            id="create-vendor-phone"
                            name="phone"
                            type="text"
                            class="w-full"
                            placeholder="+1 234 567 8900"
                        />
                    </div>

                    <div class="col-span-12">
                        <x-base.form-label for="create-vendor-address">Address</x-base.form-label>
                        <x-base.form-textarea
                            id="create-vendor-address"
                            name="address"
                            class="w-full"
                            rows="3"
                            placeholder="Enter complete address"
                        ></x-base.form-textarea>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="User" class="h-5 w-5"></x-base.lucide>
                    Contact Person
                </h4>

                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12 md:col-span-4">
                        <x-base.form-label for="create-vendor-contact-person">Contact Person Name</x-base.form-label>
                        <x-base.form-input
                            id="create-vendor-contact-person"
                            name="contact_person"
                            type="text"
                            class="w-full"
                            placeholder="John Doe"
                        />
                    </div>

                    <div class="col-span-12 md:col-span-4">
                        <x-base.form-label for="create-vendor-contact-phone">Contact Phone</x-base.form-label>
                        <x-base.form-input
                            id="create-vendor-contact-phone"
                            name="contact_person_phone"
                            type="text"
                            class="w-full"
                            placeholder="+1 234 567 8900"
                        />
                    </div>

                    <div class="col-span-12 md:col-span-4">
                        <x-base.form-label for="create-vendor-contact-email">Contact Email</x-base.form-label>
                        <x-base.form-input
                            id="create-vendor-contact-email"
                            name="contact_person_email"
                            type="email"
                            class="w-full"
                            placeholder="john@example.com"
                        />
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <x-base.lucide icon="Briefcase" class="h-5 w-5"></x-base.lucide>
                    Business Information
                </h4>

                <div class="grid grid-cols-12 gap-4 gap-y-4">
                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-vendor-website">Website</x-base.form-label>
                        <x-base.form-input
                            id="create-vendor-website"
                            name="website"
                            type="url"
                            class="w-full"
                            placeholder="https://example.com"
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-vendor-tax-id">Tax ID</x-base.form-label>
                        <x-base.form-input
                            id="create-vendor-tax-id"
                            name="tax_id"
                            type="text"
                            class="w-full"
                            placeholder="Tax identification number"
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-vendor-category">Vendor Category</x-base.form-label>
                        <x-base.form-select id="create-vendor-category" name="category" class="w-full">
                            <option value="">Select category</option>
                            <option value="local">Local</option>
                            <option value="international">International</option>
                            <option value="strategic">Strategic</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-vendor-payment-terms">Payment Terms</x-base.form-label>
                        <x-base.form-input
                            id="create-vendor-payment-terms"
                            name="payment_terms"
                            type="text"
                            class="w-full"
                            placeholder="Net 30, COD, etc."
                        />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-base.form-label for="create-vendor-account">Linked Account (Optional)</x-base.form-label>
                        <x-base.form-select id="create-vendor-account" name="account_id" class="w-full">
                            <option value="">Auto-create account</option>
                        </x-base.form-select>
                    </div>

                    <div class="col-span-12">
                        <x-base.form-label for="create-vendor-notes">Notes</x-base.form-label>
                        <x-base.form-textarea
                            id="create-vendor-notes"
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
                    form="create-vendor-form"
                    id="create-vendor-btn"
                    class="btn-royal btn-royal--dark group"
                >
                    <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                    Save Vendor
                </button>
            </div>
        @endslot

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const jq = window.jQuery || window.$;
                if (!jq) {
                    console.error('jQuery not available for create vendor modal.');
                    return;
                }

                const $ = jq;
                const form = document.getElementById('create-vendor-form');
                const submitBtn = $('#create-vendor-btn');

                if (!form) {
                    return;
                }

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const originalText = submitBtn.html();

                    submitBtn.prop('disabled', true).html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving...');

                    $.ajax({
                        url: '{{ route("supplier.vendors.store") }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                const modalEl = document.getElementById('create-vendor-modal');
                                if (modalEl && window.tailwind && window.tailwind.Modal) {
                                    const modalInstance = window.tailwind.Modal.getOrCreateInstance(modalEl);
                                    modalInstance.hide();
                                }

                                form.reset();
                                if (window.vendorsTable) {
                                    window.vendorsTable.ajax.reload();
                                }

                                if (typeof window.showSuccess === 'function') {
                                    window.showSuccess(response.message || 'Vendor created successfully');
                                }
                            } else if (typeof window.showError === 'function') {
                                window.showError(response.message || 'Failed to create vendor.');
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
        </script>
    </x-modal.form>
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let vendorsTable;

        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM Content Loaded');
            
            // Wait for jQuery to be available
            if (typeof window.jQuery === 'undefined') {
                console.error('jQuery not available');
                setTimeout(function() {
                    initializeVendorsTable();
                }, 1000);
            } else {
                const $ = window.jQuery;
                $(function () {
                    console.log('jQuery ready');
                    initializeVendorsTable();

                    const openBtn = document.getElementById('add-vendor-btn');
                    if (openBtn) {
                        openBtn.addEventListener('click', function () {
                            window.refreshVendorCode();
                            loadAccountsForVendor();
                        });
                    }
                });
            }
        });

        window.refreshVendorCode = function() {
            const codeInput = document.getElementById('create-vendor-code');
            if (!codeInput) return;
            
            fetch('{{ route("supplier.vendors.preview-code") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to preview vendor code');
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

        function loadAccountsForVendor() {
            const accountSelect = document.getElementById('create-vendor-account');
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

        function initializeVendorsTable() {
            if (!window.erpCrud || !window.erpCrud.initDataTable) {
                console.error('erpCrud not available');
                return;
            }

            vendorsTable = window.erpCrud.initDataTable({
                tableSelector: '#vendors-table',
                ajaxUrl: '{{ route("supplier.vendors.datatable") }}',
                ajaxData: function(d) {
                    d.field = $('#vendors-filter-field').val();
                    d.type = $('#vendors-filter-type').val();
                    d.value = $('#vendors-filter-value').val();
                    d.status = $('#vendors-filter-status').val();
                },
                pageLength: 25,
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                    { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                    { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700' },
                    { data: 'email', name: 'email', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'phone', name: 'phone', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'contact_person', name: 'contact_person', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'linked_account', name: 'linked_account', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        orderable: false,
                        render: function(value) {
                            if (window.erpCrud && typeof window.erpCrud.renderStatusBadge === 'function') {
                                return window.erpCrud.renderStatusBadge(value);
                            }
                            const status = Boolean(value);
                            const badgeClass = status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                            const label = status ? 'Active' : 'Inactive';
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

            window.vendorsTable = vendorsTable;

            // Setup filter buttons
            $('#vendors-filter-go').on('click', function() {
                vendorsTable.ajax.reload();
            });

            $('#vendors-filter-reset').on('click', function() {
                $('#vendors-filter-field').val('all');
                $('#vendors-filter-type').val('contains');
                $('#vendors-filter-value').val('');
                $('#vendors-filter-status').val('');
                vendorsTable.ajax.reload();
            });

            $('#vendors-refresh').on('click', function() {
                vendorsTable.ajax.reload();

                if (typeof window.showSuccess === 'function') {
                    window.showSuccess('Vendors list refreshed');
                } else if (typeof window.showToast === 'function') {
                    window.showToast('Vendors list refreshed', 'info');
                }
            });

            $('#vendors-filter-length').on('change', function() {
                vendorsTable.page.len($(this).val()).draw();
            });

            $('#vendors-print').on('click', function() {
                window.print();
            });

            if (window.erpCrud) {
                window.erpCrud.handleDelete({
                    urlBuilder: (id) => `/supplier/vendors/${id}`,
                    onSuccess: () => vendorsTable.ajax.reload(null, false),
                });
            }
        }

        function viewVendor(id) {
            const msg = 'View functionality will be implemented soon';
            if (typeof window.showInfo === 'function') {
                window.showInfo(msg);
            } else if (typeof window.showToast === 'function') {
                window.showToast(msg, 'info');
            } else {
                console.info(msg);
            }
        }

        function editVendor(id) {
            const msg = 'Edit functionality will be implemented soon';
            if (typeof window.showInfo === 'function') {
                window.showInfo(msg);
            } else if (typeof window.showToast === 'function') {
                window.showToast(msg, 'info');
            } else {
                console.info(msg);
            }
        }

        function deleteVendor(id, name) {
            const confirmFn = typeof window.confirmDelete === 'function'
                ? window.confirmDelete
                : null;

            const runDelete = () => {
                const $ = window.jQuery || window.$;
                $.ajax({
                    url: `/supplier/vendors/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            if (window.vendorsTable) {
                                window.vendorsTable.ajax.reload();
                            }

                            const msg = response.message || 'Vendor deleted successfully';
                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess(msg, 'Deleted!');
                            } else if (typeof window.showToast === 'function') {
                                window.showToast(msg, 'delete');
                            } else {
                                console.log('Deleted:', msg);
                            }
                        } else {
                            const err = response.message || 'Failed to delete vendor';
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
                        const err = (xhr.responseJSON && xhr.responseJSON.message) || 'Failed to delete vendor';
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
