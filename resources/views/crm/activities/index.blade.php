@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>CRM Activities - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <style>
        .crm-metric-card {
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.95), rgba(226, 232, 240, 0.8));
            border: 1px solid rgba(148, 163, 184, 0.35);
            padding: 1.25rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .crm-metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 35px rgba(15, 23, 42, 0.08);
        }

        .crm-filter-pill {
            border-radius: 9999px;
            border: 1px solid rgba(148, 163, 184, 0.4);
            padding: 0.35rem 0.85rem;
        }
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold leading-tight">CRM Activities</h2>
                <p class="text-slate-500">Track every call, email, meeting, and task across leads and opportunities.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm" data-tw-toggle="modal" data-tw-target="#crm-activity-filters">
                    <x-base.lucide icon="filter" class="w-4 h-4" /> Filters
                </button>
                <button type="button" class="btn-royal btn-royal--gold btn-royal--sm" data-tw-toggle="modal" data-tw-target="#crm-activity-create">
                    <x-base.lucide icon="calendar-plus" class="w-4 h-4" /> Log Activity
                </button>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-5">
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Total Activities</span>
                        <x-base.lucide icon="LayoutList" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold">{{ number_format($stats['total_activities']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Scheduled Today</span>
                        <x-base.lucide icon="CalendarCheck" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-emerald-600">{{ number_format($stats['scheduled_today']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Overdue</span>
                        <x-base.lucide icon="AlertTriangle" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-orange-600">{{ number_format($stats['overdue']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Completed This Week</span>
                        <x-base.lucide icon="CheckCircle2" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-indigo-600">{{ number_format($stats['completed_this_week']) }}</div>
                </div>
            </div>
        </div>

        <div class="intro-y box p-5">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 lg:col-span-3 flex flex-col gap-2">
                    <label class="text-sm font-medium">Activity Type</label>
                    <x-base.form-select id="crm-activity-type" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($activityTypes as $type)
                            <option value="{{ $type }}">{{ Str::headline($type) }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 lg:col-span-3 flex flex-col gap-2">
                    <label class="text-sm font-medium">Status</label>
                    <x-base.form-select id="crm-activity-status" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}">{{ Str::headline($status) }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 lg:col-span-3 flex flex-col gap-2">
                    <label class="text-sm font-medium">Company</label>
                    <x-base.form-select id="crm-activity-company" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 lg:col-span-3 flex flex-col gap-2">
                    <label class="text-sm font-medium">Lead</label>
                    <x-base.form-select id="crm-activity-lead" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($leads as $lead)
                            <option value="{{ $lead->id }}">{{ $lead->code }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 flex gap-3">
                    <button type="button" id="crm-activity-apply" class="btn-royal btn-royal--dark btn-royal--sm">
                        <x-base.lucide icon="search" class="w-4 h-4" /> Apply
                    </button>
                    <button type="button" id="crm-activity-reset" class="btn-royal btn-royal--outline btn-royal--sm">
                        <x-base.lucide icon="rotate-ccw" class="w-4 h-4" /> Reset
                    </button>
                </div>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table id="crm-activities-table" class="datatable-default w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th class="px-5 py-3">Subject</th>
                            <th class="px-5 py-3">Type</th>
                            <th class="px-5 py-3">Company</th>
                            <th class="px-5 py-3">Lead</th>
                            <th class="px-5 py-3">Opportunity</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Scheduled</th>
                            <th class="px-5 py-3">Completed</th>
                            <th class="px-5 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @include('crm.activities.partials.create-modal')
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeFilter = document.getElementById('crm-activity-type');
            const statusFilter = document.getElementById('crm-activity-status');
            const companyFilter = document.getElementById('crm-activity-company');
            const leadFilter = document.getElementById('crm-activity-lead');
            const applyBtn = document.getElementById('crm-activity-apply');
            const resetBtn = document.getElementById('crm-activity-reset');

            const table = window.erpCrud.initDataTable({
                tableSelector: '#crm-activities-table',
                ajaxUrl: '{{ route("crm.activities.datatable") }}',
                ajaxData: function (d) {
                    d.activity_type = typeFilter ? typeFilter.value : 'all';
                    d.status = statusFilter ? statusFilter.value : 'all';
                    d.company_id = companyFilter ? companyFilter.value : 'all';
                    d.lead_id = leadFilter ? leadFilter.value : 'all';
                },
                pageLength: 25,
                columns: [
                    { data: 'subject', name: 'subject', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700' },
                    { data: 'activity_type', name: 'activity_type', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center' },
                    { data: 'company', name: 'company.name', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'lead', name: 'lead.code', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'opportunity', name: 'opportunity.code', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'status', name: 'status', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center' },
                    { data: 'scheduled_at', name: 'scheduled_at', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center' },
                    { data: 'completed_at', name: 'completed_at', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center' },
                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        render: function (data, type, row) {
                            return `
                                <div class="flex items-center justify-center gap-2">
                                    <button class="btn-royal btn-royal--action btn-royal--primary" data-action="edit" data-id="${data}" title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button class="btn-royal btn-royal--action btn-royal--danger" data-action="delete" data-id="${data}" data-name="${row.subject || ''}" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                drawCallback: function () {
                    if (typeof window.lucide !== 'undefined') {
                        window.lucide.createIcons();
                    }
                }
            });

            if (!table) {
                console.error('Failed to initialize DataTable');
                return;
            }

            // Apply filters
            if (applyBtn) {
                applyBtn.addEventListener('click', function () {
                    table.ajax.reload();
                });
            }

            // Reset filters
            if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    if (typeFilter) typeFilter.value = 'all';
                    if (statusFilter) statusFilter.value = 'all';
                    if (companyFilter) companyFilter.value = 'all';
                    if (leadFilter) leadFilter.value = 'all';
                    table.ajax.reload();
                });
            }

            // Handle actions
            document.querySelector('#crm-activities-table').addEventListener('click', function (e) {
                const editBtn = e.target.closest('[data-action="edit"]');
                const deleteBtn = e.target.closest('[data-action="delete"]');

                if (editBtn) {
                    const id = editBtn.dataset.id;
                    window.location.href = '{{ url("crm/activities") }}/' + id + '/edit';
                }

                if (deleteBtn) {
                    const id = deleteBtn.dataset.id;
                    const name = deleteBtn.dataset.name || 'this activity';

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to delete "${name}". This action cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('{{ url("crm/activities") }}/' + id, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Deleted!', data.message || 'Activity deleted successfully.', 'success');
                                    table.ajax.reload();
                                } else {
                                    Swal.fire('Error!', data.message || 'Failed to delete activity.', 'error');
                                }
                            })
                            .catch(() => {
                                Swal.fire('Error!', 'An error occurred while deleting.', 'error');
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
