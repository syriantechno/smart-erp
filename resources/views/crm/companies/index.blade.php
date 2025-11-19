@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>CRM Companies - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <style>
        .crm-metric-card {
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(16, 185, 129, 0.15));
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
                <h2 class="text-lg font-semibold leading-tight">CRM Companies</h2>
                <p class="text-slate-500">Centralize clients, track activities, and collaborate with sales.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button" class="btn-tonal btn-tonal--info" data-tw-toggle="modal" data-tw-target="#crm-company-filters" aria-label="Open filters">
                    <x-base.lucide icon="Filter" class="w-4 h-4 mr-2" />
                    Advanced Filters
                </button>
                <button type="button" class="btn-tonal btn-tonal--success" data-tw-toggle="modal" data-tw-target="#crm-company-create" aria-label="Add company">
                    <x-base.lucide icon="Building2" class="w-4 h-4 mr-2" />
                    New Company
                </button>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-5">
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Total Companies</span>
                        <x-base.lucide icon="Building" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold">{{ number_format($stats['total_companies']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Active Accounts</span>
                        <x-base.lucide icon="Activity" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-emerald-600">{{ number_format($stats['active_companies']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Open Opportunities</span>
                        <x-base.lucide icon="Target" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-blue-600">{{ number_format($stats['with_open_opportunities']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Active in 30 days</span>
                        <x-base.lucide icon="Clock" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-indigo-600">{{ number_format($stats['with_recent_activity']) }}</div>
                </div>
            </div>
        </div>

        <div class="intro-y box p-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end">
                <div class="flex flex-col gap-2 lg:flex-row lg:items-center">
                    <label class="text-sm font-medium">Status</label>
                    <x-base.form-select id="crm-company-status" class="crm-filter-pill">
                        <option value="all">All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="prospect">Prospect</option>
                    </x-base.form-select>
                </div>
                <div class="flex flex-col gap-2 lg:flex-row lg:items-center">
                    <label class="text-sm font-medium">Industry</label>
                    <x-base.form-select id="crm-company-industry" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($industries as $industry)
                            <option value="{{ $industry }}">{{ $industry }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="flex gap-3">
                    <button type="button" id="crm-company-apply" class="btn-tonal btn-tonal--info">
                        <x-base.lucide icon="Search" class="w-4 h-4 mr-2" /> Apply
                    </button>
                    <button type="button" id="crm-company-reset" class="btn-tonal btn-tonal--warning">
                        <x-base.lucide icon="RotateCcw" class="w-4 h-4 mr-2" /> Reset
                    </button>
                </div>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table id="crm-companies-table" class="datatable-default w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th class="px-5 py-3">Name</th>
                            <th class="px-5 py-3">Industry</th>
                            <th class="px-5 py-3">Email</th>
                            <th class="px-5 py-3">Phone</th>
                            <th class="px-5 py-3">Contacts</th>
                            <th class="px-5 py-3">Leads</th>
                            <th class="px-5 py-3">Opportunities</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @include('crm.companies.partials.create-modal')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const table = $('#crm-companies-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('crm.companies.datatable') }}',
                    data: function (params) {
                        params.status = document.getElementById('crm-company-status').value;
                        params.industry = document.getElementById('crm-company-industry').value;
                    }
                },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'industry', name: 'industry' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'contacts_count', name: 'contacts_count', className: 'text-center' },
                    { data: 'leads_count', name: 'leads_count', className: 'text-center' },
                    { data: 'opportunities_count', name: 'opportunities_count', className: 'text-center' },
                    { data: 'status', name: 'status' },
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

            document.getElementById('crm-company-apply').addEventListener('click', () => table.ajax.reload());
            document.getElementById('crm-company-reset').addEventListener('click', () => {
                document.getElementById('crm-company-status').value = 'all';
                document.getElementById('crm-company-industry').value = 'all';
                table.ajax.reload();
            });
        });
    </script>
@endpush
