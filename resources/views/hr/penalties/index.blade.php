@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Penalties & Warnings - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
@include('components.global-notifications')
<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="alert-triangle" class="w-7 h-7" />
            <span>Penalties & Warnings</span>
        </h2>

        <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight" style="color: #303030" id="stat-total">0</div>
                </div>
                <div class="text-xs uppercase tracking-[0.25em] text-slate-600">Total</div>
            </div>
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-yellow-600" id="stat-written">0</div>
                </div>
                <div class="text-xs uppercase tracking-[0.25em] text-slate-600">Written</div>
            </div>
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-red-600" id="stat-financial">0</div>
                </div>
                <div class="text-xs uppercase tracking-[0.25em] text-slate-600">Financial</div>
            </div>
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-red-700" id="stat-amount">0</div>
                </div>
                <div class="text-xs uppercase tracking-[0.25em] text-slate-600">Total Amount</div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12">
        <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
            <div class="p-5">
                {{-- Filters --}}
                <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                    <form id="filter-form" class="w-full sm:mr-auto xl:flex">
                        <div class="items-center sm:mr-4 sm:flex">
                            <label class="mr-2 w-20 flex-none xl:w-auto xl:flex-initial">Employee</label>
                            <x-base.form-select id="filter-employee" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                <option value="">All Employees</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->full_name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                            <label class="mr-2 w-12 flex-none xl:w-auto xl:flex-initial">Type</label>
                            <x-base.form-select id="filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                <option value="">All Types</option>
                                <option value="written">Written</option>
                                <option value="financial">Financial</option>
                            </x-base.form-select>
                        </div>
                        <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                            <label class="mr-2 w-12 flex-none xl:w-auto xl:flex-initial">Status</label>
                            <x-base.form-select id="filter-status" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="applied">Applied</option>
                            </x-base.form-select>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2 xl:mt-0">
                            <x-base.tippy as="button" id="btn-filter" type="button" content="Apply filters" class="btn-royal btn-royal--dark btn-royal--sm">
                                <x-base.lucide icon="search" class="w-4 h-4" /> Go
                            </x-base.tippy>
                            <x-base.tippy as="button" id="btn-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm">
                                <x-base.lucide icon="rotate-ccw" class="w-4 h-4" />
                            </x-base.tippy>
                        </div>
                    </form>
                    <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                        <x-base.tippy content="Refresh" placement="bottom">
                            <button id="btn-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm group text-royalDark">
                                <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="Add new penalty" placement="bottom">
                            <button id="btn-add" type="button" class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group">
                                <x-base.lucide icon="plus" class="w-4 h-4 mr-2 icon-hover-rise" />
                                <span class="hidden sm:inline">Add</span>
                            </button>
                        </x-base.tippy>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto sm:overflow-visible mt-5" data-erp-table-wrapper>
                    <table id="penalties-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Employee</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Type</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Severity</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Amount</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Date</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="penalties-tbody"></tbody>
                    </table>
                </div>
            </div>
        </x-base.preview-component>
    </div>
</div>

{{-- Add/Edit Modal --}}
<x-modal.form id="penalty-modal" title="Add Penalty" size="lg">
    <form id="penalty-form">
        <input type="hidden" id="penalty-id" name="id">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>Employee <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="penalty-employee" name="employee_id" required>
                    <option value="">Select Employee</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->full_name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>Type <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="penalty-type" name="type" required>
                    <option value="written">Written Warning</option>
                    <option value="financial">Financial Penalty</option>
                </x-base.form-select>
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>Category <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="penalty-category" name="category" required>
                    <option value="late">Late Arrival</option>
                    <option value="absent">Unauthorized Absence</option>
                    <option value="misconduct">Misconduct</option>
                    <option value="violation">Policy Violation</option>
                    <option value="other">Other</option>
                </x-base.form-select>
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>Severity <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="penalty-severity" name="severity" required>
                    <option value="minor">Minor</option>
                    <option value="moderate">Moderate</option>
                    <option value="major">Major</option>
                    <option value="severe">Severe</option>
                </x-base.form-select>
            </div>
            <div class="col-span-12">
                <x-base.form-label>Title <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="penalty-title" name="title" required />
            </div>
            <div class="col-span-12 md:col-span-6" id="amount-field">
                <x-base.form-label>Amount <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input type="number" id="penalty-amount" name="amount" step="0.01" min="0" />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>Date <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input type="date" id="penalty-date" name="penalty_date" required />
            </div>
            <div class="col-span-12" id="deduct-field">
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="penalty-deduct" name="deduct_from_salary" class="form-check-input">
                    <span>Deduct from next salary</span>
                </label>
            </div>
            <div class="col-span-12">
                <x-base.form-label>Description</x-base.form-label>
                <x-base.form-textarea id="penalty-description" name="description" rows="3" />
            </div>
        </div>
    </form>
    @slot('footer')
        <button type="button" class="btn-royal btn-royal--outline" data-tw-dismiss="modal">Cancel</button>
        <button type="submit" form="penalty-form" class="btn-royal btn-royal--gold">Save</button>
    @endslot
</x-modal.form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function loadData() {
        const params = new URLSearchParams({
            employee_id: document.getElementById('filter-employee').value,
            type: document.getElementById('filter-type').value,
            status: document.getElementById('filter-status').value,
        });

        fetch(`{{ route('hr.penalties.data') }}?${params}`)
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    renderTable(data.data);
                    updateStats(data.summary);
                }
            });
    }

    function renderTable(items) {
        const tbody = document.getElementById('penalties-tbody');
        if (!items.length) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center py-8 text-slate-500">No penalties found</td></tr>';
            return;
        }

        const severityColors = { minor: 'text-blue-600', moderate: 'text-yellow-600', major: 'text-orange-600', severe: 'text-red-600' };
        const severityIcons = {
            minor: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>',
            moderate: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
            major: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
            severe: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>'
        };

        const statusConfig = {
            pending: { color: 'text-amber-600', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>', label: 'Pending' },
            approved: { color: 'text-lime-600', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>', label: 'Approved' },
            rejected: { color: 'text-rose-500', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>', label: 'Rejected' },
            applied: { color: 'text-sky-600', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>', label: 'Applied' }
        };

        tbody.innerHTML = items.map(p => `
            <tr data-tw-merge class="[&_td]:last:border-b-0 intro-x">
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                    <div class="font-medium whitespace-nowrap">${p.employee.name}</div>
                    <div class="text-xs text-slate-500 mt-0.5">${p.employee.department}</div>
                </td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                    <span class="inline-flex items-center text-sm font-semibold ${p.type === 'financial' ? 'text-rose-500' : 'text-amber-600'}">
                        ${p.type === 'financial' 
                            ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>'
                            : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>'
                        }
                        ${p.type_label}
                    </span>
                </td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">${p.title}</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                    <span class="inline-flex items-center text-sm font-semibold ${severityColors[p.severity]}">
                        ${severityIcons[p.severity]}
                        ${p.severity.charAt(0).toUpperCase() + p.severity.slice(1)}
                    </span>
                </td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-right font-medium ${p.type === 'financial' ? 'text-rose-500' : ''}">${p.type === 'financial' ? p.amount : '-'}</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">${p.penalty_date}</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                    <span class="inline-flex items-center text-base font-semibold ${statusConfig[p.status].color}">
                        ${statusConfig[p.status].icon}
                        ${statusConfig[p.status].label}
                    </span>
                </td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                    <div class="flex justify-center gap-1">
                        ${p.status === 'pending' ? `
                            <button class="btn-approve p-1.5 rounded hover:bg-green-50 text-green-600 hover:text-green-800 transition-colors" data-id="${p.id}" title="Approve"><i data-lucide="check" class="w-4 h-4"></i></button>
                            <button class="btn-reject p-1.5 rounded hover:bg-red-50 text-red-600 hover:text-red-800 transition-colors" data-id="${p.id}" title="Reject"><i data-lucide="x" class="w-4 h-4"></i></button>
                        ` : ''}
                        <button class="btn-delete p-1.5 rounded hover:bg-red-50 text-slate-500 hover:text-red-600 transition-colors" data-id="${p.id}" title="Delete"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </div>
                </td>
            </tr>
        `).join('');

        lucide.createIcons();
        attachListeners();
    }

    function updateStats(s) {
        document.getElementById('stat-total').textContent = s.total;
        document.getElementById('stat-written').textContent = s.written;
        document.getElementById('stat-financial').textContent = s.financial;
        document.getElementById('stat-amount').textContent = s.total_amount.toFixed(2);
    }

    function attachListeners() {
        document.querySelectorAll('.btn-approve').forEach(btn => {
            btn.onclick = () => {
                confirmApprove('this penalty', () => {
                    fetch(`/hr/penalties/${btn.dataset.id}/approve`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken } })
                        .then(r => r.json()).then(d => { showSuccess(d.message); loadData(); });
                });
            };
        });
        document.querySelectorAll('.btn-reject').forEach(btn => {
            btn.onclick = () => {
                confirmReject('this penalty', (reason) => {
                    fetch(`/hr/penalties/${btn.dataset.id}/reject`, { 
                        method: 'POST', 
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
                        body: JSON.stringify({ reason: reason })
                    }).then(r => r.json()).then(d => { showSuccess(d.message); loadData(); });
                });
            };
        });
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.onclick = () => {
                confirmDelete('this penalty', () => {
                    fetch(`/hr/penalties/${btn.dataset.id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken } })
                        .then(r => r.json()).then(d => { showSuccess(d.message); loadData(); });
                });
            };
        });
    }

    // Type toggle
    document.getElementById('penalty-type').addEventListener('change', function() {
        const isFinancial = this.value === 'financial';
        document.getElementById('amount-field').style.display = isFinancial ? 'block' : 'none';
        document.getElementById('deduct-field').style.display = isFinancial ? 'block' : 'none';
    });

    // Add button
    document.getElementById('btn-add').onclick = () => {
        document.getElementById('penalty-form').reset();
        document.getElementById('penalty-id').value = '';
        document.getElementById('penalty-date').value = new Date().toISOString().split('T')[0];
        tailwind.Modal.getOrCreateInstance(document.getElementById('penalty-modal')).show();
    };

    // Form submit
    document.getElementById('penalty-form').onsubmit = function(e) {
        e.preventDefault();
        const id = document.getElementById('penalty-id').value;
        const url = id ? `/hr/penalties/${id}` : '{{ route("hr.penalties.store") }}';
        const method = id ? 'PUT' : 'POST';

        const formData = {
            employee_id: document.getElementById('penalty-employee').value,
            type: document.getElementById('penalty-type').value,
            category: document.getElementById('penalty-category').value,
            title: document.getElementById('penalty-title').value,
            amount: document.getElementById('penalty-amount').value || 0,
            penalty_date: document.getElementById('penalty-date').value,
            severity: document.getElementById('penalty-severity').value,
            deduct_from_salary: document.getElementById('penalty-deduct').checked,
            description: document.getElementById('penalty-description').value,
        };

        fetch(url, {
            method,
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(formData)
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                showSuccess(d.message);
                tailwind.Modal.getInstance(document.getElementById('penalty-modal')).hide();
                loadData();
            } else {
                showError(d.message || 'Validation error');
            }
        })
        .catch(err => showError('An error occurred'));
    };

    document.getElementById('btn-filter').onclick = loadData;
    loadData();
});
</script>
@endpush
