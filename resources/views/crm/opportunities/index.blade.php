@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>CRM Opportunities - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <style>
        .crm-metric-card {
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.15), rgba(16, 185, 129, 0.15));
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
                <h2 class="text-lg font-semibold leading-tight">CRM Opportunities</h2>
                <p class="text-slate-500">Monitor deals, follow pipeline progress, and focus on closing revenue.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button" class="btn-tonal btn-tonal--info" data-tw-toggle="modal" data-tw-target="#crm-opportunity-filters">
                    <x-base.lucide icon="Filter" class="w-4 h-4 mr-2" /> Filters
                </button>
                <button type="button" class="btn-tonal btn-tonal--success" data-tw-toggle="modal" data-tw-target="#crm-opportunity-create">
                    <x-base.lucide icon="Target" class="w-4 h-4 mr-2" /> New Opportunity
                </button>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-5">
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Total Opportunities</span>
                        <x-base.lucide icon="Layers" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold">{{ number_format($stats['total_opportunities']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Open</span>
                        <x-base.lucide icon="Activity" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-emerald-600">{{ number_format($stats['open_opportunities']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Won</span>
                        <x-base.lucide icon="Trophy" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-blue-600">{{ number_format($stats['won_opportunities']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Closing This Quarter</span>
                        <x-base.lucide icon="Calendar" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-indigo-600">{{ number_format($stats['closing_this_quarter']) }}</div>
                </div>
            </div>
        </div>

        <div class="intro-y box p-5">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 lg:col-span-4 flex flex-col gap-2">
                    <label class="text-sm font-medium">Pipeline</label>
                    <x-base.form-select id="crm-opportunity-pipeline" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($pipelines as $pipeline)
                            <option value="{{ $pipeline->id }}">{{ $pipeline->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 lg:col-span-4 flex flex-col gap-2">
                    <label class="text-sm font-medium">Stage</label>
                    <x-base.form-select id="crm-opportunity-stage" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($stages as $stage)
                            <option value="{{ $stage->id }}" data-pipeline="{{ $stage->pipeline_id }}">{{ $stage->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 lg:col-span-4 flex flex-col gap-2">
                    <label class="text-sm font-medium">Status</label>
                    <x-base.form-select id="crm-opportunity-status" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}">{{ Str::headline($status) }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 flex gap-3">
                    <button type="button" id="crm-opportunity-apply" class="btn-tonal btn-tonal--info">
                        <x-base.lucide icon="Search" class="w-4 h-4 mr-2" /> Apply
                    </button>
                    <button type="button" id="crm-opportunity-reset" class="btn-tonal btn-tonal--warning">
                        <x-base.lucide icon="RotateCcw" class="w-4 h-4 mr-2" /> Reset
                    </button>
                </div>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table id="crm-opportunities-table" class="datatable-default w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th class="px-5 py-3">Code</th>
                            <th class="px-5 py-3">Title</th>
                            <th class="px-5 py-3">Pipeline</th>
                            <th class="px-5 py-3">Stage</th>
                            <th class="px-5 py-3">Company</th>
                            <th class="px-5 py-3">Amount</th>
                            <th class="px-5 py-3">Probability</th>
                            <th class="px-5 py-3">Expected Close</th>
                            <th class="px-5 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @include('crm.opportunities.partials.create-modal')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stagesSelect = document.getElementById('crm-opportunity-stage');
            const pipelineSelect = document.getElementById('crm-opportunity-pipeline');

            pipelineSelect.addEventListener('change', () => {
                const selectedPipeline = pipelineSelect.value;
                [...stagesSelect.options].forEach((option) => {
                    if (option.value === 'all') {
                        option.hidden = false;
                        return;
                    }
                    const pipeline = option.getAttribute('data-pipeline');
                    option.hidden = selectedPipeline !== 'all' && pipeline !== selectedPipeline;
                });
                stagesSelect.value = 'all';
            });

            const table = $('#crm-opportunities-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('crm.opportunities.datatable') }}',
                    data: function (params) {
                        params.pipeline_id = pipelineSelect.value;
                        params.stage_id = stagesSelect.value;
                        params.status = document.getElementById('crm-opportunity-status').value;
                    }
                },
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'title', name: 'title' },
                    { data: 'pipeline', name: 'pipeline.name' },
                    { data: 'stage', name: 'stage.name' },
                    { data: 'company', name: 'company.name' },
                    { data: 'amount', name: 'amount' },
                    { data: 'probability', name: 'probability' },
                    { data: 'expected_close_date', name: 'expected_close_date' },
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

            document.getElementById('crm-opportunity-apply').addEventListener('click', () => table.ajax.reload());
            document.getElementById('crm-opportunity-reset').addEventListener('click', () => {
                pipelineSelect.value = 'all';
                stagesSelect.value = 'all';
                document.getElementById('crm-opportunity-status').value = 'all';
                [...stagesSelect.options].forEach(option => option.hidden = false);
                table.ajax.reload();
            });
        });
    </script>
@endpush
