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
                <button type="button" class="btn-tonal btn-tonal--info" data-tw-toggle="modal" data-tw-target="#crm-activity-filters">
                    <x-base.lucide icon="Filter" class="w-4 h-4 mr-2" /> Filters
                </button>
                <button type="button" class="btn-tonal btn-tonal--success" data-tw-toggle="modal" data-tw-target="#crm-activity-create">
                    <x-base.lucide icon="CalendarPlus" class="w-4 h-4 mr-2" /> Log Activity
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
                    <button type="button" id="crm-activity-apply" class="btn-tonal btn-tonal--info">
                        <x-base.lucide icon="Search" class="w-4 h-4 mr-2" /> Apply
                    </button>
                    <button type="button" id="crm-activity-reset" class="btn-tonal btn-tonal--warning">
                        <x-base.lucide icon="RotateCcw" class="w-4 h-4 mr-2" /> Reset
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const table = $('#crm-activities-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('crm.activities.datatable') }}',
                    data: function (params) {
                        params.activity_type = document.getElementById('crm-activity-type').value;
                        params.status = document.getElementById('crm-activity-status').value;
                        params.company_id = document.getElementById('crm-activity-company').value;
                        params.lead_id = document.getElementById('crm-activity-lead').value;
                    }
                },
                columns: [
                    { data: 'subject', name: 'subject' },
                    { data: 'activity_type', name: 'activity_type' },
                    { data: 'company', name: 'company.name' },
                    { data: 'lead', name: 'lead.code' },
                    { data: 'opportunity', name: 'opportunity.code' },
                    { data: 'status', name: 'status' },
                    { data: 'scheduled_at', name: 'scheduled_at' },
                    { data: 'completed_at', name: 'completed_at' },
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

            document.getElementById('crm-activity-apply').addEventListener('click', () => table.ajax.reload());
            document.getElementById('crm-activity-reset').addEventListener('click', () => {
                document.getElementById('crm-activity-type').value = 'all';
                document.getElementById('crm-activity-status').value = 'all';
                document.getElementById('crm-activity-company').value = 'all';
                document.getElementById('crm-activity-lead').value = 'all';
                table.ajax.reload();
            });
        });
    </script>
@endpush
