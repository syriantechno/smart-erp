@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@php
    use Illuminate\Support\Str;
@endphp

@section('subhead')
    <title>CRM Tasks - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <style>
        .crm-metric-card {
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(236, 72, 153, 0.12));
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
                <h2 class="text-lg font-semibold leading-tight">CRM Tasks</h2>
                <p class="text-slate-500">Stay on top of every follow-up item tied to leads and opportunities.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button" class="btn-tonal btn-tonal--info" data-tw-toggle="modal" data-tw-target="#crm-task-filters">
                    <x-base.lucide icon="Filter" class="w-4 h-4 mr-2" /> Filters
                </button>
                <button type="button" class="btn-tonal btn-tonal--success" data-tw-toggle="modal" data-tw-target="#crm-task-create">
                    <x-base.lucide icon="CheckSquare" class="w-4 h-4 mr-2" /> New Task
                </button>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-5">
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Total Tasks</span>
                        <x-base.lucide icon="ListChecks" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold">{{ number_format($stats['total_tasks']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Open</span>
                        <x-base.lucide icon="Activity" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-emerald-600">{{ number_format($stats['open_tasks']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Overdue</span>
                        <x-base.lucide icon="AlertTriangle" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-orange-600">{{ number_format($stats['overdue_tasks']) }}</div>
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
                    <label class="text-sm font-medium">Status</label>
                    <x-base.form-select id="crm-task-status" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}">{{ Str::headline($status) }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 lg:col-span-3 flex flex-col gap-2">
                    <label class="text-sm font-medium">Priority</label>
                    <x-base.form-select id="crm-task-priority" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($priorities as $priority)
                            <option value="{{ $priority }}">{{ Str::headline($priority) }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 lg:col-span-3 flex flex-col gap-2">
                    <label class="text-sm font-medium">Company</label>
                    <x-base.form-select id="crm-task-company" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 lg:col-span-3 flex flex-col gap-2">
                    <label class="text-sm font-medium">Lead</label>
                    <x-base.form-select id="crm-task-lead" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($leads as $lead)
                            <option value="{{ $lead->id }}">{{ $lead->code }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 flex gap-3">
                    <button type="button" id="crm-task-apply" class="btn-tonal btn-tonal--info">
                        <x-base.lucide icon="Search" class="w-4 h-4 mr-2" /> Apply
                    </button>
                    <button type="button" id="crm-task-reset" class="btn-tonal btn-tonal--warning">
                        <x-base.lucide icon="RotateCcw" class="w-4 h-4 mr-2" /> Reset
                    </button>
                </div>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table id="crm-tasks-table" class="datatable-default w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th class="px-5 py-3">Title</th>
                            <th class="px-5 py-3">Priority</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Company</th>
                            <th class="px-5 py-3">Lead</th>
                            <th class="px-5 py-3">Opportunity</th>
                            <th class="px-5 py-3">Due Date</th>
                            <th class="px-5 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @include('crm.tasks.partials.create-modal')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const table = $('#crm-tasks-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('crm.tasks.datatable') }}',
                    data: function (params) {
                        params.status = document.getElementById('crm-task-status').value;
                        params.priority = document.getElementById('crm-task-priority').value;
                        params.company_id = document.getElementById('crm-task-company').value;
                        params.lead_id = document.getElementById('crm-task-lead').value;
                        params.opportunity_id = document.getElementById('crm-task-opportunity')?.value || 'all';
                    }
                },
                columns: [
                    { data: 'title', name: 'title' },
                    { data: 'priority', name: 'priority' },
                    { data: 'status', name: 'status' },
                    { data: 'company', name: 'company.name' },
                    { data: 'lead', name: 'lead.code' },
                    { data: 'opportunity', name: 'opportunity.code' },
                    { data: 'due_date', name: 'due_date' },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: (id) => `
                            <div class="flex items-center justify-center gap-2">
                                <button class="text-primary" data-action="edit" data-id="${id}">
                                    <x-base.lucide icon="Edit" class="w-4 h-4" />
                                </button>
                                <button class="text-danger" data-action="delete" data-id="${id}">
                                    <x-base.lucide icon="Trash" class="w-4 h-4" />
                                </button>
                            </div>
                        `
                    }
                ]
            });

            document.getElementById('crm-task-apply').addEventListener('click', () => table.ajax.reload());
            document.getElementById('crm-task-reset').addEventListener('click', () => {
                document.getElementById('crm-task-status').value = 'all';
                document.getElementById('crm-task-priority').value = 'all';
                document.getElementById('crm-task-company').value = 'all';
                document.getElementById('crm-task-lead').value = 'all';
                table.ajax.reload();
            });
        });
    </script>
@endpush
