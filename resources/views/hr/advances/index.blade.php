@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Advances & Loans - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
@include('components.global-notifications')
<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="hand-coins" class="w-7 h-7" />
            <span>Advances & Loans</span>
        </h2>

        <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
            <div class="flex flex-col items-center gap-1">
                <div class="text-4xl md:text-5xl font-semibold tracking-tight" style="color: #303030" id="stat-total">0</div>
                <div class="text-xs uppercase tracking-[0.25em] text-slate-600">Total</div>
            </div>
            <div class="flex flex-col items-center gap-1">
                <div class="text-4xl md:text-5xl font-semibold tracking-tight text-blue-600" id="stat-amount">0</div>
                <div class="text-xs uppercase tracking-[0.25em] text-slate-600">Total Amount</div>
            </div>
            <div class="flex flex-col items-center gap-1">
                <div class="text-4xl md:text-5xl font-semibold tracking-tight text-orange-600" id="stat-remaining">0</div>
                <div class="text-xs uppercase tracking-[0.25em] text-slate-600">Remaining</div>
            </div>
            <div class="flex flex-col items-center gap-1">
                <div class="text-4xl md:text-5xl font-semibold tracking-tight text-green-600" id="stat-active">0</div>
                <div class="text-xs uppercase tracking-[0.25em] text-slate-600">Active</div>
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
                                <option value="salary_advance">Salary Advance</option>
                                <option value="loan">Loan</option>
                            </x-base.form-select>
                        </div>
                        <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                            <label class="mr-2 w-12 flex-none xl:w-auto xl:flex-initial">Status</label>
                            <x-base.form-select id="filter-status" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="disbursed">Disbursed</option>
                                <option value="completed">Completed</option>
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
                        <x-base.tippy content="New advance request" placement="bottom">
                            <button id="btn-add" type="button" class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group">
                                <x-base.lucide icon="plus" class="w-4 h-4 mr-2 icon-hover-rise" />
                                <span class="hidden sm:inline">Add</span>
                            </button>
                        </x-base.tippy>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto sm:overflow-visible mt-5" data-erp-table-wrapper>
                    <table id="advances-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Employee</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Type</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Amount</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Installments</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Monthly</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Remaining</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Progress</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="advances-tbody"></tbody>
                    </table>
                </div>
            </div>
        </x-base.preview-component>
    </div>
</div>

{{-- Add/Edit Modal --}}
<x-modal.form id="advance-modal" title="New Advance Request" size="lg">
    <form id="advance-form">
        <input type="hidden" id="advance-id" name="id">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>Employee <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="advance-employee" name="employee_id" required>
                    <option value="">Select Employee</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->full_name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>Type <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-select id="advance-type" name="type" required>
                    <option value="salary_advance">Salary Advance</option>
                    <option value="loan">Loan</option>
                </x-base.form-select>
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>Amount <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input type="number" id="advance-amount" name="amount" step="0.01" min="1" required />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>Installments <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input type="number" id="advance-installments" name="installments" min="1" max="60" value="1" required />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>Start Deduction Date <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input type="date" id="advance-start-date" name="start_deduction_date" required />
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label>Monthly Installment</x-base.form-label>
                <div class="p-2 bg-slate-100 rounded font-bold text-lg" id="monthly-preview">0.00</div>
            </div>
            <div class="col-span-12">
                <x-base.form-label>Reason</x-base.form-label>
                <x-base.form-textarea id="advance-reason" name="reason" rows="3" />
            </div>
        </div>
    </form>
    @slot('footer')
        <button type="button" class="btn-royal btn-royal--outline" data-tw-dismiss="modal">Cancel</button>
        <button type="submit" form="advance-form" class="btn-royal btn-royal--gold">Save</button>
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

        fetch(`{{ route('hr.advances.data') }}?${params}`)
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    renderTable(data.data);
                    updateStats(data.summary);
                }
            });
    }

    function renderTable(items) {
        const tbody = document.getElementById('advances-tbody');
        if (!items.length) {
            tbody.innerHTML = '<tr><td colspan="9" class="text-center py-8 text-slate-500">No advances found</td></tr>';
            return;
        }

        const statusConfig = {
            pending: { color: 'text-amber-600', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>', label: 'Pending' },
            approved: { color: 'text-sky-600', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>', label: 'Approved' },
            rejected: { color: 'text-rose-500', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>', label: 'Rejected' },
            disbursed: { color: 'text-violet-600', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>', label: 'Disbursed' },
            completed: { color: 'text-lime-600', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>', label: 'Completed' },
            cancelled: { color: 'text-slate-500', icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>', label: 'Cancelled' }
        };

        tbody.innerHTML = items.map(a => `
            <tr data-tw-merge class="[&_td]:last:border-b-0 intro-x">
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                    <div class="font-medium whitespace-nowrap">${a.employee.name}</div>
                    <div class="text-xs text-slate-500 mt-0.5">${a.employee.department}</div>
                </td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                    <span class="inline-flex items-center text-sm font-semibold ${a.type === 'loan' ? 'text-violet-600' : 'text-sky-600'}">
                        ${a.type === 'loan' 
                            ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>'
                            : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>'
                        }
                        ${a.type_label}
                    </span>
                </td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-right font-medium">${parseFloat(a.amount).toFixed(2)}</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">${a.paid_installments} / ${a.installments}</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-right">${parseFloat(a.installment_amount).toFixed(2)}</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-right font-medium text-orange-600">${parseFloat(a.remaining_amount).toFixed(2)}</td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                    <div class="w-full bg-slate-200 rounded-full h-2">
                        <div class="bg-lime-500 h-2 rounded-full" style="width: ${a.progress_percent}%"></div>
                    </div>
                    <div class="text-xs text-center mt-1 text-slate-500">${a.progress_percent}%</div>
                </td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                    <span class="inline-flex items-center text-base font-semibold ${statusConfig[a.status]?.color || 'text-slate-500'}">
                        ${statusConfig[a.status]?.icon || ''}
                        ${statusConfig[a.status]?.label || a.status}
                    </span>
                </td>
                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                    <div class="flex justify-center gap-1">
                        ${a.status === 'pending' ? `
                            <button class="btn-approve p-1.5 rounded hover:bg-green-50 text-green-600 hover:text-green-800 transition-colors" data-id="${a.id}" title="Approve"><i data-lucide="check" class="w-4 h-4"></i></button>
                            <button class="btn-reject p-1.5 rounded hover:bg-red-50 text-red-600 hover:text-red-800 transition-colors" data-id="${a.id}" title="Reject"><i data-lucide="x" class="w-4 h-4"></i></button>
                        ` : ''}
                        ${a.status === 'approved' ? `
                            <button class="btn-disburse p-1.5 rounded hover:bg-purple-50 text-purple-600 hover:text-purple-800 transition-colors" data-id="${a.id}" title="Disburse"><i data-lucide="banknote" class="w-4 h-4"></i></button>
                        ` : ''}
                        ${a.paid_installments === 0 ? `
                            <button class="btn-delete p-1.5 rounded hover:bg-red-50 text-slate-500 hover:text-red-600 transition-colors" data-id="${a.id}" title="Delete"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                        ` : ''}
                    </div>
                </td>
            </tr>
        `).join('');

        lucide.createIcons();
        attachListeners();
    }

    function updateStats(s) {
        document.getElementById('stat-total').textContent = s.total;
        document.getElementById('stat-amount').textContent = parseFloat(s.total_amount).toFixed(0);
        document.getElementById('stat-remaining').textContent = parseFloat(s.total_remaining).toFixed(0);
        document.getElementById('stat-active').textContent = s.active;
    }

    function attachListeners() {
        document.querySelectorAll('.btn-approve').forEach(btn => {
            btn.onclick = () => {
                confirmApprove('this advance request', () => {
                    fetch(`/hr/advances/${btn.dataset.id}/approve`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken } })
                        .then(r => r.json()).then(d => { showSuccess(d.message); loadData(); });
                });
            };
        });
        document.querySelectorAll('.btn-reject').forEach(btn => {
            btn.onclick = () => {
                confirmReject('this advance request', (reason) => {
                    fetch(`/hr/advances/${btn.dataset.id}/reject`, { 
                        method: 'POST', 
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
                        body: JSON.stringify({ reason: reason })
                    }).then(r => r.json()).then(d => { showSuccess(d.message); loadData(); });
                });
            };
        });
        document.querySelectorAll('.btn-disburse').forEach(btn => {
            btn.onclick = () => {
                confirmPayment('this advance', () => {
                    fetch(`/hr/advances/${btn.dataset.id}/disburse`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken } })
                        .then(r => r.json()).then(d => { showSuccess(d.message); loadData(); });
                });
            };
        });
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.onclick = () => {
                confirmDelete('this advance', () => {
                    fetch(`/hr/advances/${btn.dataset.id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken } })
                        .then(r => r.json()).then(d => { showSuccess(d.message); loadData(); });
                });
            };
        });
    }

    // Calculate monthly installment
    function updateMonthly() {
        const amount = parseFloat(document.getElementById('advance-amount').value) || 0;
        const installments = parseInt(document.getElementById('advance-installments').value) || 1;
        document.getElementById('monthly-preview').textContent = (amount / installments).toFixed(2);
    }
    document.getElementById('advance-amount').addEventListener('input', updateMonthly);
    document.getElementById('advance-installments').addEventListener('input', updateMonthly);

    // Add button
    document.getElementById('btn-add').onclick = () => {
        document.getElementById('advance-form').reset();
        document.getElementById('advance-id').value = '';
        const nextMonth = new Date();
        nextMonth.setMonth(nextMonth.getMonth() + 1);
        nextMonth.setDate(1);
        document.getElementById('advance-start-date').value = nextMonth.toISOString().split('T')[0];
        updateMonthly();
        tailwind.Modal.getOrCreateInstance(document.getElementById('advance-modal')).show();
    };

    // Form submit
    document.getElementById('advance-form').onsubmit = function(e) {
        e.preventDefault();
        const id = document.getElementById('advance-id').value;
        const url = id ? `/hr/advances/${id}` : '{{ route("hr.advances.store") }}';
        const method = id ? 'PUT' : 'POST';

        const formData = {
            employee_id: document.getElementById('advance-employee').value,
            type: document.getElementById('advance-type').value,
            amount: document.getElementById('advance-amount').value,
            installments: document.getElementById('advance-installments').value,
            start_deduction_date: document.getElementById('advance-start-date').value,
            reason: document.getElementById('advance-reason').value,
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
                tailwind.Modal.getInstance(document.getElementById('advance-modal')).hide();
                loadData();
            } else {
                showError(d.message || 'Validation error');
            }
        });
    };

    document.getElementById('btn-filter').onclick = loadData;
    loadData();
});
</script>
@endpush
