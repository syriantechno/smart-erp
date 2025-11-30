@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@php
    $leaveTypes = $leaveTypes ?? [
        'annual' => 'Annual Leave',
        'sick' => 'Sick Leave',
        'unpaid' => 'Unpaid Leave',
        'emergency' => 'Emergency Leave',
        'maternity' => 'Maternity / Paternity',
    ];

    $leaveReasons = $leaveReasons ?? [
        'vacation' => 'Vacation & Travel',
        'medical' => 'Medical Appointment',
        'family' => 'Family Obligation',
        'remote' => 'Remote Work Request',
        'other' => 'Other Reason',
    ];

    $leaveStatuses = $leaveStatuses ?? [
        'pending' => 'Pending Review',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ];

    $employees = $employees ?? collect();
@endphp

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
@endpush

@section('subcontent')
<div
    id="leave-page"
    data-leave-datatable-url="{{ route('hr.leave.datatable') }}"
    data-leave-summary-url="{{ route('hr.leave.summary') }}"
    data-leave-preview-url="{{ route('hr.leave.preview-code') }}"
    data-leave-base-url="{{ route('hr.leave.index') }}"
>
{{-- Heading + top stats strip on the same row (like Employees) --}}
<div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="calendar-off" class="w-7 h-7" />
            <span>Leave Management</span>
        </h2>

        <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
            {{-- Rejected --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-red-100 px-1.5 py-1">
                        <x-base.lucide icon="x-circle" class="w-4 h-4 text-red-600" />
                    </div>
                    <div data-leave-rejected class="text-6xl md:text-7xl font-semibold tracking-tight" style="color: #303030;">
                        0
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                    Rejected
                </div>
            </div>

            {{-- Pending --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-amber-100 px-1.5 py-1">
                        <x-base.lucide icon="clock" class="w-4 h-4 text-amber-600" />
                    </div>
                    <div data-leave-pending class="text-6xl md:text-7xl font-semibold tracking-tight" style="color: #303030;">
                        0
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                    Pending
                </div>
            </div>

            {{-- Approved --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-green-100 px-1.5 py-1">
                        <x-base.lucide icon="check-circle" class="w-4 h-4 text-green-600" />
                    </div>
                    <div data-leave-approved class="text-6xl md:text-7xl font-semibold tracking-tight" style="color: #303030;">
                        0
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                    Approved
                </div>
            </div>

            {{-- Total --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                        <x-base.lucide icon="calendar" class="w-4 h-4" />
                    </div>
                    <div data-leave-total class="text-6xl md:text-7xl font-semibold tracking-tight" style="color: #303030;">
                        0
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                    Total
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="col-span-12">

            <!-- Main Content Card -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    {{-- Filters & Actions in One Row --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Search Input --}}
                        <div class="relative min-w-[180px]">
                            <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <x-base.form-input 
                                id="leave-filter-value" 
                                type="text" 
                                placeholder="Search..." 
                                class="pl-9 w-full text-sm py-1.5"
                            />
                        </div>

                        {{-- Leave Type Filter --}}
                        <x-base.form-select id="leave-filter-type-select" class="w-auto text-sm py-1.5">
                            <option value="">All Types</option>
                            @foreach ($leaveTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </x-base.form-select>

                        {{-- Status Filter --}}
                        <x-base.form-select id="leave-filter-status" class="w-auto text-sm py-1.5">
                            <option value="">All Status</option>
                            @foreach ($leaveStatuses as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </x-base.form-select>

                        {{-- Date From --}}
                        <div class="relative w-36">
                            <div class="absolute flex h-full w-8 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                <x-base.lucide icon="calendar" class="stroke-1.5 w-4 h-4"></x-base.lucide>
                            </div>
                            <x-base.litepicker
                                id="leave-filter-from"
                                class="pl-9 text-sm py-1.5"
                                placeholder="From"
                                data-single-mode="true"
                                data-format="YYYY-MM-DD"
                                data-auto-apply="false"
                                value=""
                            />
                        </div>

                        {{-- Date To --}}
                        <div class="relative w-36">
                            <div class="absolute flex h-full w-8 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                <x-base.lucide icon="calendar" class="stroke-1.5 w-4 h-4"></x-base.lucide>
                            </div>
                            <x-base.litepicker
                                id="leave-filter-to"
                                class="pl-9 text-sm py-1.5"
                                placeholder="To"
                                data-single-mode="true"
                                data-format="YYYY-MM-DD"
                                data-auto-apply="false"
                                value=""
                            />
                        </div>

                        {{-- Hidden fields for compatibility --}}
                        <input type="hidden" id="leave-filter-field" value="all">
                        <input type="hidden" id="leave-filter-type" value="contains">

                        {{-- Reset Button --}}
                        <x-base.tippy as="button" id="leave-filter-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="leave-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-text" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export Excel" placement="bottom">
                                <button id="leave-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="leave-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Leave Button --}}
                            <x-base.tippy content="Add leave request" placement="bottom">
                                <button
                                    type="button"
                                    class="btn-royal btn-royal--gold btn-royal--sm"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-leave-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-4 h-4 mr-2" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="leave-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Request</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Employee</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Period</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Reason</th>
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

    @include('hr.leave.modals.create', compact('leaveTypes', 'leaveReasons', 'leaveStatuses', 'employees'))
    @include('hr.leave.modals.edit', compact('leaveTypes', 'leaveReasons', 'leaveStatuses', 'employees'))
    <button id="open-edit-leave-modal" data-tw-toggle="modal" data-tw-target="#edit-leave-modal" class="hidden"></button>
</div>
@endsection

@stack('modals')
@include('components.datatable.scripts')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
<script>
// Leave Page JavaScript - using erpCrud like Positions
(function() {
    const tableEl = document.getElementById('leave-table');
    if (!tableEl) return;

    const datatableUrl = '{{ route("hr.leave.datatable") }}';
    const summaryUrl = '{{ route("hr.leave.summary") }}';
    const baseUrl = '{{ route("hr.leave.index") }}';
    const csrf = '{{ csrf_token() }}';

    // Filter elements
    const filterValue = document.getElementById('leave-filter-value');
    const typeSelect = document.getElementById('leave-filter-type-select');
    const statusSelect = document.getElementById('leave-filter-status');
    const fromInput = document.getElementById('leave-filter-from');
    const toInput = document.getElementById('leave-filter-to');
    const filterResetBtn = document.getElementById('leave-filter-reset');
    const refreshBtn = document.getElementById('leave-refresh');

    let searchTimeout = null;

    const waitForDependencies = () => {
        if (typeof window.jQuery === 'undefined') {
            console.log('Waiting for jQuery...');
            setTimeout(waitForDependencies, 100);
            return;
        }

        if (typeof window.erpCrud?.initDataTable !== 'function') {
            console.log('Waiting for erpCrud...');
            setTimeout(waitForDependencies, 100);
            return;
        }

        const $ = window.jQuery;

        // Check if already initialized
        if ($.fn.DataTable.isDataTable('#leave-table')) {
            console.log('Leave table already initialized');
            return;
        }

        console.log('Initializing Leave DataTable with URL:', datatableUrl);

        // Clear any default values from Litepicker
        if (fromInput) fromInput.value = '';
        if (toInput) toInput.value = '';

        // Use erpCrud.initDataTable like Positions
        const tableInstance = window.erpCrud.initDataTable({
            tableSelector: '#leave-table',
            ajaxUrl: datatableUrl,
            ajaxData: function(d) {
                d.filter_field = 'all';
                d.filter_type = 'contains';
                d.filter_value = filterValue?.value?.trim() || '';
                d.filter_leave_type = typeSelect?.value || '';
                d.filter_status = statusSelect?.value || '';
                d.filter_from = fromInput?.value || '';
                d.filter_to = toInput?.value || '';
            },
            pageLength: 10,
            columns: [
                { data: 'request', name: 'code', className: 'px-5 py-1.5 border-b dark:border-darkmode-300' },
                { data: 'employee', name: 'employee', className: 'px-5 py-1.5 border-b dark:border-darkmode-300' },
                { data: 'period', name: 'start_date', className: 'px-5 py-1.5 border-b dark:border-darkmode-300' },
                { data: 'reason', name: 'reason_category', className: 'px-5 py-1.5 border-b dark:border-darkmode-300' },
                { data: 'status', name: 'status', className: 'px-5 py-1.5 border-b dark:border-darkmode-300 text-center' },
                { data: 'actions', name: 'actions', className: 'px-5 py-1.5 border-b dark:border-darkmode-300 text-center', orderable: false, searchable: false }
            ]
        });

        if (!tableInstance) {
            console.error('Failed to initialize Leave DataTable');
            return;
        }

        // Load summary
        const loadSummary = () => {
            fetch(summaryUrl, { headers: { Accept: 'application/json' } })
                .then(r => r.json())
                .then(data => {
                    if (data.success && data.data) {
                        $('[data-leave-total]').text(data.data.total || 0);
                        $('[data-leave-approved]').text(data.data.approved || 0);
                        $('[data-leave-pending]').text(data.data.pending || 0);
                        $('[data-leave-rejected]').text(data.data.rejected || 0);
                    }
                })
                .catch(() => {});
        };

        loadSummary();

        const reloadTable = () => {
            tableInstance.ajax.reload(null, false);
            loadSummary();
        };

        // Search with debounce
        filterValue?.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(reloadTable, 400);
        });

        // Instant filter on dropdown change
        typeSelect?.addEventListener('change', reloadTable);
        statusSelect?.addEventListener('change', reloadTable);
        
        // Litepicker inputs - use input event and polling
        const setupDateFilter = (input) => {
            if (!input) return;
            input.addEventListener('input', reloadTable);
            input.addEventListener('change', reloadTable);
            // Poll for Litepicker changes
            let lastVal = input.value;
            setInterval(() => {
                if (input.value !== lastVal) {
                    lastVal = input.value;
                    reloadTable();
                }
            }, 500);
        };
        setupDateFilter(fromInput);
        setupDateFilter(toInput);

        filterResetBtn?.addEventListener('click', () => {
            if (filterValue) filterValue.value = '';
            if (typeSelect) typeSelect.value = '';
            if (statusSelect) statusSelect.value = '';
            if (fromInput) {
                fromInput.value = '';
                // Trigger Litepicker clear if available
                if (fromInput._litepicker) fromInput._litepicker.clearSelection();
            }
            if (toInput) {
                toInput.value = '';
                if (toInput._litepicker) toInput._litepicker.clearSelection();
            }
            reloadTable();
        });

        refreshBtn?.addEventListener('click', reloadTable);

        // Leave UI functions
        window.leaveUI = window.leaveUI || {};

        // View leave (read-only)
        window.leaveUI.view = function(id) {
            fetch(baseUrl + '/' + id, {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.data) {
                    const leave = data.data;
                    // Populate edit modal in read-only mode
                    populateEditModal(leave, true);
                    document.getElementById('open-edit-leave-modal')?.click();
                }
            })
            .catch(err => console.error('Failed to load leave:', err));
        };

        // Edit leave
        window.leaveUI.edit = function(id) {
            fetch(baseUrl + '/' + id, {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.data) {
                    const leave = data.data;
                    populateEditModal(leave, false);
                    document.getElementById('open-edit-leave-modal')?.click();
                }
            })
            .catch(err => console.error('Failed to load leave:', err));
        };

        // Helper to populate edit modal
        function populateEditModal(leave, readOnly) {
            const form = document.getElementById('edit-leave-form');
            if (!form) return;
            
            form.action = baseUrl + '/' + leave.id;
            form.querySelector('[name="id"]').value = leave.id;
            
            document.getElementById('edit-leave-code').value = leave.code || '';
            document.getElementById('edit-leave-employee-id').value = leave.employee_id || '';
            document.getElementById('edit-leave-type').value = leave.leave_type || '';
            document.getElementById('edit-leave-reason').value = leave.reason_category || '';
            document.getElementById('edit-leave-start-date').value = leave.start_date || '';
            document.getElementById('edit-leave-end-date').value = leave.end_date || '';
            document.getElementById('edit-leave-days').value = leave.days_count || '';
            document.getElementById('edit-leave-reason-details').value = leave.reason_details || '';
            document.getElementById('edit-leave-notes').value = leave.notes || '';
            document.getElementById('edit-leave-status').value = leave.status || 'pending';
            document.getElementById('edit-leave-paid').checked = leave.is_paid;
            
            // Update employee meta
            const empSelect = document.getElementById('edit-leave-employee-id');
            const selectedOption = empSelect?.options[empSelect.selectedIndex];
            if (selectedOption) {
                const meta = document.getElementById('edit-leave-employee-meta');
                if (meta) {
                    meta.textContent = `${selectedOption.dataset.department || ''} - ${selectedOption.dataset.company || ''}`;
                }
            }
            
            // Toggle read-only mode
            const submitBtn = form.closest('.modal-content')?.querySelector('[type="submit"]');
            if (submitBtn) {
                submitBtn.style.display = readOnly ? 'none' : '';
            }
            
            // Disable/enable form fields
            const fields = form.querySelectorAll('input:not([type="hidden"]), select, textarea');
            fields.forEach(field => {
                if (field.id !== 'edit-leave-code') { // code is always readonly
                    field.disabled = readOnly;
                }
            });
        }

        window.leaveUI.delete = function(id, code) {
            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(code, function() {
                    fetch(baseUrl + '/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            if (typeof showToast === 'function') showToast('Leave deleted', 'success');
                            if (typeof window.refreshNotifications === 'function') window.refreshNotifications();
                            reloadTable();
                        } else {
                            if (typeof showToast === 'function') showToast(data.message || 'Failed', 'error');
                        }
                    });
                });
            }
        };

        window.leaveUI.approve = function(id) {
            fetch(baseUrl + '/' + id, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: 'approved' })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    if (typeof showToast === 'function') showToast('Leave approved', 'success');
                    if (typeof window.refreshNotifications === 'function') window.refreshNotifications();
                    reloadTable();
                } else {
                    if (typeof showToast === 'function') showToast(data.message || 'Failed', 'error');
                }
            });
        };

        window.leaveUI.reject = function(id) {
            fetch(baseUrl + '/' + id, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: 'rejected' })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    if (typeof showToast === 'function') showToast('Leave rejected', 'warning');
                    if (typeof window.refreshNotifications === 'function') window.refreshNotifications();
                    reloadTable();
                } else {
                    if (typeof showToast === 'function') showToast(data.message || 'Failed', 'error');
                }
            });
        };

        // Load preview code when create modal opens
        const createModal = document.getElementById('create-leave-modal');
        const codeInput = document.getElementById('create-leave-code');
        const previewCodeUrl = '{{ route("hr.leave.preview-code") }}';
        
        if (createModal && codeInput) {
            createModal.addEventListener('shown.tw.modal', function() {
                fetch(previewCodeUrl, { headers: { Accept: 'application/json' } })
                    .then(r => r.json())
                    .then(data => {
                        if (data.code) {
                            codeInput.value = data.code;
                        }
                    })
                    .catch(err => console.error('Failed to load preview code:', err));
            });
        }

        // Calculate days when dates change
        const startDateInput = document.getElementById('create-leave-start-date');
        const endDateInput = document.getElementById('create-leave-end-date');
        const daysInput = document.getElementById('create-leave-days');

        const calculateDays = () => {
            const startVal = startDateInput?.value;
            const endVal = endDateInput?.value;
            
            console.log('Calculating days:', startVal, endVal);
            
            if (startVal && endVal) {
                const start = new Date(startVal);
                const end = new Date(endVal);
                const diffTime = end - start;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                if (daysInput && diffDays > 0) {
                    daysInput.value = diffDays;
                } else if (daysInput) {
                    daysInput.value = '';
                }
            }
        };

        // Listen for input events (Litepicker triggers these)
        startDateInput?.addEventListener('input', calculateDays);
        endDateInput?.addEventListener('input', calculateDays);
        startDateInput?.addEventListener('change', calculateDays);
        endDateInput?.addEventListener('change', calculateDays);

        // Also use MutationObserver to detect value changes
        const observeDateInput = (input) => {
            if (!input) return;
            const observer = new MutationObserver(() => calculateDays());
            observer.observe(input, { attributes: true, attributeFilter: ['value'] });
            
            // Also poll for changes (fallback)
            let lastValue = input.value;
            setInterval(() => {
                if (input.value !== lastValue) {
                    lastValue = input.value;
                    calculateDays();
                }
            }, 500);
        };
        
        observeDateInput(startDateInput);
        observeDateInput(endDateInput);

        // Handle create form submission
        const createForm = document.getElementById('create-leave-form');
        if (createForm) {
            createForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate required fields
                const employeeId = document.getElementById('create-leave-employee-id')?.value;
                const leaveType = document.getElementById('create-leave-type')?.value;
                const startDate = startDateInput?.value;
                const endDate = endDateInput?.value;
                
                if (!employeeId) {
                    if (typeof showToast === 'function') showToast('Please select an employee', 'error');
                    return;
                }
                if (!leaveType) {
                    if (typeof showToast === 'function') showToast('Please select leave type', 'error');
                    return;
                }
                if (!startDate) {
                    if (typeof showToast === 'function') showToast('Please select start date', 'error');
                    return;
                }
                if (!endDate) {
                    if (typeof showToast === 'function') showToast('Please select end date', 'error');
                    return;
                }
                
                const formData = new FormData(this);
                
                // Debug: log form data
                console.log('Submitting leave form:');
                for (let [key, value] of formData.entries()) {
                    console.log(key + ': ' + value);
                }
                
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(r => r.json())
                .then(data => {
                    console.log('Response:', data);
                    if (data.success) {
                        if (typeof showToast === 'function') showToast(data.message || 'Leave created', 'success');
                        if (typeof window.refreshNotifications === 'function') window.refreshNotifications();
                        reloadTable();
                        // Close modal
                        const modal = tailwind.Modal.getOrCreateInstance(createModal);
                        modal.hide();
                        // Reset form
                        createForm.reset();
                        if (daysInput) daysInput.value = '';
                    } else {
                        if (typeof showToast === 'function') showToast(data.message || 'Failed to create leave', 'error');
                    }
                })
                .catch(err => {
                    console.error('Create leave error:', err);
                    if (typeof showToast === 'function') showToast('An error occurred', 'error');
                });
            });
        }

        // Handle edit form submission
        const editForm = document.getElementById('edit-leave-form');
        const editModal = document.getElementById('edit-leave-modal');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Convert is_paid checkbox
                const isPaidCheckbox = document.getElementById('edit-leave-paid');
                const formData = new FormData(this);
                formData.set('is_paid', isPaidCheckbox?.checked ? '1' : '0');
                
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        if (typeof showToast === 'function') showToast(data.message || 'Leave updated', 'success');
                        if (typeof window.refreshNotifications === 'function') window.refreshNotifications();
                        reloadTable();
                        // Close modal
                        const modal = tailwind.Modal.getOrCreateInstance(editModal);
                        modal.hide();
                    } else {
                        if (typeof showToast === 'function') showToast(data.message || 'Failed to update leave', 'error');
                    }
                })
                .catch(err => {
                    console.error('Update leave error:', err);
                    if (typeof showToast === 'function') showToast('An error occurred', 'error');
                });
            });
        }

        console.log('✅ Leave DataTable initialized');
    };

    waitForDependencies();
})();
</script>
@endpush
