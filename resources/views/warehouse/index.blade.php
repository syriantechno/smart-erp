@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Warehouses Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Warehouses Management</h2>
        <x-base.button
            variant="primary"
            class="w-40 sm:w-auto sm:ml-4"
            data-tw-toggle="modal"
            data-tw-target="#create-warehouse-modal"
        >
            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
            Add Warehouse
        </x-base.button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Advanced Filters Section -->
            <x-base.preview-component class="intro-y box mb-6">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <x-base.lucide icon="Filter" class="h-5 w-5"></x-base.lucide>
                        Advanced Filters
                        <span id="warehouses-active-filters-indicator" class="hidden ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">Active</span>
                    </h3>

                    <div class="grid grid-cols-12 gap-4">
                        <!-- Status Filter -->
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Status
                            </label>
                            <x-base.form-select id="warehouses-status-filter" class="w-full">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </x-base.form-select>
                        </div>

                        <!-- Search Filter -->
                        <div class="col-span-12 md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Search
                            </label>
                            <x-base.form-input
                                id="warehouses-search-filter"
                                type="text"
                                placeholder="Search by code, name or location..."
                                class="w-full"
                            />
                        </div>

                        <!-- Filter Actions -->
                        <div class="col-span-12 md:col-span-3 flex items-end gap-2">
                            <x-base.button
                                variant="secondary"
                                class="flex-1"
                                onclick="clearWarehousesFilters()"
                            >
                                <x-base.lucide icon="X" class="w-4 h-4 mr-2" />
                                Clear
                            </x-base.button>
                            <x-base.button
                                variant="primary"
                                class="flex-1"
                                onclick="applyWarehousesFilters()"
                            >
                                <x-base.lucide icon="Filter" class="w-4 h-4 mr-2" />
                                Apply
                            </x-base.button>
                        </div>
                    </div>
                </div>
            </x-base.preview-component>

            <!-- Warehouses Table -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table id="warehouses-table" class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Code</th>
                                    <th class="whitespace-nowrap">Name</th>
                                    <th class="whitespace-nowrap">Location</th>
                                    <th class="whitespace-nowrap">Status</th>
                                    <th class="whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    @include('warehouse.modals.create')
    @include('warehouse.modals.edit')
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        let warehousesTable;

        $(document).ready(function() {
            initializeWarehousesDataTable();
            setupWarehousesEventListeners();
        });

        function initializeWarehousesDataTable() {
            warehousesTable = $('#warehouses-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("warehouse.warehouses.datatable") }}',
                    data: function(d) {
                        d.status = $('#warehouses-status-filter').val();
                        d.filter_value = $('#warehouses-search-filter').val();
                        d.filter_field = 'all';
                        d.filter_type = 'contains';
                    }
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'name', name: 'name' },
                    { data: 'location', name: 'location' },
                    { data: 'status_badge', name: 'status_badge', orderable: false, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 25,
                responsive: true,
                dom: '<"flex flex-col sm:flex-row items-center gap-4"<"flex-1"l><"flex-1"f><"flex-1"B>>rt<"flex flex-col sm:flex-row items-center gap-4"<"flex-1"i><"flex-1"p>>',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="w-4 h-4 mr-2" data-lucide="file-spreadsheet"></i> Export Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    }
                ]
            });

            warehousesTable.on('draw', function() {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        }

        function setupWarehousesEventListeners() {
            $('#warehouses-search-filter').on('keypress', function(e) {
                if (e.which === 13) {
                    applyWarehousesFilters();
                }
            });

            $('#warehouses-status-filter').on('change', function() {
                applyWarehousesFilters();
            });
        }

        function applyWarehousesFilters() {
            if (warehousesTable) {
                warehousesTable.ajax.reload();
            }
            updateWarehousesActiveFiltersIndicator();
        }

        function clearWarehousesFilters() {
            $('#warehouses-status-filter').val('');
            $('#warehouses-search-filter').val('');
            if (warehousesTable) {
                warehousesTable.ajax.reload();
            }
            updateWarehousesActiveFiltersIndicator();
        }

        function updateWarehousesActiveFiltersIndicator() {
            const hasActiveFilters = $('#warehouses-status-filter').val() || $('#warehouses-search-filter').val();
            $('#warehouses-active-filters-indicator').toggleClass('hidden', !hasActiveFilters);
        }

        window.editWarehouse = function(id) {
            $.get('{{ route("warehouse.warehouses.show", ":id") }}'.replace(':id', id))
                .done(function(response) {
                    if (response.success) {
                        populateEditWarehouseModal(response.warehouse);
                        $('#edit-warehouse-modal').modal('show');
                    }
                });
        };

        window.deleteWarehouse = function(id, name) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Delete warehouse "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("warehouse.warehouses.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                if (warehousesTable) {
                                    warehousesTable.ajax.reload();
                                }
                                Swal.fire('Deleted!', response.message, 'success');
                            } else {
                                Swal.fire('Error!', response.message || 'Failed to delete warehouse.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Failed to delete warehouse.', 'error');
                        }
                    });
                }
            });
        };
    </script>
@endpush
