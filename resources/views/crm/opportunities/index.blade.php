@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>CRM Opportunities - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
@include('components.global-notifications')
<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="target" class="w-7 h-7" />
            <span>CRM Opportunities</span>
        </h2>

        <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                        <x-base.lucide icon="layers" class="w-4 h-4" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight" style="color: #303030" id="stat-total">
                        {{ number_format($stats['total_opportunities']) }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">Total</div>
            </div>
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                        <x-base.lucide icon="activity" class="w-4 h-4" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-emerald-600" id="stat-open">
                        {{ number_format($stats['open_opportunities']) }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">Open</div>
            </div>
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                        <x-base.lucide icon="trophy" class="w-4 h-4" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-blue-600" id="stat-won">
                        {{ number_format($stats['won_opportunities']) }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">Won</div>
            </div>
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                        <x-base.lucide icon="calendar" class="w-4 h-4" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-indigo-600" id="stat-closing">
                        {{ number_format($stats['closing_this_quarter']) }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">Closing</div>
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
                            <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">Pipeline</label>
                            <x-base.form-select id="crm-opportunity-pipeline" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                <option value="all">All Pipelines</option>
                                @foreach ($pipelines as $pipeline)
                                    <option value="{{ $pipeline->id }}">{{ $pipeline->name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                            <label class="mr-2 w-12 flex-none xl:w-auto xl:flex-initial">Stage</label>
                            <x-base.form-select id="crm-opportunity-stage" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                <option value="all">All Stages</option>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}" data-pipeline="{{ $stage->pipeline_id }}">{{ $stage->name }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                            <label class="mr-2 w-12 flex-none xl:w-auto xl:flex-initial">Status</label>
                            <x-base.form-select id="crm-opportunity-status" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                <option value="all">All Status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}">{{ Str::headline($status) }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="mt-2 xl:mt-0">
                            <button type="button" id="crm-opportunity-apply" class="btn-royal btn-royal--dark btn-royal--sm">
                                <x-base.lucide icon="search" class="w-4 h-4" /> Apply
                            </button>
                        </div>
                    </form>
                    <div class="mt-5 flex sm:mt-0">
                        <button id="btn-add" class="btn-royal btn-royal--gold btn-royal--sm" data-tw-toggle="modal" data-tw-target="#crm-opportunity-create">
                            <x-base.lucide icon="plus" class="w-4 h-4" /> New Opportunity
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto sm:overflow-visible mt-5" data-erp-table-wrapper>
                    <table id="crm-opportunities-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Pipeline</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Stage</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Company</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">Amount</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Probability</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Expected Close</th>
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

@include('crm.opportunities.partials.create-modal')
@endsection

@include('components.datatable.scripts')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const stagesSelect = document.getElementById('crm-opportunity-stage');
    const pipelineSelect = document.getElementById('crm-opportunity-pipeline');
    const statusFilter = document.getElementById('crm-opportunity-status');
    const applyBtn = document.getElementById('crm-opportunity-apply');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Filter stages based on pipeline selection
    if (pipelineSelect) {
        pipelineSelect.addEventListener('change', function () {
            const selectedPipeline = pipelineSelect.value;
            [...stagesSelect.options].forEach(function (option) {
                if (option.value === 'all') {
                    option.hidden = false;
                    return;
                }
                const pipeline = option.getAttribute('data-pipeline');
                option.hidden = selectedPipeline !== 'all' && pipeline !== selectedPipeline;
            });
            stagesSelect.value = 'all';
        });
    }

    const table = window.erpCrud.initDataTable({
        tableSelector: '#crm-opportunities-table',
        ajaxUrl: '{{ route("crm.opportunities.datatable") }}',
        ajaxData: function (d) {
            d.pipeline_id = pipelineSelect ? pipelineSelect.value : 'all';
            d.stage_id = stagesSelect ? stagesSelect.value : 'all';
            d.status = statusFilter ? statusFilter.value : 'all';
        },
        pageLength: 25,
        columns: [
            { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium whitespace-nowrap' },
            { data: 'title', name: 'title', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
            { data: 'pipeline', name: 'pipeline.name', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
            { data: 'stage', name: 'stage.name', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
            { data: 'company', name: 'company.name', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
            { data: 'amount', name: 'amount', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-right' },
            { data: 'probability', name: 'probability', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center' },
            { data: 'expected_close_date', name: 'expected_close_date', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center' },
            {
                data: 'id',
                name: 'actions',
                orderable: false,
                searchable: false,
                className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                render: function (data, type, row) {
                    return `
                        <div class="flex justify-center gap-1">
                            <button class="btn-action-edit p-1.5 rounded hover:bg-blue-50 text-blue-600 hover:text-blue-800 transition-colors" data-action="edit" data-id="${data}" title="Edit">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </button>
                            <button class="btn-action-delete p-1.5 rounded hover:bg-red-50 text-slate-500 hover:text-red-600 transition-colors" data-action="delete" data-id="${data}" data-name="${row.title || ''}" title="Delete">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ]
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

    // Handle table actions
    document.querySelector('#crm-opportunities-table').addEventListener('click', function (e) {
        const editBtn = e.target.closest('[data-action="edit"]');
        const deleteBtn = e.target.closest('[data-action="delete"]');

        if (editBtn) {
            const id = editBtn.dataset.id;
            window.location.href = '{{ url("crm/opportunities") }}/' + id + '/edit';
        }

        if (deleteBtn) {
            const id = deleteBtn.dataset.id;
            const name = deleteBtn.dataset.name || 'this opportunity';

            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, () => {
                    fetch('{{ url("crm/opportunities") }}/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess(data.message || 'Opportunity deleted successfully.');
                            }
                            table.ajax.reload();
                        } else {
                            if (typeof window.showError === 'function') {
                                window.showError(data.message || 'Failed to delete opportunity.');
                            }
                        }
                    })
                    .catch(() => {
                        if (typeof window.showError === 'function') {
                            window.showError('An error occurred while deleting.');
                        }
                    });
                });
            }
        }
    });
});
</script>
@endpush
