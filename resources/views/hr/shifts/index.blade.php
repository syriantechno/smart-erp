@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Shift Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row (Departments template matches Positions) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="clock" class="w-7 h-7" />
                <span>Shift Management</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Inactive shifts --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="pause-circle" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $inactiveShifts ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Inactive
                    </div>
                </div>

                {{-- Active shifts --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $activeShifts ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Active
                    </div>
                </div>

                {{-- Total shifts --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="clock" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $totalShifts ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Total Shifts
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    @if (session('success'))
                        <x-base.alert class="mb-4" variant="success">
                            <div class="flex items-center">
                                <x-base.lucide icon="CheckCircle" class="w-5 h-5 mr-2" />
                                {{ session('success') }}
                            </div>
                        </x-base.alert>
                    @endif

                    @if (session('error'))
                        <x-base.alert class="mb-4" variant="danger">
                            <div class="flex items-center">
                                <x-base.lucide icon="AlertTriangle" class="w-5 h-5 mr-2" />
                                {{ session('error') }}
                            </div>
                        </x-base.alert>
                    @endif

                    {{-- Filters & Actions in One Row --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Search Input --}}
                        <div class="relative min-w-[180px]">
                            <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <x-base.form-input 
                                id="shifts-filter-value" 
                                type="text" 
                                placeholder="Search..." 
                                class="pl-9 w-full text-sm py-1.5"
                            />
                        </div>

                        {{-- Company Filter --}}
                        <x-base.form-select id="company-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Companies</option>
                            @foreach($companies ?? [] as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </x-base.form-select>

                        {{-- Status Filter --}}
                        <x-base.form-select id="status-filter" class="w-auto text-sm py-1.5">
                            <option value="">Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-base.form-select>

                        {{-- Page Length --}}
                        <x-base.form-select id="shifts-filter-length" class="w-auto text-sm py-1.5">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-base.form-select>

                        {{-- Reset Button --}}
                        <x-base.tippy as="button" id="shifts-filter-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button id="shifts-print" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="shifts-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-text" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export Excel" placement="bottom">
                                <button id="shifts-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="shifts-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            {{-- Reports Button --}}
                            <x-base.tippy content="View Reports" placement="bottom">
                                <a href="{{ route('hr.shifts.reports') }}" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="bar-chart-3" class="w-4 h-4" />
                                </a>
                            </x-base.tippy>

                            {{-- Add Shift Button --}}
                            <x-base.tippy content="Add shift" placement="bottom">
                                <button
                                    type="button"
                                    class="btn-royal btn-royal--gold btn-royal--sm"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-shift-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-4 h-4 mr-2" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="shifts-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead class="bg-gradient-to-r from-royalDark to-gray-800 text-white">
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Working Hours</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Color</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Apply To</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    @include('hr.shifts.modals.create')
    @include('hr.shifts.modals.edit')
    @stack('shift-modals')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterValue = document.getElementById('shifts-filter-value');
        const companyFilter = document.getElementById('company-filter');
        const statusFilter = document.getElementById('status-filter');
        const lengthSelect = document.getElementById('shifts-filter-length');
        const filterResetBtn = document.getElementById('shifts-filter-reset');
        const exportBtn = document.getElementById('shifts-export');
        const refreshBtn = document.getElementById('shifts-refresh');
        const pdfBtn = document.getElementById('shifts-pdf');

        const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

        const table = window.erpCrud.initDataTable({
            tableSelector: '#shifts-table',
            ajaxUrl: '{{ route("hr.shifts.datatable") }}',
            ajaxData: function (d) {
                d.filter_value = filterValue?.value || '';
                d.company_id = companyFilter?.value || '';
                d.status = statusFilter?.value || '';
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700' },
                { data: 'formatted_time', name: 'formatted_time', className: 'px-5 py-3 border-b dark:border-darkmode-300 whitespace-nowrap' },
                {
                    data: 'color',
                    name: 'color',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                    render: function (data) {
                        return '<div class="flex items-center justify-center"><div class="w-6 h-6 rounded-full border-2 border-gray-300" style="background-color: ' + data + '"></div></div>';
                    }
                },
                { data: 'applicable_text', name: 'applicable_text', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                {
                    data: 'is_active',
                    name: 'is_active',
                    className: 'text-center',
                    render: function (value) {
                        if (window.erpCrud && typeof window.erpCrud.renderStatusBadge === 'function') {
                            return window.erpCrud.renderStatusBadge(value);
                        }
                        return value ? 'Active' : 'Inactive';
                    }
                },
                {
                    data: 'actions',
                    name: 'actions',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                    orderable: false,
                    searchable: false
                }
            ],
            pageLength: initialLength
        });

        if (!table) return;

        if (lengthSelect) {
            lengthSelect.addEventListener('change', function () {
                const newLength = parseInt(this.value, 10) || initialLength;
                table.page.len(newLength).draw();
            });
        }

        const reloadTable = function () {
            table.ajax.reload(null, false);
        };

        // Auto-filter on change
        [companyFilter, statusFilter].forEach(el => {
            if (el) el.addEventListener('change', reloadTable);
        });

        // Search on typing with debounce
        let searchTimeout;
        if (filterValue) {
            filterValue.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(reloadTable, 500);
            });
        }

        // Reset filters
        if (filterResetBtn) {
            filterResetBtn.addEventListener('click', function () {
                if (filterValue) filterValue.value = '';
                if (companyFilter) companyFilter.value = '';
                if (statusFilter) statusFilter.value = '';
                if (lengthSelect) {
                    lengthSelect.value = String(initialLength);
                    table.page.len(initialLength).draw();
                }
                reloadTable();
            });
        }

        // Refresh button
        if (refreshBtn) {
            refreshBtn.addEventListener('click', reloadTable);
        }

        if (pdfBtn) {
            pdfBtn.addEventListener('click', function () {
                showToast('PDF export functionality not implemented yet', 'info');
            });
        }

        if (exportBtn) {
            exportBtn.addEventListener('click', function () {
                try {
                    const rows = table.rows({ search: 'applied' }).data().toArray();
                    if (!rows.length) {
                        showToast('No data to export', 'error');
                        return;
                    }

                    const headers = ['#', 'Code', 'Name', 'Working Hours', 'Color', 'Apply To', 'Status'];
                    const csvRows = [headers.join(',')];

                    rows.forEach(function (row) {
                        const csvRow = [
                            row.DT_RowIndex,
                            '"' + (row.code || '').replace(/"/g, '""') + '"',
                            '"' + (row.name || '').replace(/"/g, '""') + '"',
                            '"' + (row.formatted_time || '').replace(/"/g, '""') + '"',
                            row.color || '',
                            '"' + (row.applicable_text || '').replace(/"/g, '""') + '"',
                            row.is_active ? 'Active' : 'Inactive'
                        ];
                        csvRows.push(csvRow.join(','));
                    });

                    const blob = new Blob(['\ufeff' + csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = `shifts_${new Date().toISOString().split('T')[0]}.csv`;
                    link.click();
                    URL.revokeObjectURL(link);

                    showToast('Data exported successfully', 'success');
                } catch (error) {
                    showToast('Failed to export data', 'error');
                }
            });
        }

        // Make reloadTable globally available
        window.reloadTable = reloadTable;

        window.erpCrud.handleDelete({
            urlBuilder: function(id) {
                return `{{ route('hr.shifts.destroy', '') }}/${id}`;
            },
            onSuccess: function() {
                reloadTable();
            }
        });
    });

    // Delete shift
    window.deleteShift = function(id, name) {
        window.erpDeleteRecord(id, name);
    };

    // View shift details
    window.viewShift = function(id) {
        const modal = document.getElementById('view-shift-modal');
        const content = document.getElementById('view-shift-content');
        
        // Show loading
        content.innerHTML = `
            <div class="text-center py-8">
                <i data-lucide="loader-2" class="w-8 h-8 mx-auto animate-spin text-slate-400"></i>
                <p class="mt-2 text-slate-500">Loading...</p>
            </div>
        `;
        
        // Open modal
        const modalInstance = tailwind.Modal.getOrCreateInstance(modal);
        modalInstance.show();
        
        // Fetch shift data
        fetch(`{{ url('hr/shifts') }}/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const shift = data.data;
                content.innerHTML = `
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-lg">
                            <div class="w-12 h-12 rounded-full" style="background-color: ${shift.color}"></div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800">${shift.name}</h3>
                                <p class="text-sm text-slate-500">${shift.code}</p>
                            </div>
                            <span class="ml-auto px-3 py-1 rounded-full text-sm font-medium ${shift.is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                                ${shift.is_active ? 'Active' : 'Inactive'}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <p class="text-xs text-blue-600 uppercase tracking-wide">Start Time</p>
                                <p class="text-lg font-semibold text-blue-800">${shift.start_time || '-'}</p>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <p class="text-xs text-blue-600 uppercase tracking-wide">End Time</p>
                                <p class="text-lg font-semibold text-blue-800">${shift.end_time || '-'}</p>
                            </div>
                            <div class="p-3 bg-purple-50 rounded-lg">
                                <p class="text-xs text-purple-600 uppercase tracking-wide">Working Hours</p>
                                <p class="text-lg font-semibold text-purple-800">${shift.working_hours || 8} hrs</p>
                            </div>
                            <div class="p-3 bg-amber-50 rounded-lg">
                                <p class="text-xs text-amber-600 uppercase tracking-wide">Break Hours</p>
                                <p class="text-lg font-semibold text-amber-800">${shift.break_hours || 1} hrs</p>
                            </div>
                        </div>
                        
                        ${shift.description ? `
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Description</p>
                            <p class="text-slate-700">${shift.description}</p>
                        </div>
                        ` : ''}
                        
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Applies To</p>
                            <p class="text-slate-700">${shift.applicable_to === 'company' ? 'Entire Company' : shift.applicable_to === 'department' ? 'Department: ' + (shift.department?.name || '-') : 'Employee: ' + (shift.employee?.full_name || '-')}</p>
                        </div>
                    </div>
                `;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            } else {
                content.innerHTML = '<p class="text-center text-red-500 py-8">Failed to load shift details</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = '<p class="text-center text-red-500 py-8">Error loading shift details</p>';
        });
    };

    // Open edit modal
    window.openEditShiftModal = function(id) {
        const modal = document.getElementById('edit-shift-modal');
        
        // Fetch shift data
        fetch(`{{ url('hr/shifts') }}/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const shift = data.data;
                
                // Populate form
                document.getElementById('edit-shift-id').value = shift.id;
                document.getElementById('edit-shift-code').value = shift.code;
                document.getElementById('edit-shift-name').value = shift.name;
                document.getElementById('edit-shift-description').value = shift.description || '';
                document.getElementById('edit-start-time').value = shift.start_time;
                document.getElementById('edit-end-time').value = shift.end_time;
                document.getElementById('edit-working-hours').value = shift.working_hours;
                document.getElementById('edit-shift-color').value = shift.color;
                document.getElementById('edit-is-active').checked = shift.is_active;
                document.getElementById('edit-break-start').value = shift.break_start || '';
                document.getElementById('edit-break-end').value = shift.break_end || '';
                document.getElementById('edit-break-hours').value = shift.break_hours || 1;
                document.getElementById('edit-applicable-to').value = shift.applicable_to;
                document.getElementById('edit-company-id').value = shift.company_id || '';
                
                // Work days
                document.querySelectorAll('.edit-work-day').forEach(cb => {
                    cb.checked = shift.work_days && shift.work_days.includes(cb.value);
                });
                
                // Show/hide applicable fields
                const applicableTo = shift.applicable_to;
                document.getElementById('edit-department-selection').style.display = 
                    ['department', 'employee'].includes(applicableTo) ? 'block' : 'none';
                document.getElementById('edit-employee-selection').style.display = 
                    applicableTo === 'employee' ? 'block' : 'none';
                
                // Open modal
                const modalInstance = tailwind.Modal.getOrCreateInstance(modal);
                modalInstance.show();
            } else {
                showToast('Failed to load shift data', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error loading shift data', 'error');
        });
    };

    // Submit edit form - prevent double submission
    let isEditSubmitting = false;
    window.submitEditShiftForm = function() {
        if (isEditSubmitting) return;
        isEditSubmitting = true;

        const form = document.getElementById('edit-shift-form');
        const id = document.getElementById('edit-shift-id').value;
        const formData = new FormData(form);
        
        const data = {};
        const workDays = [];
        
        for (let [key, value] of formData.entries()) {
            if (key === 'work_days[]') {
                workDays.push(value);
            } else {
                data[key] = value;
            }
        }
        data.work_days = workDays;
        data.is_active = document.getElementById('edit-is-active').checked;
        
        // Calculate working hours
        const startTime = data.start_time;
        const endTime = data.end_time;
        if (startTime && endTime) {
            const [sh, sm] = startTime.split(':').map(Number);
            const [eh, em] = endTime.split(':').map(Number);
            const startMinutes = sh * 60 + sm;
            let endMinutes = eh * 60 + em;
            if (endMinutes <= startMinutes) endMinutes += 24 * 60;
            data.working_hours = Math.round((endMinutes - startMinutes) / 60 * 2) / 2;
        }
        
        fetch(`{{ url('hr/shifts') }}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || 'Shift updated successfully', 'success');
                if (window.refreshNotifications) window.refreshNotifications();
                try {
                    tailwind.Modal.getInstance(document.getElementById('edit-shift-modal'))?.hide();
                } catch(e) {}
                reloadTable();
            } else {
                showToast(data.message || 'Failed to update shift', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error updating shift', 'error');
        })
        .finally(() => {
            isEditSubmitting = false;
        });
    };

    // Toggle shift status
    window.toggleShiftStatus = function(id) {
        fetch(`{{ url('hr/shifts') }}/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                if (window.refreshNotifications) window.refreshNotifications();
                reloadTable();
            } else {
                showToast(data.message || 'Failed to update shift status', 'error');
            }
        })
        .catch(() => {
            showToast('An error occurred while updating', 'error');
        });
    };
    </script>
@endpush
