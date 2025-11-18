@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Vendors - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <style>
        #vendors-table {
            display: table;
            width: 100%;
        }
        #vendors-table thead {
            display: table-header-group;
        }
        #vendors-table tbody {
            display: table-row-group;
        }
        #vendors-table tr {
            display: table-row;
        }
        #vendors-table th,
        #vendors-table td {
            display: table-cell;
        }
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Vendors</h2>
        <x-base.button
            id="add-vendor-btn"
            variant="primary"
            class="w-40 sm:w-auto sm:ml-4"
            data-tw-toggle="modal"
            data-tw-target="#create-vendor-modal"
        >
            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
            Add Vendor
        </x-base.button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="vendors-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Search
                                </label>
                                <x-base.form-input id="vendors-filter-value" type="text" placeholder="Search vendors..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
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
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 xl:mt-0">
                                <x-base.button id="vendors-filter-go" type="button" variant="primary" class="w-full sm:w-16">
                                    Go
                                </x-base.button>
                                <x-base.button id="vendors-filter-reset" type="button" variant="secondary" class="mt-2 w-full sm:ml-1 sm:mt-0 sm:w-16">
                                    Reset
                                </x-base.button>
                            </div>
                        </form>

                        <div class="mt-5 flex sm:mt-0">
                            <x-base.button id="vendors-refresh" variant="outline-secondary" class="w-1/2 sm:w-auto">
                                <x-base.lucide icon="RefreshCcw" class="mr-2 h-4 w-4" /> Refresh
                            </x-base.button>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible">
                        <table
                            id="vendors-table"
                            class="w-full table-auto text-left text-sm border-collapse"
                        >
                            <thead>
                                <tr class="border-b-2 border-slate-200 dark:border-darkmode-300">
                                    <th class="font-medium px-5 py-3 text-center">#</th>
                                    <th class="font-medium px-5 py-3">Code</th>
                                    <th class="font-medium px-5 py-3">Name</th>
                                    <th class="font-medium px-5 py-3">Email</th>
                                    <th class="font-medium px-5 py-3">Phone</th>
                                    <th class="font-medium px-5 py-3">Contact Person</th>
                                    <th class="font-medium px-5 py-3 text-center">Status</th>
                                    <th class="font-medium px-5 py-3 text-center">Actions</th>
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
                        <x-base.form-label for="create-vendor-status">Status</x-base.form-label>
                        <x-base.form-select id="create-vendor-status" name="is_active" class="w-full" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
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
            <div class="flex justify-end gap-2 w-full">
                <x-base.button
                    class="w-24"
                    data-tw-dismiss="modal"
                    type="button"
                    variant="outline-secondary"
                >
                    Cancel
                </x-base.button>
                <x-base.button
                    class="w-32"
                    type="submit"
                    form="create-vendor-form"
                    id="create-vendor-btn"
                    variant="primary"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Save Vendor
                </x-base.button>
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
                                if (modalEl && modalEl.__tippy?.hide) {
                                    modalEl.__tippy.hide();
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

        function initializeVendorsTable() {
            if (!window.erpCrud || !window.erpCrud.initDataTable) {
                console.error('erpCrud not available');
                return;
            }

            vendorsTable = window.erpCrud.initDataTable({
                tableSelector: '#vendors-table',
                ajaxUrl: '{{ route("supplier.vendors.datatable") }}',
                ajaxData: function(d) {
                    d.search = $('#vendors-filter-value').val();
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
                $('#vendors-filter-value').val('');
                $('#vendors-filter-status').val('');
                vendorsTable.ajax.reload();
            });

            $('#vendors-refresh').on('click', function() {
                vendorsTable.ajax.reload();
            });

            $('#vendors-filter-length').on('change', function() {
                vendorsTable.page.len($(this).val()).draw();
            });
        }

        function viewVendor(id) {
            Swal.fire({
                title: 'View Vendor',
                text: 'View functionality will be implemented soon',
                icon: 'info'
            });
        }

        function editVendor(id) {
            Swal.fire({
                title: 'Edit Vendor',
                text: 'Edit functionality will be implemented soon',
                icon: 'info'
            });
        }

        function deleteVendor(id) {
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
                        url: '{{ route("supplier.vendors.destroy", ":id") }}'.replace(':id', id),
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Deleted!', response.message, 'success');
                                if (vendorsTable) {
                                    vendorsTable.ajax.reload();
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
