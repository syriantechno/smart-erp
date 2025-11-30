@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Payroll Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
@include('components.global-notifications')
<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="wallet" class="w-7 h-7" />
            <span>Payroll Management</span>
        </h2>

        <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
            {{-- Total Net --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                        <x-base.lucide icon="banknote" class="w-4 h-4" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight" style="color: #303030" id="stat-total-net">
                        {{ number_format($summary['total_net'] ?? 0, 0) }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                    Total Net
                </div>
            </div>

            {{-- Pending --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                        <x-base.lucide icon="clock" class="w-4 h-4" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight" style="color: #303030" id="stat-pending">
                        {{ $summary['pending_count'] ?? 0 }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                    Pending
                </div>
            </div>

            {{-- Approved --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                        <x-base.lucide icon="check-circle" class="w-4 h-4" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight" style="color: #303030" id="stat-approved">
                        {{ $summary['approved_count'] ?? 0 }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                    Approved
                </div>
            </div>

            {{-- Paid --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                        <x-base.lucide icon="badge-check" class="w-4 h-4" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight" style="color: #303030" id="stat-paid">
                        {{ $summary['paid_count'] ?? 0 }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                    Paid
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12">
        <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
            <div class="p-5">
                {{-- Filters --}}
                <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between mb-6">
                    <div class="flex flex-wrap items-end gap-3">
                        {{-- Month --}}
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Month</label>
                            <x-base.form-select id="filter-month" class="w-32">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endfor
                            </x-base.form-select>
                        </div>

                        {{-- Year --}}
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Year</label>
                            <x-base.form-select id="filter-year" class="w-24">
                                @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </x-base.form-select>
                        </div>

                        {{-- Department --}}
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Department</label>
                            <x-base.form-select id="filter-department" class="w-40">
                                <option value="">All Departments</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Status</label>
                            <x-base.form-select id="filter-status" class="w-32">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="paid">Paid</option>
                            </x-base.form-select>
                        </div>

                        {{-- Search --}}
                        <div>
                            <label class="text-xs text-slate-500 mb-1 block">Search</label>
                            <x-base.form-input id="filter-search" type="text" placeholder="Search employee..." class="w-48" />
                        </div>

                        {{-- Filter Button --}}
                        <button id="btn-filter" type="button" class="btn-royal btn-royal--dark btn-royal--sm">
                            <x-base.lucide icon="filter" class="w-4 h-4 mr-1" />
                            Filter
                        </button>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <x-base.tippy content="Export" placement="bottom">
                            <button id="btn-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm group">
                                <x-base.lucide icon="download" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="Bulk Approve" placement="bottom">
                            <button id="btn-bulk-approve" type="button" class="btn-royal btn-royal--outline btn-royal--sm group">
                                <x-base.lucide icon="check-check" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="Bulk Mark Paid" placement="bottom">
                            <button id="btn-bulk-paid" type="button" class="btn-royal btn-royal--outline btn-royal--sm group">
                                <x-base.lucide icon="credit-card" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        <button id="btn-generate" type="button" class="btn-royal btn-royal--gold">
                            <x-base.lucide icon="calculator" class="w-5 h-5 mr-2" />
                            Generate Payroll
                        </button>
                    </div>
                </div>

                {{-- Summary Bar --}}
                <div class="flex flex-wrap items-center gap-6 mb-4 p-4 bg-slate-50 rounded-lg text-sm">
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500">Employees:</span>
                        <span class="font-bold" id="summary-employees">0</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500">Earned Salary:</span>
                        <span class="font-bold text-slate-700" id="summary-earned">0</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500">Overtime:</span>
                        <span class="font-bold text-green-600" id="summary-overtime">0</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500">Deductions:</span>
                        <span class="font-bold text-red-600" id="summary-deductions">0</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500">Installments:</span>
                        <span class="font-bold text-orange-500" id="summary-installments">0</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500">Net Total:</span>
                        <span class="font-bold text-primary" id="summary-net">0</span>
                    </div>
                </div>

                {{-- DataTable --}}
                <div class="overflow-x-auto sm:overflow-visible mt-5" data-erp-table-wrapper>
                    <table id="payroll-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">
                                    <input type="checkbox" id="check-all" class="form-check-input">
                                </th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Employee</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Days</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Earned Salary</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">OT Hours</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">OT Amount</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Deductions</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Installments</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Net Salary</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="payroll-tbody">
                            {{-- Data loaded via AJAX --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </x-base.preview-component>
    </div>
</div>

{{-- Generate Modal --}}
@include('hr.payroll.modals.generate')

{{-- Details Modal --}}
@include('hr.payroll.modals.details')

{{-- Edit Modal --}}
@include('hr.payroll.modals.edit')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let currentMonth = {{ $month }};
    let currentYear = {{ $year }};
    let selectedIds = [];

    const urls = {
        data: '{{ route("hr.payroll.data") }}',
        generate: '{{ route("hr.payroll.generate") }}',
        bulkApprove: '{{ route("hr.payroll.bulk-approve") }}',
        bulkPaid: '{{ route("hr.payroll.bulk-paid") }}',
    };

    // Load data
    function loadPayrollData() {
        const params = new URLSearchParams({
            year: currentYear,
            month: currentMonth,
            department_id: document.getElementById('filter-department').value,
            status: document.getElementById('filter-status').value,
            search_term: document.getElementById('filter-search').value,
        });

        fetch(`${urls.data}?${params}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderTable(data.data);
                updateSummary(data.summary);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function renderTable(data) {
        const tbody = document.getElementById('payroll-tbody');
        
        if (!data.length) {
            tbody.innerHTML = '<tr><td colspan="10" class="text-center py-8 text-slate-500">No payroll records found. Click "Generate Payroll" to create.</td></tr>';
            return;
        }

        const statusConfig = {
            pending: { color: 'text-amber-600', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>', label: 'Pending' },
            approved: { color: 'text-sky-600', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>', label: 'Approved' },
            paid: { color: 'text-lime-600', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>', label: 'Paid' },
            cancelled: { color: 'text-rose-500', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>', label: 'Cancelled' }
        };

        let html = '';
        data.forEach(row => {
            html += `<tr data-tw-merge class="[&_td]:last:border-b-0 intro-x" data-id="${row.id}">
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                    <input type="checkbox" class="form-check-input payroll-check" value="${row.id}">
                </td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                    <div class="flex items-center gap-2">
                        ${row.employee.photo 
                            ? `<img src="${row.employee.photo}" alt="${row.employee.name}" class="w-8 h-8 rounded-full object-cover">`
                            : `<div class="w-8 h-8 rounded-full bg-slate-600 flex items-center justify-center text-white text-xs font-bold">${row.employee.name.charAt(0)}</div>`
                        }
                        <div>
                            <div class="font-medium whitespace-nowrap">${row.employee.name}</div>
                            <div class="text-xs text-slate-500 mt-0.5">${row.employee.department}</div>
                        </div>
                    </div>
                </td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                    <span class="font-medium">${row.actual_working_days}</span>
                    <span class="text-slate-400">/ ${row.working_days}</span>
                </td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-right font-medium">${row.earned_salary}</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">${row.overtime_hours}h</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-right text-lime-600 font-medium">${row.overtime_amount}</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-right text-rose-500 font-medium">${row.deductions}</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-right text-orange-500 font-medium">${row.installments || '0.00'}</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-right font-bold">${row.net_salary}</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                    <span class="inline-flex items-center text-base font-semibold ${statusConfig[row.status]?.color || 'text-slate-500'}">
                        ${statusConfig[row.status]?.icon || ''}
                        ${statusConfig[row.status]?.label || row.status_label}
                    </span>
                </td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                    <div class="flex items-center justify-center gap-1">
                        <button type="button" class="btn-view p-1.5 rounded hover:bg-slate-100 text-slate-600 hover:text-primary transition-colors" data-id="${row.id}" title="View Details">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                        ${row.status === 'pending' ? `
                            <button type="button" class="btn-edit p-1.5 rounded hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition-colors" data-id="${row.id}" title="Edit">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </button>
                            <button type="button" class="btn-approve p-1.5 rounded hover:bg-green-50 text-slate-600 hover:text-green-600 transition-colors" data-id="${row.id}" title="Approve">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </button>
                        ` : ''}
                        ${row.status === 'approved' ? `
                            <button type="button" class="btn-paid p-1.5 rounded hover:bg-green-50 text-slate-600 hover:text-green-600 transition-colors" data-id="${row.id}" title="Mark Paid">
                                <i data-lucide="credit-card" class="w-4 h-4"></i>
                            </button>
                        ` : ''}
                        <button type="button" class="btn-print p-1.5 rounded hover:bg-slate-100 text-slate-600 hover:text-primary transition-colors" data-id="${row.id}" title="Print Payslip">
                            <i data-lucide="printer" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
        });

        tbody.innerHTML = html;
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Attach event listeners
        attachRowListeners();
    }

    function updateSummary(summary) {
        document.getElementById('summary-employees').textContent = summary.total_employees;
        document.getElementById('summary-earned').textContent = summary.total_earned;
        document.getElementById('summary-overtime').textContent = summary.total_overtime;
        document.getElementById('summary-deductions').textContent = summary.total_deductions;
        document.getElementById('summary-installments').textContent = summary.total_installments;
        document.getElementById('summary-net').textContent = summary.total_net;
        
        document.getElementById('stat-pending').textContent = summary.pending_count;
        document.getElementById('stat-approved').textContent = summary.approved_count;
        document.getElementById('stat-paid').textContent = summary.paid_count;
    }

    function attachRowListeners() {
        // View details
        document.querySelectorAll('.btn-view').forEach(btn => {
            btn.addEventListener('click', function() {
                viewPayroll(this.dataset.id);
            });
        });

        // Approve
        document.querySelectorAll('.btn-approve').forEach(btn => {
            btn.addEventListener('click', function() {
                approvePayroll(this.dataset.id);
            });
        });

        // Mark paid
        document.querySelectorAll('.btn-paid').forEach(btn => {
            btn.addEventListener('click', function() {
                markPaid(this.dataset.id);
            });
        });

        // Print
        document.querySelectorAll('.btn-print').forEach(btn => {
            btn.addEventListener('click', function() {
                window.open(`/hr/payroll/${this.dataset.id}/payslip`, '_blank');
            });
        });

        // Checkboxes
        document.querySelectorAll('.payroll-check').forEach(cb => {
            cb.addEventListener('change', updateSelectedIds);
        });
    }

    function updateSelectedIds() {
        selectedIds = Array.from(document.querySelectorAll('.payroll-check:checked')).map(cb => cb.value);
    }

    // Generate payroll
    document.getElementById('btn-generate').addEventListener('click', function() {
        const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('generate-modal'));
        document.getElementById('generate-month').value = currentMonth;
        document.getElementById('generate-year').value = currentYear;
        modal.show();
    });

    document.getElementById('generate-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('btn-submit-generate');
        btn.disabled = true;
        btn.innerHTML = 'Generating...';

        const formData = new FormData(this);

        fetch(urls.generate, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showSuccess && showSuccess(data.message);
                tailwind.Modal.getInstance(document.getElementById('generate-modal')).hide();
                loadPayrollData();
            } else {
                window.showError && showError(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showError && showError('An error occurred');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i data-lucide="calculator" class="w-4 h-4 mr-2"></i> Generate';
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    });

    // Filter
    document.getElementById('btn-filter').addEventListener('click', function() {
        currentMonth = document.getElementById('filter-month').value;
        currentYear = document.getElementById('filter-year').value;
        loadPayrollData();
    });

    // Check all
    document.getElementById('check-all').addEventListener('change', function() {
        document.querySelectorAll('.payroll-check').forEach(cb => {
            cb.checked = this.checked;
        });
        updateSelectedIds();
    });

    // Bulk approve
    document.getElementById('btn-bulk-approve').addEventListener('click', function() {
        if (!selectedIds.length) {
            window.showWarning && showWarning('Please select payrolls to approve');
            return;
        }

        fetch(urls.bulkApprove, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ payroll_ids: selectedIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showSuccess && showSuccess(data.message);
                loadPayrollData();
            } else {
                window.showError && showError(data.message);
            }
        });
    });

    // Bulk paid
    document.getElementById('btn-bulk-paid').addEventListener('click', function() {
        if (!selectedIds.length) {
            window.showWarning && showWarning('Please select payrolls to mark as paid');
            return;
        }

        fetch(urls.bulkPaid, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ payroll_ids: selectedIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showSuccess && showSuccess(data.message);
                loadPayrollData();
            } else {
                window.showError && showError(data.message);
            }
        });
    });

    function viewPayroll(id) {
        fetch(`/hr/payroll/${id}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateDetailsModal(data.data);
                tailwind.Modal.getOrCreateInstance(document.getElementById('details-modal')).show();
            }
        });
    }

    function approvePayroll(id) {
        confirmApprove('this payroll', () => {
            fetch(`/hr/payroll/${id}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.showSuccess && showSuccess(data.message);
                    loadPayrollData();
                } else {
                    window.showError && showError(data.message);
                }
            });
        });
    }

    function markPaid(id) {
        confirmPayment('this payroll', () => {
            fetch(`/hr/payroll/${id}/mark-paid`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.showSuccess && showSuccess(data.message);
                    loadPayrollData();
                } else {
                    window.showError && showError(data.message);
                }
            });
        });
    }

    function populateDetailsModal(data) {
        document.getElementById('detail-employee').textContent = data.employee.name;
        document.getElementById('detail-department').textContent = data.employee.department;
        document.getElementById('detail-period').textContent = data.period;
        document.getElementById('detail-basic').textContent = parseFloat(data.basic_salary).toFixed(2);
        document.getElementById('detail-hourly-rate').textContent = parseFloat(data.hourly_rate).toFixed(2);
        document.getElementById('detail-working-days').textContent = `${data.actual_working_days} / ${data.working_days}`;
        document.getElementById('detail-overtime-hours').textContent = (parseFloat(data.overtime_hours) + parseFloat(data.weekend_overtime_hours)).toFixed(1);
        document.getElementById('detail-overtime-amount').textContent = parseFloat(data.total_overtime_amount).toFixed(2);
        document.getElementById('detail-absent').textContent = `${data.absent_days} days (-${parseFloat(data.absent_deduction).toFixed(2)})`;
        document.getElementById('detail-deductions').textContent = parseFloat(data.deductions).toFixed(2);
        document.getElementById('detail-bonuses').textContent = parseFloat(data.bonuses).toFixed(2);
        document.getElementById('detail-net').textContent = parseFloat(data.net_salary).toFixed(2);
        document.getElementById('detail-status').textContent = data.status_label;
    }

    // Initial load
    loadPayrollData();
});
</script>
@endpush
